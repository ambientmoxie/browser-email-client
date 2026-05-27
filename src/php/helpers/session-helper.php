<?php

/**
 * Custom session storage to avoid session loss on load-balanced servers,
 * where /tmp is not shared across nodes — based on https://dnada.fr/bug/perte_session_ovh.html
 *
 * - `CustomSession` stores session files in a custom directory.
 * - `SessionHelper` configures and starts the session using `CustomSession`.
 */

class CustomSession implements SessionHandlerInterface
{
    private $path;

    public function open($path, $sessionName): bool
    {
        $this->path = $path . '/sess_';

        if (!is_dir($path)) {
            mkdir($path, 0777);
            return is_dir($path);
        }
        return true;
    }

    private function id_to_filename($id)
    {
        return preg_replace('{\W}', '-', $id) ? $this->path . $id : false;
    }

    #[\ReturnTypeWillChange]
    public function read($id)
    {
        $filename = $this->id_to_filename($id);
        return ($filename && file_exists($filename)) ? (string)file_get_contents($filename) : '';
    }

    public function write($id, $data): bool
    {
        $filename = $this->id_to_filename($id);
        return $filename ? file_put_contents($filename, $data) !== false : false;
    }

    public function destroy($id): bool
    {
        $filename = $this->id_to_filename($id);
        if (!$filename || !file_exists($filename))
            return false;
        unlink($filename);
        return true;
    }

    #[\ReturnTypeWillChange]
    public function gc($maxlifetime)
    {
        $deadline = time() - $maxlifetime;
        foreach (glob($this->path . '*') as $file)
            if (filemtime($file) < $deadline)
                unlink($file);
        return true;
    }

    public function close(): bool
    {
        return true;
    }
}

class SessionHelper
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_save_handler(new CustomSession(), true);
            session_save_path(__DIR__ . '/../../../sessions');

            ini_set('session.gc_maxlifetime', 604800);

            session_set_cookie_params([
                'lifetime' => 604800,
                'path'     => '/',
                'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            session_start();
        }
    }

    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            }

            session_destroy();
        }
    }
}

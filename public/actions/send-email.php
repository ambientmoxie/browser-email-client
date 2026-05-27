<?php
require_once __DIR__ . '/../../src/php/helpers/session-helper.php';
require_once __DIR__ . '/../../src/php/helpers/env-loader.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

SessionHelper::start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$emails = $_SESSION['emails'] ?? [];
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($emails)) {
    echo '<span class="feedback feedback--error">No recipients. Add at least one email address first.</span>';
    exit;
}

if ($subject === '' || $message === '') {
    echo '<span class="feedback feedback--error">Subject and message cannot be empty.</span>';
    exit;
}

$sent = [];
$errors = [];

foreach ($emails as $email) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USERNAME'];
        $mail->Password   = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['SMTP_PORT'];
        $mail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);

        $mail->addAddress($email);
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        $sent[] = $email;
    } catch (Exception $e) {
        $errors[] = $email . ': ' . $mail->ErrorInfo;
    }
}

if (!empty($sent)) {
    $count = count($sent);
    $label = $count === 1 ? 'Email successfully sent to: ' : $count . ' emails successfully sent to: ';
    $label .= htmlspecialchars(implode(', ', $sent));
    echo '<span class="feedback feedback--success">' . $label . '</span>';
}

foreach ($errors as $err) {
    echo '<span class="feedback feedback--error">Failed — ' . htmlspecialchars($err) . '</span>';
}

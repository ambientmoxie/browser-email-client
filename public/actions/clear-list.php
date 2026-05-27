<?php
require_once __DIR__ . '/../../src/php/helpers/session-helper.php';
SessionHelper::start();

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    exit;
}

unset($_SESSION['emails']);

require_once __DIR__ . '/../../src/php/partials/email-list.php';
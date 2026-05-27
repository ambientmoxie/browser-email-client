<?php
require_once __DIR__ . '/../../src/php/helpers/session-helper.php';
SessionHelper::start();

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    exit;
}

$email = $_GET['email'] ?? '';
$_SESSION['emails'] = array_values(array_filter($_SESSION['emails'] ?? [], fn($e) => $e !== $email));

require_once __DIR__ . '/../../src/php/partials/email-list.php';

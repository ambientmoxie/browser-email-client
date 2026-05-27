<?php
require_once __DIR__ . '/../../src/php/helpers/session-helper.php';
SessionHelper::start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$raw = $_POST['emails'] ?? '';
$incoming = array_map('trim', preg_split('/[\s,]+/', $raw));
$valid = array_filter($incoming, fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL));

$_SESSION['emails'] = array_values(array_unique(array_merge($_SESSION['emails'] ?? [], $valid)));

require_once __DIR__ . '/../../src/php/partials/email-list.php';

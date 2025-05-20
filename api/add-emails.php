<?php
require_once __DIR__ . "/../php/helpers/api-guard.php";
ApiGuard::protect();

require_once __DIR__ . "/../php/helpers/email-manager.php";
require_once __DIR__ . "/../php/helpers/session-helper.php";
require_once __DIR__ . "/../php/helpers/component-builder.php";

SessionHelper::start();
EmailManager::addToSession($_POST['to_email'] ?? '');
echo ComponentBuilder::createEmailList();

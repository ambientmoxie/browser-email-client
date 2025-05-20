<?php
require_once __DIR__ . "/../php/helpers/email-manager.php";
require_once __DIR__ . "/../php/helpers/session-helper.php";
require_once __DIR__ . "/../php/helpers/component-builder.php";

SessionHelper::start();
EmailManager::removeFromSession($_POST['email'] ?? '');
echo ComponentBuilder::createEmailList();

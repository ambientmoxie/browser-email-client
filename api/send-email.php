<?php
require_once __DIR__ . "/../php/helpers/session-helper.php";
require_once __DIR__ . "/../php/helpers/state-manager.php";
SessionHelper::start();
$state = StateManager::setState();
require_once __DIR__ . '/../php/helpers/vite-env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['log'] = [];

    // Check if there are valid emails stored
    if (empty($state["emailList"])) {
        $_SESSION['log'] = [
            'type' => 'error',
            'message' => 'No valid email addresses provided.'
        ];
        header("Location: /");
        exit("No valid email addresses provided.");
    }

    $message = $_POST["message"];
    $subject = $_POST["subject"];
    $sentEmails = [];
    $errors = [];

    foreach ($state["emailList"] as $email) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['USERNAME'];
            $mail->Password = $_ENV['PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['PORT'];
            $mail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);

            $mail->addAddress($email);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            $sentEmails[] = $email;

        } catch (Exception $e) {
            $errors[] = "Failed to send to $email: " . $mail->ErrorInfo;
        }
    }

    if (!empty($sentEmails)) {
        $displayed = array_slice($sentEmails, 0, 3);
        $remaining = count($sentEmails) - count($displayed);
        $emailList = implode(', ', $displayed);
        $more = $remaining > 0 ? " (+{$remaining} more)" : '';

        $_SESSION['log'] = [
            'type' => 'success',
            'message' => "Emails sent to: $emailList$more"
        ];
    }

    if (!empty($errors)) {
        foreach ($errors as $err) {
            $_SESSION['log'] = [
                'type' => 'error',
                'message' => $err
            ];
        }
    }

    header("Location: /");
    exit;
}

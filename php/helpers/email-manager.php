<?php

class EmailManager
{
    // Add email(s) to the session variable
    public static function addToSession(string $input): array
    {

        $emails = array_map('trim', explode(',', $input));
        foreach ($emails as $email) {
            if (
                filter_var($email, FILTER_VALIDATE_EMAIL) &&
                !in_array($email, $_SESSION['state']['emailList'] ?? [])
            ) {
                $_SESSION['state']['emailList'][] = $email;
            }
        }

        return $_SESSION['state']['emailList'];
    }

    // Remove one particular email from session
    public static function removeFromSession(string $input): array
    {

        if (isset($_POST['email']) && in_array($input, $_SESSION['state']["emailList"] ?? [])) {
            $_SESSION['state']["emailList"] = array_values(array_filter($_SESSION['state']["emailList"], fn($e) => $e !== $input));
        }
        return $_SESSION['state']["emailList"];
    }

    // Clear all the email from session
    public static function clearAll(): array
    {
        return $_SESSION['state']["emailList"] = [];
    }
}

<?php

class StateManager
{

    public static function setState(): array
    {

        if (!isset($_SESSION["state"])) {
            $_SESSION["state"] = [
                "amount" => 10,
                "emailList" => [],
                "overflow" => false, // Email are not all displayed. Only the 10 first (see amounnt)
                "toggle" => false, // Default state of toggle button
            ];
        }

        // Calculate the overflow
        $_SESSION["state"]["overflow"] =
            count($_SESSION["state"]["emailList"]) > $_SESSION["state"]["amount"];

        return $_SESSION["state"];
    }

    public static function logState(): array
    {
        $state = self::setState();

        error_log("");
        error_log("----------------------------------------");
        error_log("📦 State Debug:");
        error_log("----------------------------------------");
        error_log("amount: " . $state["amount"]);
        error_log("overflow: " . ($state["overflow"] ? "true" : "false"));
        error_log("emailList: " . (!empty($state["emailList"]) ? implode(', ', $state["emailList"]) : "empty"));
        error_log("toggle: " . ($state["toggle"] ? "true" : "false"));
        error_log("----------------------------------------");
        error_log("");

        return $state;
    }
}

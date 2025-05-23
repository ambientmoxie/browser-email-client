<?php
require_once __DIR__ . "/state-manager.php";

class ComponentBuilder
{

    /**
     * Builds the email list component based on the current state.
     * Takes into account config variables like "emailList", "amount", and "toggle".
     * If triggered by the toggle button, it switches the view mode (collapsed/expanded).
     * Renders either a limited list, the full list, or a default empty message.
     */

    public static function createEmailList(): string
    {
        $items = '';

        if ($_SERVER['HTTP_HX_TRIGGER_NAME'] ?? '' === "toggle-btn") {
            $_SESSION["state"]["toggle"] = !($_SESSION["state"]["toggle"] ?? false);
        }

        $state = StateManager::setState();

        if (!empty($state["emailList"])) {

            $index = 0;
            $limit = $state["toggle"] ? count($state["emailList"]) : $state["amount"];

            foreach ($state["emailList"] as $email) {
                if ($index >= $limit) {
                    $remaining = count($state["emailList"]) - $limit;
                    $wording = '...and ' . $remaining . ' more';
                    $items .= self::createListItem($wording, true);
                    break;
                }
                $items .= self::createListItem($email);
                $index++;
            }
        } else {
            $items .= self::createListItem("Email list is currently empty. Use the input above to add one.", true);
        }

        $items .= self::createListController();

        return $items;
    }

    private static function createListItem(string $wording, bool $isDefault = false): string
    {
        $safeWording = htmlspecialchars($wording);
        $spanClass = 'listed-items__email' . ($isDefault ? ' listed-items__email--empty' : '');

        $html = '<li class="listed-items__item listed-items__item--entry">
                    <span class="' . $spanClass . '">' . $safeWording . '</span>';

        if (!$isDefault) {
            $html .= self::deleteButtonHTML($wording);
        }

        $html .= '</li>';

        return $html;
    }

    private static function createListController(): string
    {
        return
            self::overflowButtonHTML() .
            self::clearButtonHTML();
    }

    public static function overflowChecker(int $visibleLimit): array
    {
        $overflow = [
            "status" => false,
            "amount" => 0
        ];

        if (isset($_SESSION["emails"])) {
            $remaining = count($_SESSION["emails"]) - $visibleLimit;
            $overflow["status"] = $remaining > 0;
            $overflow["amount"] = max($remaining, 0);
        }

        return $overflow;
    }

    // --- Private Helpers ---

    private static function deleteButtonHTML(string $email = ''): string
    {

        $safeEmail = htmlspecialchars($email);
        $isUnrolled = ($_SESSION['amount'] ?? 10) >= count($_SESSION['emails'] ?? []);

        $jsonVals = htmlspecialchars(json_encode([
            'email' => $safeEmail,
            'show_all' => $isUnrolled ? '1' : '0'
        ]));
        return '
            
                <button
                 hx-post="api/delete-email.php"
                hx-vals=\'' . $jsonVals . '\'
                hx-target="#email-list"
                hx-swap="innerHTML"
                class="listed-items__button custom-button"">delete</button>
            ';
    }

    private static function overflowButtonHTML(): string
    {

        $state = StateManager::setState();
        $isEnable = $state["overflow"] ? "true" : "false";

        return '
        <li class="listed-items__item listed-items__item--toggler" data-enabled="' . $isEnable . '">
            
                <button
                    name="toggle-btn"
                    type="submit"
                    hx-post="api/add-emails.php"
                    hx-target="#email-list"
                    hx-swap="innerHTML"
                    class="listed-items__button  custom-button">Toggle View</button>
            
        </li>';
    }

    private static function clearButtonHTML(): string
    {
        return '
            <li class="listed-items__item listed-items__item--delete">
                
                    <button
                        hx-post="api/clear-list.php"
                        hx-target="#email-list"
                        hx-swap="innerHTML"
                        class="list-controls__button list-controls__button--delete custom-button">delete all</button>
            
            </li>';
    }
}

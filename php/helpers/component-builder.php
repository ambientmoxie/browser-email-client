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
        $spanClass = 'listed-item__entry' . ($isDefault ? ' listed-item__entry--empty' : '');

        $html = '<li class="listed-item">
                    <span class="' . $spanClass . '">' . $safeWording . '</span>';

        if (!$isDefault) {
            $html .= self::deleteButtonHTML($wording);
        }

        $html .= '</li>';

        return $html;
    }

    private static function createListController(): string
    {
        return '
        <li class="list-controls">
            <ul class="list-controls__group">' .
            self::renderListHeader() .
            self::overflowButtonHTML() .
            self::clearButtonHTML() .
            '</ul>
        </li>';
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
            <div class="listed-item__button-wrap">
                <button
                 hx-post="api/delete-email.php"
                hx-vals=\'' . $jsonVals . '\'
                hx-target=".listed-items"
                hx-swap="innerHTML"
                class="listed-item__button thm-btn"">delete</button>
            </div>';
    }

    private static function renderListHeader(): string
    {
        return '
            <li class="list-controls__header">
                <div class="list-controls__spacer"></div>
                <div class="list-controls__title">
                    <h2>Controllers</h2>
                </div>
            </li>';
    }

    private static function overflowButtonHTML(): string
    {

        $state = StateManager::setState();
        $isEnable = $state["overflow"] ? "true" : "false";

        return '
        <li class="list-controls__item" data-enabled="' . $isEnable . '">
            <div class="list-controls__label">
                <h3>Overflow</h3>
            </div>
            <div class="list-controls__button-wrap">
                <button
                    name="toggle-btn"
                    type="submit"
                    hx-post="api/add-emails.php"
                    hx-target=".listed-items"
                    hx-swap="innerHTML"
                    class="list-controls__button list-controls__button--display thm-btn">Toggle View</button>
            </div>
        </li>';
    }

    private static function clearButtonHTML(): string
    {
        return '
            <li class="list-controls__item">
                <div class="list-controls__label">
                    <h3>Clear</h3>
                </div>
                <div class="list-controls__button-wrap">
                    <button
                        hx-post="api/clear-list.php"
                        hx-target=".listed-items"
                        hx-swap="innerHTML"
                        class="list-controls__button list-controls__button--delete thm-btn">delete all</button>
                </div>
            </li>';
    }
}

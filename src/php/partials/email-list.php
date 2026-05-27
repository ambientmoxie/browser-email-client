<?php
$emails = $_SESSION['emails'] ?? [];
?>

<?php if (empty($emails)): ?>
    <span class="module__info">Email list is currently empty. Use the input field above to add one.</span>
<?php else: ?>
    <ul class="module__email-list">
        <?php foreach ($emails as $email): ?>
            <li class="module__email-wrapper">
                <span class="module__email"><?= htmlspecialchars($email) ?></span>
                <button
                    class="module__button module__button--delete"
                    hx-delete="/actions/delete-email.php"
                    hx-vals='{"email": "<?= htmlspecialchars($email, ENT_QUOTES) ?>"}'
                    hx-target="#email-list"
                    hx-swap="innerHTML"
                >Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
/**
 * Debug line. Uncomment to inspect $_SESSION['emails'].
 * echo "<pre>" . print_r($_SESSION['emails'], true) . "</pre>";
 */
?>
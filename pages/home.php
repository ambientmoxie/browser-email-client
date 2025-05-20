<?php
require_once __DIR__ . "/../php/helpers/session-helper.php";
SessionHelper::start();
require_once __DIR__ . "/../templates/head.php";
?>

<body>
    <div id="wrapper">
        <?php
        require_once __DIR__ . "/../templates/sections/add-email.php";
        require_once __DIR__ . "/../templates/sections/list-email.php";
        require_once __DIR__ . "/../templates/sections/message.php";
        ?>
    </div>
</body>

<?php
require_once __DIR__ . "/../templates/foot.php";
?>
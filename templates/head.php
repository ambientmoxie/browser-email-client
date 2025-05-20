<?php
require_once __DIR__ . '/../php/helpers/hashed-assets-url.php';
require_once __DIR__ . '/../php/helpers/vite-env.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Email launcher</title>
    <?php if ($_ENV['VITE_ENV_MODE'] === "dev"): ?>
        <!-- Include Vite dev server for HMR -->
        <script type="module" src="http://localhost:3000/@vite/client"></script>
        <script type="module" src="http://localhost:3000/src/js/main.js" defer></script>
    <?php elseif ($_ENV['VITE_ENV_MODE'] === "host"): ?>
        <!-- Include Vite dev server for HMR -->
        <script type="module" src="http://<?= $_ENV['VITE_LOCAL_IP'] ?>:3000/@vite/client"></script>
        <script type="module" src="http://<?= $_ENV['VITE_LOCAL_IP'] ?>:3000/src/js/main.js" defer></script>
    <?php else: ?>
        <!-- Include the production build files -->
        <link rel="stylesheet" href="<?= AssetHelper::hashedAssetURL("css") ?>">
        <script src="<?= AssetHelper::hashedAssetURL("js") ?>" type="module" defer></script>
    <?php endif; ?>
      <!-- Google font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonoBro</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <?php
    $devSocket = @fsockopen('localhost', 5173, $errno, $errstr, 0.5);
    if ($devSocket):
        fclose($devSocket);
    ?>
        <script type="module" src="http://localhost:5173/@vite/client"></script>
        <script type="module" src="http://localhost:5173/src/js/main.js"></script>
    <?php else:
        $manifest = json_decode(file_get_contents(__DIR__ . '/../../../public/build/.vite/manifest.json'), true);
        $entry = $manifest['src/js/main.js'];
    ?>
        <link rel="stylesheet" href="/build/<?= $entry['css'][0] ?>">
        <script type="module" src="/build/<?= $entry['file'] ?>"></script>
    <?php endif; ?>
    <script src="https://unpkg.com/htmx.org@2.0.4" integrity="sha384-HGfztofotfshcF7+8n44JQL2oJmowVChPTg48S+jvZoztPfvwD79OC/LTtG6dMp+" crossorigin="anonymous"></script>
</head>

<body>
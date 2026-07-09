<?php
require_once __DIR__ . "/../src/php/helpers/env-loader.php";
require_once __DIR__ . "/../src/php/helpers/session-helper.php";
SessionHelper::start();
require_once __DIR__ . "/../src/php/partials/head.php";
?>

<main class="container">

    <section class="header">
        <h1 class="header__title">Browser Email Client <br /> w/ HTMX Dynamics</h1>
        <p class="header__paragraph">
            Sending clean HTML emails from a default email client isn't always straightforward, and this tool was built to fill that gap. It isn't functional out of the box as it needs to be configured with your own email credentials. It can be hosted on any standard PHP server or run locally, which is what I usually do. This tool as a name: "BonoBro". It's like "MailChimp" but not quite.
            <br><br>
            Beyond its main purpose of sending emails, the project includes a few things worth noting. It uses Vite for bundling JavaScript and SCSS, with HMR on all files (JS, SCSS, PHP). It also includes custom session handling to prevent session loss on load-balanced servers (most of my projects run on shared hosting) and HTMX for AJAX calls and UI updates.
        </p>
    </section>
    <hr />

    <section class="add">
        <div class="module">
            <h2 class="module__title">add email(s)</h2>
            <textarea id="emails-input" class="module__textarea module__textarea--add" name="emails" placeholder="foo@example.com, bar@example.com, ..."></textarea>
            <div class="module__action">
                <button class="module__button module__button--csv">Upload .csv (soon)</button>
                <button
                    class="module__button module__button--add"
                    hx-post="/actions/add-emails.php"
                    hx-include="#emails-input"
                    hx-target="#email-list"
                    hx-swap="innerHTML"
                    hx-on::after-request="document.getElementById('emails-input').value = ''">Add</button>
            </div>
        </div>
    </section>

    <section class="email">
        <div class="module">
            <h2 class="module__title">email-list</h2>
            <div id="email-list">
                <?php require_once __DIR__ . "/../src/php/partials/email-list.php"; ?>
            </div>
            <div class="module__action">
                <button
                    class="module__button module__button--send"
                    hx-delete="/actions/clear-list.php"
                    hx-target="#email-list"
                    hx-swap="innerHTML">Clear</button>
            </div>
        </div>
    </section>

    <section class="message">
        <div class="module">
            <h2 class="module__title">message</h2>
            <input class="module__input" type="text" name="subject" id="subject" placeholder="Email subject" autocomplete="off">
            <textarea class="module__textarea module__textarea--message" name="message" id="message" placeholder="Email (HTML allowed)"></textarea>
            <div class="module__action">
                <button
                    class="module__button module__button--send"
                    hx-post="/actions/send-email.php"
                    hx-include="#subject, #message"
                    hx-target="#feedback"
                    hx-swap="innerHTML">Send</button>
            </div>
        </div>
    </section>

    <div id="feedback"></div>
</main>

<?php require_once __DIR__ . "/../src/php/partials/foot.php"; ?>
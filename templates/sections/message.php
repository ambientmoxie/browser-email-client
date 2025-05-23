<section id="message-area">

    <div id="description" class="wording ">
        <h2>Message</h2>
        <p class="wording__text wording__text--fr"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta ipsum quis elit luctus sollicitudin. In volutpat orci vitae sem facilisis, nec ultricies orci sollicitudin. Vivamus gravida, neque eu cursus pretium, nisl nunc faucibus nibh.</p>
        <p class="wording__text wording__text--en"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta ipsum quis elit luctus sollicitudin. In volutpat orci vitae sem facilisis, nec ultricies orci sollicitudin. Vivamus gravida, neque eu cursus pretium, nisl nunc faucibus nibh.</p>
    </div>


    <?php if (isset($_SESSION['log'])): ?>
        <div class="feedback-box feedback-box--<?= htmlspecialchars($_SESSION['log']['type']) ?>">
            **<?= htmlspecialchars($_SESSION['log']['type']) ?>** </br>
            <?= htmlspecialchars($_SESSION['log']['message']) ?>
        </div>
        <?php unset($_SESSION['log']); ?>
    <?php endif; ?>

    <form class="listed-items" action="/api/send-email.php" method="POST">
        <div class="listed-items__item listed-items__item--object">
            <input type="text" id="subject" name="subject" placeholder="Object for your message" required />
        </div>

        <div class="listed-items__item listed-items__item--message">
            <textarea type="text" id="message" name="message" placeholder="Copy your message (HTML allowed)" required></textarea>
        </div>
        <div class="listed-items__item listed-items__item--submit">
            <button class="custom-button" id="send-email-btn" type="submit">send email</button>
        </div>
    </form>
</section>
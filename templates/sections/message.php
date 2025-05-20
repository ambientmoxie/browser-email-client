<section id="message-area">
    <div class="section-title">
        <h1>Message</h1>
    </div>

    
      <div class="block-multiling block-multiling--layout2">
        <p class="block-multiling__item block-multiling__item--fr">Votre liste d'envoi maintenant complète. Utilisez le formulaire ci-dessous pour rédiger votre e-mail (compatible HTML). Indiquez un objet, puis cliquez sur "Send email".</p>
        <p class="block-multiling__item block-multiling__item--en">Your mailing list now complete. Use the form below to write your email (HTML compatible). Enter a subject, then click "Send email".</p>
    </div>
    

    <?php if (isset($_SESSION['log'])): ?>
        <div class="feedback-box feedback-box--<?= htmlspecialchars($_SESSION['log']['type']) ?>">
            **<?= htmlspecialchars($_SESSION['log']['type']) ?>** </br>
            <?= htmlspecialchars($_SESSION['log']['message']) ?>
        </div>
        <?php unset($_SESSION['log']); ?>
    <?php endif; ?>

    <form class="custom-form" action="/api/send-email.php" method="POST">
        <div class="custom-form__group custom-form__group--subject">
            <label for="">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Object for your message" required />
        </div>

        <div class="custom-form__group custom-form__group--message">
            <label for="">Message</label>
            <textarea type="text" id="message" name="message" placeholder="Copy your message (HTML allowed)" required></textarea>
        </div>
        <div class="custom-form__group custom-form__group--submit">
            <label for="">Submit</label>
            <div class="form__submit-wrapper">
                <button class="thm-btn" id="send-email-btn" type="submit">send email</button>
            </div>
        </div>
    </form>
</section>
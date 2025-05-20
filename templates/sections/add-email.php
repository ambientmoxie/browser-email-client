<section id="add-email">

    <div class="section-title">
        <h1>Add email(s)</h1>
    </div>

    <div class="block-multiling block-multiling--layout2">
        <p class="block-multiling__item block-multiling__item--fr">Utilisez la section ci-dessous afin d'ajouter une ou plusieurs adresses email à la liste d'envoi. Les entrées doivent être séparées par une virgule (exemple : johndoe@email.com, janedoe@email.com, etc.). Bientôt: Importer de fichier .csv.</p>
        <p class="block-multiling__item block-multiling__item--en">Use the section below to add one or more email addresses to the mailing list. Emails must be separated by a comma (e.g. johndoe@email.com, janedoe@email.com, etc.). Coming soon: ability to import a .csv file.</p>
    </div>


    <form
        class="custom-form"
        hx-post="api/add-emails.php"
        hx-target=".listed-items"
        hx-swap="innerHTML"
        hx-on="htmx:afterRequest: this.reset()">

        <div class="custom-form__group custom-form__group--entries">
            <label for="to_email">Entries</label>
            <input type="text" id="to_email" name="to_email" placeholder="Enter email(s)" required />
        </div>

        <div class="custom-form__group custom-form__group--upload" data-enabled="false">
            <label for="">Upload</label>
            <div class="form__upload-wrapper">
                <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip">
                <label class="thm-btn" id="file" for="documents">Ajouter des documents</label>
            </div>
        </div>
        <div class="custom-form__group custom-form__group--submit">
            <label for="">Submit</label>
            <div class="form__submit-wrapper">
                <button class="thm-btn" id="add-email-btn" type="submit">add to sending list</button>
            </div>
        </div>
    </form>

</section>
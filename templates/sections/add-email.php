<section id="add-email">
    <div id="description" class="wording ">
        <h2>Add emails</h2>
        <p class="wording__text wording__text--fr"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta ipsum quis elit luctus sollicitudin. In volutpat orci vitae sem facilisis, nec ultricies orci sollicitudin. Vivamus gravida, neque eu cursus pretium, nisl nunc faucibus nibh.</p>
        <p class="wording__text wording__text--en"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta ipsum quis elit luctus sollicitudin. In volutpat orci vitae sem facilisis, nec ultricies orci sollicitudin. Vivamus gravida, neque eu cursus pretium, nisl nunc faucibus nibh.</p>
    </div>
    <form
        id="add-email"
        class="listed-items"
        hx-post="api/add-emails.php"
        hx-target="#email-list"
        hx-swap="innerHTML"
        hx-on="htmx:afterRequest: this.reset()">

        <div class="listed-items__item listed-items__item--entry">
            <textarea type="text" id="to_email" name="to_email" placeholder="Enter email(s)" required></textarea>
        </div>

        <div class="custom-form__group custom-form__group--upload" data-enabled="false">
            <div class="form__upload-wrapper">
                <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip">
                <label class="custom-button" id="file" for="documents">Add .csv document</label>
            </div>
        </div>
        <div class="custom-form__group custom-form__group--submit">
            <button class="custom-button" id="add-email-btn" type="submit">add to sending list</button>
        </div>
    </form>

</section>
  <?php
    require_once __DIR__ . "/../../php/helpers/component-builder.php";
    ?>

  <section id="email-section">

  <div id="description" class="wording ">
        <h2>Current email list</h2>
        <p class="wording__text wording__text--fr"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta ipsum quis elit luctus sollicitudin. In volutpat orci vitae sem facilisis, nec ultricies orci sollicitudin. Vivamus gravida, neque eu cursus pretium, nisl nunc faucibus nibh.</p>
        <p class="wording__text wording__text--en"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta ipsum quis elit luctus sollicitudin. In volutpat orci vitae sem facilisis, nec ultricies orci sollicitudin. Vivamus gravida, neque eu cursus pretium, nisl nunc faucibus nibh.</p>
    </div>


      <ul id="email-list" class="listed-items">
          <?= ComponentBuilder::createEmailList(); ?>
      </ul>
  </section>
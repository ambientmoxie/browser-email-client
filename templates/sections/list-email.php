  <?php
    require_once __DIR__ . "/../../php/helpers/component-builder.php";
    ?>

  <section id="email-list">
    <div class="section-title">
        <h1>Current email list</h1>
    </div>
      <div class="block-multiling block-multiling--layout2">
        <p class="block-multiling__item block-multiling__item--fr">Ci-dessous, la liste des emails ajoutés, limitée à 10 entrées visibles. Cliquez sur "Toggle view" pour tout afficher, et sur les boutons "Delete" pour en supprimer une/des entrées.</p>
        <p class="block-multiling__item block-multiling__item--en">Below is the list of emails added to the mailing list, limited to 10 visible entries. Click "Toggle view" to display all. Click "Delete" or "Delete all" to remove one or more entries.</p>
    </div>

      

      <ul class="listed-items listed-items--structured">
          <?= ComponentBuilder::createEmailList(); ?>
      </ul>
  </section>
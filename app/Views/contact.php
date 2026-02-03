<?php
$title = "Contact";
ob_start();
?>

<section class="page">
  <div class="page-inner">
    <h1>Nous contacter</h1>
    <form class="contact-form" method="post">
      <div class="form-grid">
        <div class="form-field">
          <label for="contact-name">Nom</label>
          <input id="contact-name" name="name" type="text" required>
        </div>
        <div class="form-field">
          <label for="contact-email">Email</label>
          <input id="contact-email" name="email" type="email" required>
        </div>
      </div>
      <div class="form-field">
        <label for="contact-subject">Sujet</label>
        <input id="contact-subject" name="subject" type="text" required>
      </div>
      <div class="form-field">
        <label for="contact-message">Message</label>
        <textarea id="contact-message" name="message" rows="5" required></textarea>
      </div>
      <label class="form-check">
        <input type="checkbox" name="consent" required>
        <span>En envoyant un message, j'accepte les <a href="/cgv">Conditions générales</a> et la <a href="/privacy">Politique de confidentialité</a>, et j'autorise Maison Eau D'or à traiter mes données afin de répondre à mon message.</span>
      </label>
      <div class="form-actions">
        <button class="product-cta" type="submit">Envoyer</button>
      </div>
    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

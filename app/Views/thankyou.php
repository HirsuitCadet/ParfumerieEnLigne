<?php
$title = "Merci pour votre commande";
ob_start();
?>

<section class="thankyou-page">
  <div class="thankyou-inner">
    <h1>Merci pour votre commande</h1>
    <p>Votre commande a été prise en compte. Nous vous enverrons une confirmation par email très bientôt.</p>
    <?php if (!empty($orderId)): ?>
      <div class="thankyou-order">Commande #<?= (int) $orderId ?></div>
    <?php endif; ?>
    <div class="thankyou-actions">
      <a class="product-cta" href="/orders">Voir mes commandes</a>
      <a class="product-ghost" href="/products">Continuer mes achats</a>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

<?php
$title = "Panier";
ob_start();
?>

<section class="page">
  <div class="page-inner">
    <h1>Panier</h1>
    <?php if (empty($cartItems)): ?>
      <p>Votre panier est vide pour le moment.</p>
    <?php else: ?>
      <div class="cart-list">
        <?php foreach ($cartItems as $item): ?>
          <?php
            $img = $item['image'] ?: "/assets/img/products/ahlam.png";
            if ($img && $img[0] !== "/") {
              $img = "/" . ltrim($img, "/");
            }
          ?>
          <div class="cart-item">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <div class="cart-item-info">
              <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
              <div class="cart-item-meta">Quantite : <?= (int)$item['quantity'] ?></div>
            </div>
            <div class="cart-item-price">
              <?= number_format($item['line_total'], 2, ",", " ") ?> â‚¬
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="cart-total">
        <span>Total</span>
        <strong><?= number_format($cartTotal, 2, ",", " ") ?> â‚¬</strong>
      </div>
      <div class="cart-actions">
        <a class="product-ghost" href="/products">Continuer mes achats</a>
        <a class="product-cta" href="/checkout">Passer au paiement</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

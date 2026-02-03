<?php
$title = "Validation de commande";
ob_start();
?>

<section class="checkout-page">
  <div class="checkout-inner">
    <div class="checkout-main">
      <h1>Validation de commande</h1>

      <div class="checkout-card">
        <h2>Informations de contact</h2>
        <div class="checkout-grid">
          <div class="checkout-field">
            <label>Nom complet</label>
            <input type="text" value="<?= htmlspecialchars(trim(($profile['firstname'] ?? '') . ' ' . ($profile['lastname'] ?? ''))) ?>" readonly>
          </div>
          <div class="checkout-field">
            <label>Email</label>
            <input type="email" value="<?= htmlspecialchars($profile['email'] ?? ($user['email'] ?? '')) ?>" readonly>
          </div>
          <div class="checkout-field">
            <label>Téléphone</label>
            <input type="text" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" readonly>
          </div>
        </div>
      </div>

      <div class="checkout-card">
        <h2>Adresse de livraison</h2>
        <div class="checkout-grid">
          <div class="checkout-field">
            <label>Adresse</label>
            <input type="text" value="<?= htmlspecialchars($profile['address'] ?? '') ?>" readonly>
          </div>
          <div class="checkout-field">
            <label>Ville</label>
            <input type="text" value="<?= htmlspecialchars($profile['town'] ?? '') ?>" readonly>
          </div>
          <div class="checkout-field">
            <label>Code postal</label>
            <input type="text" value="<?= htmlspecialchars($profile['postal'] ?? '') ?>" readonly>
          </div>
          <div class="checkout-field">
            <label>Pays</label>
            <input type="text" value="<?= htmlspecialchars($profile['country'] ?? '') ?>" readonly>
          </div>
        </div>
        <p class="checkout-note">Pour modifier ces informations, rendez-vous dans votre profil.</p>
      </div>

      <form class="checkout-actions" method="post">
        <input type="hidden" name="action" value="confirm">
        <button class="product-cta checkout-cta" type="submit">Confirmer la commande</button>
      </form>
    </div>

    <aside class="checkout-summary">
      <h2>Récapitulatif</h2>
      <div class="checkout-summary-list">
        <?php foreach ($checkoutItems as $item): ?>
          <?php
            $img = $item['image'] ?: "/assets/img/products/ahlam.png";
            if ($img && $img[0] !== "/") {
              $img = "/" . ltrim($img, "/");
            }
          ?>
          <div class="checkout-summary-item">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <div class="checkout-summary-info">
              <div class="checkout-summary-name"><?= htmlspecialchars($item['name']) ?></div>
              <div class="checkout-summary-meta">Quantite : <?= (int) $item['quantity'] ?></div>
              <div class="checkout-summary-meta"><?= number_format($item['price'], 2, ",", " ") ?> € / unité</div>
            </div>
            <div class="checkout-summary-line">
              <?= number_format($item['line_total'], 2, ",", " ") ?> €
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="checkout-totals">
        <div class="checkout-row">
          <span>Total HT</span>
          <strong><?= number_format($totalHt, 2, ",", " ") ?> €</strong>
        </div>
        <div class="checkout-row">
          <span>TVA (20%)</span>
          <strong><?= number_format($taxAmount, 2, ",", " ") ?> €</strong>
        </div>
        <div class="checkout-row checkout-row--total">
          <span>Total TTC</span>
          <strong><?= number_format($totalTtc, 2, ",", " ") ?> €</strong>
        </div>
      </div>
    </aside>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

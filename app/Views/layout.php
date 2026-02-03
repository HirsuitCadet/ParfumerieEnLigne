<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= isset($title) ? htmlspecialchars($title) : "Maison Eau D'Or" ?></title>

  <!-- Fonts proches de ton rendu (sérif élégant) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Playfair+Display:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<?php
$cartPanelItems = [];
$cartPanelTotal = 0.0;
$cartPanelCount = 0;
$cartPanelTaxRate = 0.20;

if (!empty($_SESSION['cart']['items']) && is_array($_SESSION['cart']['items'])) {
  foreach ($_SESSION['cart']['items'] as $qty) {
    $cartPanelCount += max(0, (int) $qty);
  }

  if ($cartPanelCount > 0 && isset($pdo) && $pdo instanceof PDO) {
    $ids = array_keys($_SESSION['cart']['items']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $byId = [];
    foreach ($products as $product) {
      $byId[(int) $product['id']] = $product;
    }

    foreach ($_SESSION['cart']['items'] as $id => $quantity) {
      $id = (int) $id;
      if (!isset($byId[$id])) {
        continue;
      }
      $product = $byId[$id];
      $price = (float) ($product['price'] ?? 0);
      $qty = max(1, (int) $quantity);
      $lineTotal = $price * $qty;
      $cartPanelTotal += $lineTotal;
      $cartPanelItems[] = [
        'id' => $id,
        'name' => $product['name'] ?? 'Produit',
        'price' => $price,
        'image' => $product['image'] ?? '',
        'quantity' => $qty,
        'line_total' => $lineTotal
      ];
    }
  }
}
?>
<body>
<header class="site-header">
  <div class="topbar">

    <a href="/" class="brand">
      <img src="/assets/img/logo.png" alt="Maison Eau D'Or" class="brand-logo">
    </a>

    <div class="top-icons">
      <?php if (!empty($_SESSION['user'])): ?>
        <div class="user-menu">
          <button class="icon-btn user-menu-toggle" type="button" aria-label="Compte" aria-haspopup="true" aria-expanded="false">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12Zm0 2c-4.1 0-7.5 2.2-7.5 5v1h15v-1c0-2.8-3.4-5-7.5-5Z"/></svg>
          </button>
          <div class="user-menu-dropdown" role="menu">
            <a href="/profile" role="menuitem">Informations du profil</a>
            <a href="/orders" role="menuitem">Mes commandes</a>
            <a href="/logout" role="menuitem">Deconnexion</a>
          </div>
        </div>
      <?php else: ?>
        <a class="icon-btn" href="/signin" aria-label="Compte">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12Zm0 2c-4.1 0-7.5 2.2-7.5 5v1h15v-1c0-2.8-3.4-5-7.5-5Z"/></svg>
        </a>
      <?php endif; ?>
      <a class="icon-btn cart-link" href="/cart" aria-label="Panier" aria-haspopup="dialog" aria-expanded="false">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 18a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm10 0a2 2 0 1 0 2 2 2 2 0 0 0-2-2ZM6.2 6l.5 2h12.7a1 1 0 0 1 1 .8l-1 6a1 1 0 0 1-1 .8H8a1 1 0 0 1-1-.8L5.3 4.8H3V3h3a1 1 0 0 1 1 .8L7.2 6Z"/></svg>
        <?php if ($cartPanelCount > 0): ?>
          <span class="cart-badge"><?= (int) $cartPanelCount ?></span>
        <?php endif; ?>
      </a>
    </div>
  </div>

  <nav class="nav">
    <div class="nav-inner">
      <div class="nav-item has-dropdown">
        <a href="/products?cat=parfums" class="nav-link">PARFUMS <span class="caret">▼</span></a>
        <div class="dropdown">
          <a href="/products?cat=parfums">Tous les parfums</a>
          <a href="/products?cat=gourmet">Parfums gourmands</a>
          <a href="/products?cat=intime">Musc Tahara intimes</a>
        </div>
      </div>

      <a href="/products?cat=maison" class="nav-link">MAISON</a>
      <a href="/products?cat=musc" class="nav-link">MUSC TAHARA INTIMES</a>
      <a href="/products?cat=cosmetiques" class="nav-link">COSMÉTIQUES</a>
      <a href="/products?cat=brumes" class="nav-link">BRUMES</a>
      <a href="/products?cat=capillaires" class="nav-link">PRODUITS CAPILLAIRES</a>
    </div>
  </nav>
</header>

<main>
  <?= $content ?? "" ?>
</main>

<footer class="site-footer">
  <section class="benefits">
    <div class="benefits-inner">
      <div class="benefit">
        <div class="benefit-icon">🛡️</div>
        <div class="benefit-text">
          <div class="benefit-title">Paiement sécurisé</div>
          <div class="benefit-sub">Paypal, CB, Apple Pay</div>
        </div>
      </div>

      <div class="benefit">
        <div class="benefit-icon">📦</div>
        <div class="benefit-text">
          <div class="benefit-title">Livraison en</div>
          <div class="benefit-sub">Europe</div>
        </div>
      </div>

      <div class="benefit">
        <div class="benefit-text">
          <div class="benefit-title">Nous suivre</div>
          <div class="social">
              <a href="#"><img src="/assets/img/icon/facebook.svg" alt="facebook" class="opacity-75"/></a>
              <a href="#"><img src="/assets/img/icon/snapchat.svg" alt="snapchat" class="opacity-75"/></a>
              <a href="#"><img src="/assets/img/icon/instagram.svg" alt="instagram" class="opacity-75"/></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="footer-main">
    <div class="footer-inner">
      <div class="footer-col footer-logo">
        <img src="/assets/img/logo.png" alt="Maison Eau D'Or" />
      </div>

      <div class="footer-col">
        <h3>Menu</h3>
        <ul>
          <li><a href="/products?cat=parfums">Parfums</a></li>
          <li><a href="/products?cat=maison">Maison</a></li>
          <li><a href="/products?cat=musc">Musc Tahara intime</a></li>
          <li><a href="/products?cat=cosmetiques">Cosmétiques</a></li>
          <li><a href="/products?cat=brumes">Brumes corps & cheveux</a></li>
          <li><a href="/products?cat=capillaires">Produits capillaires</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h3>Besoin d'aide</h3>
        <ul>
          <li><a href="/about">À propos</a></li>
          <li><a href="/contact">Contactez-nous</a></li>
          <li><a href="/privacy">Politique de confidentialité</a></li>
          <li><a href="/cookies">Politique de cookies</a></li>
          <li><a href="/cgv">Conditions générales de vente</a></li>
        </ul>
      </div>
    </div>
  </section>
</footer>

<div class="cart-panel-backdrop" data-cart-backdrop></div>
<aside class="cart-panel" aria-label="Panier" role="dialog" aria-modal="true">
  <div class="cart-panel-header">
    <div class="cart-panel-title">Votre panier</div>
    <button class="cart-panel-close" type="button" aria-label="Fermer" data-cart-close>×</button>
  </div>
  <div class="cart-panel-body">
    <?php if (empty($cartPanelItems)): ?>
      <p class="cart-panel-empty">Votre panier est vide pour le moment.</p>
    <?php else: ?>
      <div class="cart-panel-list">
        <?php foreach ($cartPanelItems as $item): ?>
          <?php
            $img = $item['image'] ?: "/assets/img/products/ahlam.png";
            if ($img && $img[0] !== "/") {
              $img = "/" . ltrim($img, "/");
            }
          ?>
          <div class="cart-panel-item">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <div class="cart-panel-info">
              <div class="cart-panel-name"><?= htmlspecialchars($item['name']) ?></div>
              <div class="cart-panel-meta">
                <span><?= number_format($item['price'], 2, ",", " ") ?> € / unité</span>
              </div>
              <div class="cart-panel-actions">
                <form class="cart-panel-qty-form" method="post" action="/cart">
                  <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>">
                  <input type="hidden" name="action" value="update">
                  <label>
                    <span>Quantite</span>
                    <input type="number" name="quantity" min="1" max="99" value="<?= (int) $item['quantity'] ?>">
                  </label>
                  <button class="cart-panel-btn" type="submit">Mettre à jour</button>
                </form>
                <form method="post" action="/cart">
                  <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>">
                  <input type="hidden" name="action" value="remove">
                  <button class="cart-panel-link" type="submit">Supprimer</button>
                </form>
              </div>
            </div>
            <div class="cart-panel-line">
              <?= number_format($item['line_total'], 2, ",", " ") ?> €
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php
        $cartPanelTax = $cartPanelTotal * $cartPanelTaxRate;
        $cartPanelTotalTtc = $cartPanelTotal + $cartPanelTax;
      ?>
      <div class="cart-panel-totals">
        <div class="cart-panel-row">
          <span>Total HT</span>
          <strong><?= number_format($cartPanelTotal, 2, ",", " ") ?> €</strong>
        </div>
        <div class="cart-panel-row">
          <span>TVA (20%)</span>
          <strong><?= number_format($cartPanelTax, 2, ",", " ") ?> €</strong>
        </div>
        <div class="cart-panel-row cart-panel-row--total">
          <span>Total TTC</span>
          <strong><?= number_format($cartPanelTotalTtc, 2, ",", " ") ?> €</strong>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <div class="cart-panel-footer">
    <a class="product-cta cart-panel-cta" href="/checkout">Confirmer la commande</a>
  </div>
</aside>

<script src="/assets/js/app.js" defer></script>
</body>
</html>

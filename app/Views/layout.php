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

<body>
<header class="site-header">
  <div class="topbar">
    <button class="lang-btn" type="button">FR</button>

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
      <a class="icon-btn" href="/cart" aria-label="Panier">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 18a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm10 0a2 2 0 1 0 2 2 2 2 0 0 0-2-2ZM6.2 6l.5 2h12.7a1 1 0 0 1 1 .8l-1 6a1 1 0 0 1-1 .8H8a1 1 0 0 1-1-.8L5.3 4.8H3V3h3a1 1 0 0 1 1 .8L7.2 6Z"/></svg>
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

<script src="/assets/js/app.js" defer></script>
</body>
</html>

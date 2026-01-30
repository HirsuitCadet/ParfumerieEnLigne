<?php
$title = "Connexion";
ob_start();
?>

<section class="auth-page">
  <div class="auth-card">
    <div class="auth-header">
      <a href="/" class="auth-logo">
        <img src="/assets/img/logo.png" alt="Maison Eau D'Or">
      </a>
      <h1 class="auth-title">Se connecter</h1>
    </div>

    <form class="auth-form" method="post" action="/signin" data-auth-form="signin" novalidate>
      <label class="auth-field">
        <span class="auth-label">Email</span>
        <input class="auth-input" type="email" name="email" required autocomplete="email" />
      </label>

      <label class="auth-field">
        <span class="auth-label">Mot de passe</span>
        <span class="auth-input-wrap">
          <input class="auth-input" type="password" name="password" required autocomplete="current-password" />
          <button class="auth-toggle" type="button" data-toggle-password aria-label="Afficher le mot de passe" aria-pressed="false">Afficher</button>
        </span>
      </label>

      <a class="auth-link" href="/">Mot de passe oublié ?</a>

      <button class="auth-btn" type="submit">Connexion</button>

      <div class="auth-divider">
        <span>Nouveau client ?</span>
      </div>

      <a class="auth-btn auth-btn--ghost" href="/signup">S'inscrire</a>
    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout-auth.php";
?>

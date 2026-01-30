<?php
$title = "Inscription";
ob_start();
$today = date('Y-m-d');
?>

<section class="auth-page">
  <div class="auth-card auth-card--wide">
    <div class="auth-header">
      <a href="/" class="auth-logo">
        <img src="/assets/img/logo.png" alt="Maison Eau D'Or">
      </a>
      <h1 class="auth-title">S'inscrire</h1>
    </div>

    <form class="auth-form" method="post" action="/signup" data-auth-form="signup" novalidate>
      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Prénom</span>
          <input class="auth-input" type="text" name="firstname" autocomplete="given-name" />
        </label>

        <label class="auth-field">
          <span class="auth-label">Nom</span>
          <input class="auth-input" type="text" name="lastname" autocomplete="family-name" />
        </label>
      </div>

      <label class="auth-field">
        <span class="auth-label">Email</span>
        <input class="auth-input" type="email" name="email" required autocomplete="email" />
      </label>

      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Téléphone</span>
          <input class="auth-input" type="tel" name="phone" autocomplete="tel" />
        </label>

        <label class="auth-field">
          <span class="auth-label">Date de naissance</span>
          <input class="auth-input" type="date" name="birthdate" max="<?= $today ?>" />
        </label>
      </div>

      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Code postal</span>
          <input class="auth-input" type="text" name="postal" autocomplete="postal-code" />
        </label>

        <label class="auth-field">
          <span class="auth-label">Ville</span>
          <input class="auth-input" type="text" name="town" autocomplete="address-level2" />
        </label>
      </div>

      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Adresse</span>
          <input class="auth-input" type="text" name="address" autocomplete="address-line1" />
        </label>

        <label class="auth-field">
          <span class="auth-label">Pays</span>
          <input class="auth-input" type="text" name="country" autocomplete="country-name" />
        </label>
      </div>

      <label class="auth-field">
        <span class="auth-label">Mot de passe</span>
        <span class="auth-input-wrap">
          <input class="auth-input" type="password" name="password" required autocomplete="new-password" />
          <button class="auth-toggle" type="button" data-toggle-password aria-label="Afficher le mot de passe" aria-pressed="false">Afficher</button>
        </span>
      </label>

      <label class="auth-field">
        <span class="auth-label">Confirmer le mot de passe</span>
        <span class="auth-input-wrap">
          <input class="auth-input" type="password" name="confirm" required autocomplete="new-password" />
          <button class="auth-toggle" type="button" data-toggle-password aria-label="Afficher le mot de passe" aria-pressed="false">Afficher</button>
        </span>
        <p class="auth-error" data-error="password-match" hidden>Les mots de passe ne correspondent pas.</p>
      </label>

      <label class="auth-check">
        <input class="auth-check-input" type="checkbox" name="terms" required />
        <span class="auth-check-text">
          J'accepte les <a href="/cgv">conditions générales</a> et la <a href="/privacy">politique de confidentialité</a>.
        </span>
      </label>
      <p class="auth-error" data-error="terms" hidden>Veuillez accepter nos conditions et notre politique de confidentialité.</p>

      <button class="auth-btn" type="submit">Créer mon compte</button>

      <div class="auth-divider">
        <span>Déjà inscrit ?</span>
      </div>

      <a class="auth-btn auth-btn--ghost" href="/signin">Se connecter</a>
    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout-auth.php";
?>

<?php
$title = "Inscription";
$errors = $errors ?? [];
$old = $old ?? [];
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
          <input class="auth-input" type="text" name="firstname" autocomplete="given-name" value="<?= htmlspecialchars($old['firstname'] ?? '') ?>" />
          <?php if (!empty($errors['firstname'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['firstname']) ?></p>
          <?php endif; ?>
        </label>

        <label class="auth-field">
          <span class="auth-label">Nom</span>
          <input class="auth-input" type="text" name="lastname" autocomplete="family-name" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>" />
          <?php if (!empty($errors['lastname'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['lastname']) ?></p>
          <?php endif; ?>
        </label>
      </div>

      <label class="auth-field">
        <span class="auth-label">Email</span>
        <input class="auth-input" type="email" name="email" required autocomplete="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" />
        <?php if (!empty($errors['email'])): ?>
          <p class="auth-error"><?= htmlspecialchars($errors['email']) ?></p>
        <?php endif; ?>
      </label>

      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Téléphone</span>
          <input class="auth-input" type="tel" name="phone" autocomplete="tel" value="<?= htmlspecialchars($old['phone'] ?? '') ?>" />
          <?php if (!empty($errors['phone'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['phone']) ?></p>
          <?php endif; ?>
        </label>

        <label class="auth-field">
          <span class="auth-label">Date de naissance</span>
          <input class="auth-input" type="date" name="birthdate" max="<?= $today ?>" value="<?= htmlspecialchars($old['birthdate'] ?? '') ?>" />
          <?php if (!empty($errors['birthdate'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['birthdate']) ?></p>
          <?php endif; ?>
        </label>
      </div>

      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Code postal</span>
          <input class="auth-input" type="text" name="postal" autocomplete="postal-code" value="<?= htmlspecialchars($old['postal'] ?? '') ?>" />
          <?php if (!empty($errors['postal'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['postal']) ?></p>
          <?php endif; ?>
        </label>

        <label class="auth-field">
          <span class="auth-label">Ville</span>
          <input class="auth-input" type="text" name="town" autocomplete="address-level2" value="<?= htmlspecialchars($old['town'] ?? '') ?>" />
          <?php if (!empty($errors['town'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['town']) ?></p>
          <?php endif; ?>
        </label>
      </div>

      <div class="auth-grid">
        <label class="auth-field">
          <span class="auth-label">Adresse</span>
          <input class="auth-input" type="text" name="address" autocomplete="address-line1" value="<?= htmlspecialchars($old['address'] ?? '') ?>" />
          <?php if (!empty($errors['address'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['address']) ?></p>
          <?php endif; ?>
        </label>

        <label class="auth-field">
          <span class="auth-label">Pays</span>
          <input class="auth-input" type="text" name="country" autocomplete="country-name" value="<?= htmlspecialchars($old['country'] ?? '') ?>" />
          <?php if (!empty($errors['country'])): ?>
            <p class="auth-error"><?= htmlspecialchars($errors['country']) ?></p>
          <?php endif; ?>
        </label>
      </div>

      <label class="auth-field">
        <span class="auth-label">Mot de passe</span>
        <span class="auth-input-wrap">
          <input class="auth-input" type="password" name="password" required autocomplete="new-password" />
          <button class="auth-toggle" type="button" data-toggle-password aria-label="Afficher le mot de passe" aria-pressed="false">Afficher</button>
        </span>
        <?php if (!empty($errors['password'])): ?>
          <p class="auth-error"><?= htmlspecialchars($errors['password']) ?></p>
        <?php endif; ?>
      </label>

      <label class="auth-field">
        <span class="auth-label">Confirmer le mot de passe</span>
        <span class="auth-input-wrap">
          <input class="auth-input" type="password" name="confirm" required autocomplete="new-password" />
          <button class="auth-toggle" type="button" data-toggle-password aria-label="Afficher le mot de passe" aria-pressed="false">Afficher</button>
        </span>
        <p class="auth-error" data-error="password-match" <?= empty($errors['confirm']) ? 'hidden' : '' ?>>
          <?= htmlspecialchars($errors['confirm'] ?? 'Les mots de passe ne correspondent pas.') ?>
        </p>
      </label>

      <label class="auth-check">
        <input class="auth-check-input" type="checkbox" name="terms" required <?= !empty($old['terms']) ? 'checked' : '' ?> />
        <span class="auth-check-text">
          J'accepte les <a href="/cgv">conditions générales</a> et la <a href="/privacy">politique de confidentialité</a>.
        </span>
      </label>
      <p class="auth-error" data-error="terms" <?= empty($errors['terms']) ? 'hidden' : '' ?>>
        <?= htmlspecialchars($errors['terms'] ?? "Veuillez accepter nos conditions et notre politique de confidentialité.") ?>
      </p>

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

<?php
$title = "Informations du profil";
ob_start();
?>

<section class="profile-page">
  <div class="profile-inner">
    <header class="profile-header">
      <h1>Informations du profil</h1>
      <p>Vos informations personnelles</p>
    </header>

    <?php if (!empty($profileSuccess)) : ?>
      <div class="profile-alert success"><?= htmlspecialchars($profileSuccess) ?></div>
    <?php endif; ?>
    <?php if (!empty($passwordSuccess)) : ?>
      <div class="profile-alert success"><?= htmlspecialchars($passwordSuccess) ?></div>
    <?php endif; ?>

    <div class="profile-cards">
      <div class="profile-card">
        <h2>Changement des informations generales</h2>
        <form class="profile-form" method="post" novalidate>
          <input type="hidden" name="action" value="profile" />

          <div class="profile-grid">
            <div class="profile-field">
              <label class="profile-label" for="profile-firstname">Prenom</label>
              <input class="profile-input" id="profile-firstname" name="firstname" type="text" value="<?= htmlspecialchars($profile['firstname'] ?? '') ?>" required />
              <?php if (!empty($profileErrors['firstname'])) : ?>
                <p class="auth-error"><?= htmlspecialchars($profileErrors['firstname']) ?></p>
              <?php endif; ?>
            </div>
            <div class="profile-field">
              <label class="profile-label" for="profile-lastname">Nom</label>
              <input class="profile-input" id="profile-lastname" name="lastname" type="text" value="<?= htmlspecialchars($profile['lastname'] ?? '') ?>" required />
              <?php if (!empty($profileErrors['lastname'])) : ?>
                <p class="auth-error"><?= htmlspecialchars($profileErrors['lastname']) ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="profile-field">
            <label class="profile-label" for="profile-email">Email</label>
            <input class="profile-input" id="profile-email" name="email" type="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required />
            <?php if (!empty($profileErrors['email'])) : ?>
              <p class="auth-error"><?= htmlspecialchars($profileErrors['email']) ?></p>
            <?php endif; ?>
          </div>

          <div class="profile-grid">
            <div class="profile-field">
              <label class="profile-label" for="profile-phone">Telephone</label>
              <input class="profile-input" id="profile-phone" name="phone" type="tel" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" />
            </div>
            <div class="profile-field">
              <label class="profile-label" for="profile-birthdate">Date de naissance</label>
              <input class="profile-input" id="profile-birthdate" name="birthdate" type="date" value="<?= htmlspecialchars($profile['birthdate'] ?? '') ?>" />
            </div>
          </div>

          <div class="profile-grid">
            <div class="profile-field">
              <label class="profile-label" for="profile-postal">Code postal</label>
              <input class="profile-input" id="profile-postal" name="postal" type="text" value="<?= htmlspecialchars($profile['postal'] ?? '') ?>" />
            </div>
            <div class="profile-field">
              <label class="profile-label" for="profile-town">Ville</label>
              <input class="profile-input" id="profile-town" name="town" type="text" value="<?= htmlspecialchars($profile['town'] ?? '') ?>" />
            </div>
          </div>

          <div class="profile-grid">
            <div class="profile-field">
              <label class="profile-label" for="profile-address">Adresse</label>
              <input class="profile-input" id="profile-address" name="address" type="text" value="<?= htmlspecialchars($profile['address'] ?? '') ?>" />
            </div>
            <div class="profile-field">
              <label class="profile-label" for="profile-country">Pays</label>
              <input class="profile-input" id="profile-country" name="country" type="text" value="<?= htmlspecialchars($profile['country'] ?? '') ?>" />
            </div>
          </div>

          <div class="profile-actions">
            <button class="profile-btn" type="submit">Enregistrer</button>
          </div>
        </form>
      </div>

      <div class="profile-card">
        <h2>Changement du mot de passe</h2>
        <form class="profile-form" method="post" novalidate>
          <input type="hidden" name="action" value="password" />

          <div class="profile-field">
            <label class="profile-label" for="profile-password">Nouveau mot de passe</label>
            <div class="auth-input-wrap">
              <input class="profile-input" id="profile-password" name="password" type="password" />
              <button class="auth-toggle" type="button" data-toggle-password aria-pressed="false">Afficher</button>
            </div>
            <?php if (!empty($passwordErrors['password'])) : ?>
              <p class="auth-error"><?= htmlspecialchars($passwordErrors['password']) ?></p>
            <?php endif; ?>
          </div>

          <div class="profile-field">
            <label class="profile-label" for="profile-confirm">Confirmer le mot de passe</label>
            <div class="auth-input-wrap">
              <input class="profile-input" id="profile-confirm" name="confirm" type="password" />
              <button class="auth-toggle" type="button" data-toggle-password aria-pressed="false">Afficher</button>
            </div>
            <?php if (!empty($passwordErrors['confirm'])) : ?>
              <p class="auth-error"><?= htmlspecialchars($passwordErrors['confirm']) ?></p>
            <?php endif; ?>
          </div>

          <div class="profile-actions">
            <button class="profile-btn" type="submit">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>

    <div class="profile-logout">
      <a class="profile-btn profile-btn--ghost" href="/logout">Deconnexion</a>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

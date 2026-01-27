<?php
$title = "Accueil";
ob_start();
?>

<!-- Hero (image pleine largeur) -->
<section class="hero">
  <img src="/assets/img/home/bar.png" alt="Maison Eau D'Or" class="hero-img">
</section>

<!-- Section : Découvrez nos produits -->
<section class="section">
  <h2 class="section-title">Découvrez nos produits</h2>

  <!-- Carrousel “produits du moment” -->
  <div class="carousel full-bleed" data-carousel="moments">
    <button class="carousel-arrow left" type="button" aria-label="Précédent">‹</button>

    <div class="carousel-track">

      <a class="carousel-card" href="/products?cat=cosmetiques">
        <img src="/assets/img/home/cosmetiques.png" alt="Cosmétiques">
        <div class="carousel-label">COSMÉTIQUES</div>
      </a>

      <a class="carousel-card" href="/products?cat=parfums">
        <img src="/assets/img/home/parfums.png" alt="Parfums">
        <div class="carousel-label">PARFUMS</div>
      </a>

      <a class="carousel-card" href="/products?cat=maison">
        <img src="/assets/img/home/sprays_interieur.png" alt="Maison">
        <div class="carousel-label">MAISON</div>
      </a>

      <a class="carousel-card" href="/products?cat=musc">
        <img src="/assets/img/home/musc_tahara_intime.png" alt="Musc">
        <div class="carousel-label">MUSC TAHARA INTIME</div>
      </a>

    </div>

    <button class="carousel-arrow right" type="button" aria-label="Suivant">›</button>
  </div>
</section>

<!-- Bloc “Le Bar à parfum” (2 colonnes) -->
<section class="split">
  <div class="split-inner">
    <div class="info-card">
      <h3>Le Bar à parfum</h3>
      <img class="mini-logo" src="/assets/img/logo.png" alt="Logo">
      <p>Bienvenue dans notre bar à parfum</p>
      <p>
        Découvrez le concept original de Maison Eau d'Or situé<br>
        au 123 Avenue des Champs Elysées.
      </p>
      <p>
        Nous proposons des collections uniques de parfums et<br>
        de sprays d'intérieur
      </p>

      <a class="cta" href="/products?cat=parfums">DÉCOUVRIR <span>›</span></a>
    </div>

    <div class="split-img">
      <img src="/assets/img/home/Bar_parfum_propos.jpg" alt="Le bar à parfum">
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

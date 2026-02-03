<?php
$title = "À propos";
ob_start();
?>

<section class="page">
  <div class="page-inner">
    <h1>À propos</h1>
    <div class="about-card">
      <div class="about-text">
        <h2>Le Bar à parfum</h2>
        <img class="about-logo" src="/assets/img/logo.png" alt="Maison Eau D'Or">
        <p class="about-highlight">Composez votre cocktail de parfums !</p>
        <p>Nous sommes accueillies chaleureusement dans la boutique Ydentik qui se situe au 123 Avenue René Coté au Havre. Leur concept est de créer des parfums uniques et personnalisés. Je trouve l’idée géniale.</p>
        <p>Le décor est chic et épuré dans les couleurs blanches, les bouteilles de parfum remplissent un côté du mur comme dans les bars et de l’autre nous découvrons les senteurs des mélanges. Le plus souvent, nous le savons bien, dans un parfum, c’est la marque et le packaging que nous payons, ici, il n’est plus question de cela. L’équipe est accueillante et aux petits soins. C’est à vous de composer votre parfum grâce à leurs conseils. Une fois vos ingrédients choisis, ils préparent votre cocktail de parfum unique.</p>
      </div>
      <div class="about-image">
        <img src="/assets/img/home/Bar_parfum_propos.jpg" alt="Le Bar à parfum">
      </div>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

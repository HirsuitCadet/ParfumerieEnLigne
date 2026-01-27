<?php
if (!isset($title)) {
    $title = "Produits";
}
$categoryLabels = [
    0 => "Cosmétiques",
    1 => "Produits capillaires",
    2 => "Miellerie",
    3 => "Maison",
    4 => "Brumes",
    5 => "Musc Tahara intime",
    6 => "Parfums",
    7 => "Parfums gourmands",
];
$slugLabels = [
    "cosmetiques" => "Cosmétiques",
    "capillaires" => "Produits capillaires",
    "miel" => "Miellerie",
    "maison" => "Maison",
    "brumes" => "Brumes",
    "musc" => "Musc Tahara intime",
    "parfums" => "Parfums",
    "gourmet" => "Parfums gourmands",
];
$activeLabel = $catSlug && isset($slugLabels[$catSlug]) ? $slugLabels[$catSlug] : "Tous les produits";
ob_start();
?>

<section class="catalog">
  <header class="catalog-header">
    <div>
      <p class="catalog-eyebrow">Maison Eau D'Or</p>
      <h1 class="catalog-title"><?= htmlspecialchars($activeLabel) ?></h1>
      <p class="catalog-sub">Des créations raffinées pour la maison et la personne.</p>
    </div>
  </header>

  <?php if (empty($products)): ?>
    <p class="catalog-empty">Aucun produit pour le moment.</p>
  <?php else: ?>
    <div class="product-grid">
      <?php foreach ($products as $p): ?>
        <?php
          $catId = isset($p["category"]) ? (int) $p["category"] : null;
          $tagLabel = $catId !== null && isset($categoryLabels[$catId]) ? $categoryLabels[$catId] : null;
          $tagClass = $tagLabel ? "tag-" . ($catId ?? 0) : "";
          $image = $p["image"] ?: "/assets/img/products/ahlam.png";
          if ($image && $image[0] !== "/") {
              $image = "/" . ltrim($image, "/");
          }
        ?>
        <article class="product-card">
          <a class="product-media" href="/product?id=<?= (int) $p["id"] ?>">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($p["name"]) ?>">
            <?php if ($tagLabel): ?>
              <span class="product-tag <?= htmlspecialchars($tagClass) ?>"><?= htmlspecialchars($tagLabel) ?></span>
            <?php endif; ?>
          </a>

          <div class="product-info">
            <h2 class="product-name"><?= htmlspecialchars($p["name"]) ?></h2>
            <p class="product-price"><?= number_format((float) $p["price"], 2, ",", " ") ?> €</p>
            <?php if (!empty($p["description"])): ?>
              <p class="product-desc"><?= nl2br(htmlspecialchars($p["description"])) ?></p>
            <?php endif; ?>
            <a class="product-cta" href="/product?id=<?= (int) $p["id"] ?>">Voir le produit</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

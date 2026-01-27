<?php
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
$categorySlugs = [
    0 => "cosmetiques",
    1 => "capillaires",
    2 => "miel",
    3 => "maison",
    4 => "brumes",
    5 => "musc",
    6 => "parfums",
    7 => "gourmet",
];
$catId = isset($product["category"]) ? (int) $product["category"] : null;
$tagLabel = $catId !== null && isset($categoryLabels[$catId]) ? $categoryLabels[$catId] : null;
$tagClass = $tagLabel ? "tag-" . ($catId ?? 0) : "";
$image = $product["image"] ?: "/assets/img/products/ahlam.png";
if ($image && $image[0] !== "/") {
    $image = "/" . ltrim($image, "/");
}
$backSlug = $catId !== null && isset($categorySlugs[$catId]) ? $categorySlugs[$catId] : null;
$backHref = $backSlug ? "/products?cat=" . $backSlug : "/products";
ob_start();
?>

<section class="product-page">
  <a class="product-back" href="<?= htmlspecialchars($backHref) ?>">← Retour aux produits</a>

  <div class="product-grid-detail">
    <div class="product-gallery">
      <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product["name"] ?? "Produit") ?>">
      <?php if ($tagLabel): ?>
        <span class="product-tag <?= htmlspecialchars($tagClass) ?>"><?= htmlspecialchars($tagLabel) ?></span>
      <?php endif; ?>
    </div>

    <div class="product-meta">
      <h1><?= htmlspecialchars($product["name"] ?? "Produit") ?></h1>
      <p class="product-price"><?= number_format((float) ($product["price"] ?? 0), 2, ",", " ") ?> €</p>
      <?php if (!empty($product["description"])): ?>
        <div class="product-desc">
          <?= nl2br(htmlspecialchars($product["description"])) ?>
        </div>
      <?php endif; ?>
      <div class="product-actions">
        <a class="product-cta" href="/cart">Ajouter au panier</a>
        <a class="product-ghost" href="/order">Acheter maintenant</a>
      </div>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

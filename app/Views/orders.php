<?php
$title = "Mes commandes";
ob_start();
?>

<section class="page">
  <div class="page-inner">
    <h1>Mes commandes</h1>
    <?php if (empty($orders)): ?>
      <p>Vous n'avez pas encore passé de commande.</p>
    <?php else: ?>
      <div class="orders-list">
        <?php foreach ($orders as $order): ?>
          <article class="order-card">
            <header class="order-card-header">
              <div>
                <div class="order-card-title">Commande #<?= (int) $order['id'] ?></div>
                <div class="order-card-meta">Le <?= htmlspecialchars(date('d/m/Y', strtotime($order['created_at']))) ?></div>
              </div>
              <div class="order-card-total">
                <?= number_format((float) ($order['total'] ?? 0), 2, ",", " ") ?> €
              </div>
            </header>
            <div class="order-card-body">
              <?php if (empty($order['items'])): ?>
                <p>Articles indisponibles pour cette commande.</p>
              <?php else: ?>
                <ul class="order-items">
                  <?php foreach ($order['items'] as $item): ?>
                    <?php
                      $img = $item['image'] ?: "/assets/img/products/ahlam.png";
                      if ($img && $img[0] !== "/") {
                        $img = "/" . ltrim($img, "/");
                      }
                      $lineTotal = ((float) $item['price']) * ((int) $item['quantity']);
                    ?>
                    <li class="order-item">
                      <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name'] ?? 'Produit') ?>">
                      <div class="order-item-info">
                        <div class="order-item-name"><?= htmlspecialchars($item['name'] ?? 'Produit') ?></div>
                        <div class="order-item-meta">Quantite : <?= (int) $item['quantity'] ?></div>
                        <div class="order-item-meta"><?= number_format((float) $item['price'], 2, ",", " ") ?> € / unité</div>
                      </div>
                      <div class="order-item-total"><?= number_format($lineTotal, 2, ",", " ") ?> €</div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/layout.php";

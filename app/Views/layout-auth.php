<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= isset($title) ? htmlspecialchars($title) : "Maison Eau D'Or" ?></title>

  <link rel="icon" type="image/png" href="/assets/favicon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Playfair+Display:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<body>
<main class="auth-main">
  <?= $content ?? "" ?>
</main>

<script src="/assets/js/app.js" defer></script>
</body>
</html>


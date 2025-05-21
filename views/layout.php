<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Recette.io' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

  <?php include __DIR__ . '/partials/navbar.php'; ?>
  <?php require_once __DIR__ . '/../config/flash.php'; ?>
  <?php include __DIR__ . '/partials/flash.php'; ?>


  <main class="container mx-auto px-4 py-6 flex-grow">
    <?= $content ?? '' ?>
  </main>

  <footer class="text-center text-sm py-4 text-gray-500">
    &copy; <?= date('Y') ?> Recette.io - Projet PHP
  </footer>

</body>

</html>
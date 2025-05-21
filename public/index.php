<?php
session_start();
ob_start();
require_once __DIR__ . '/../config/config.php';
?>

<section class="min-h-screen flex items-center justify-center px-4">
  <div class="max-w-xl w-full text-center bg-white dark:bg-gray-800 p-8 rounded-lg shadow">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Bienvenue sur <span class="text-blue-600">Recette.io</span> !</h1>
    <p class="text-gray-700 dark:text-gray-300 mb-6">Un mini-système de gestion gastronomique.</p>

    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Qu'est-ce que Recette.io ?</h2>
    <p class="text-gray-600 dark:text-gray-400">
      Recette.io est une application PHP simple permettant à un cuisinier de gérer ses plats : ajout, édition, suppression, avec un système de connexion sécurisé.
    </p>

    <?php if (!isset($_SESSION['user'])): ?>
      <div class="mt-6 flex justify-center space-x-4">
        <a href="/cuisine/views/auth/login.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Connexion</a>
        <a href="/cuisine/views/auth/register.php" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Inscription</a>
      </div>
    <?php else: ?>
      <div class="mt-6 flex justify-center space-x-4">
        <a href="/cuisine/views/plats/index.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Voir les plats</a>
        <a href="/cuisine/views/plats/create.php" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ajouter un plat</a>
      </div>
    <?php endif; ?>
  </div>
</section>


<?php
$content = ob_get_clean();
$title = "Accueil";
require_once __DIR__ . '/../views/layout.php';
?>
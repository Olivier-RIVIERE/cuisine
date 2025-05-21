<?php
ob_start();
?>

<section class="min-h-screen flex items-center justify-center px-4">
  <div class="w-full bg-white rounded-lg shadow md:max-w-md p-6 dark:bg-gray-800">
    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">Connexion</h1>

    <form class="space-y-4" method="POST" action="../../controllers/AuthController.php">
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Votre email</label>
        <input type="email" name="email" id="email" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
      </div>

      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
        <input type="password" name="password" id="password" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
      </div>

      <button type="submit" name="login"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
        Se connecter
      </button>

      <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
        Pas encore de compte ? <a href="register.php"
          class="font-medium text-blue-600 hover:underline dark:text-blue-500">Inscription</a>
      </p>
    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Connexion";
require_once __DIR__ . '/../layout.php';

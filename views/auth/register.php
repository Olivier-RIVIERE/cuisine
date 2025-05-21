<?php
ob_start();
?>

<section class="min-h-screen flex items-center justify-center px-4">
  <div class="w-full bg-white rounded-lg shadow md:max-w-md p-6 dark:bg-gray-800">
    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">Inscription</h1>

    <form method="POST" action="../../controllers/AuthController.php" enctype="multipart/form-data" class="space-y-4">

      <div>
        <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
        <input type="text" name="nom" id="nom" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
      </div>

      <div>
        <label for="specialite" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Spécialité</label>
        <input type="text" name="specialite" id="specialite"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
      </div>

      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
        <input type="email" name="email" id="email" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
      </div>

      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
        <input type="password" name="password" id="password" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
      </div>

      <div>
        <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Avatar (jpg/png/webp – max 2 Mo)</label>
        <input type="file" name="avatar" id="avatar" accept="image/*"
          class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white dark:border-gray-600 dark:bg-gray-700" />
      </div>

      <button type="submit" name="register"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
        S’inscrire
      </button>

      <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
        Déjà un compte ? <a href="login.php"
          class="font-medium text-blue-600 hover:underline dark:text-blue-500">Connexion</a>
      </p>
    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Inscription";
require_once __DIR__ . '/../layout.php';

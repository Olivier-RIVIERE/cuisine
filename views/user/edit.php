<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/auth_required.php';
ob_start();

$user = $_SESSION['user'];
?>

<section class="min-h-screen flex items-center justify-center px-4 py-8">
  <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-6 sm:p-8">
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
        Modifier mon profil
      </h1>

      <form method="POST" action="../../controllers/UserController.php" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
          <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nouveau mot de passe</label>
          <input type="password" name="new_password" id="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmer le mot de passe</label>
          <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label for="specialite" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Spécialité</label>
          <input type="text" name="specialite" id="specialite" value="<?= htmlspecialchars($user['specialite']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
          <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nouvel avatar</label>
          <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white dark:bg-gray-700 dark:border-gray-600">
        </div>

        <button type="submit" name="update_profile" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
          Enregistrer les modifications
        </button>
      </form>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Modifier mon profil";
require_once __DIR__ . '/../layout.php';

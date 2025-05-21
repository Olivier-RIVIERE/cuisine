<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/auth_required.php';
ob_start();

$user = $_SESSION['user'];
?>

<section class="min-h-screen flex items-center justify-center px-4 py-10">
  <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-6 sm:p-8">
      <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Bienvenue <?= htmlspecialchars($user['nom']) ?> sur votre profil !</h2>
        <a href="/cuisine/views/user/edit.php" class="text-sm text-blue-600 dark:text-blue-400 underline">Modifier mon profil</a>
      </div>

      <div class="flex flex-col items-center">
        <?php if (!empty($user['avatar'])): ?>
          <img src="/cuisine/public/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="w-28 h-28 rounded-full object-cover mb-4 border-2 border-gray-300 dark:border-gray-600">
        <?php else: ?>
          <div class="w-28 h-28 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300 mb-4">
            Aucun avatar
          </div>
        <?php endif; ?>
      </div>

      <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
        <p><span class="font-medium">Nom :</span> <?= htmlspecialchars($user['nom']) ?></p>
        <p><span class="font-medium">Spécialité :</span> <?= htmlspecialchars($user['specialite'] ?? 'Non renseignée') ?></p>
        <p><span class="font-medium">Email :</span> <?= htmlspecialchars($user['email']) ?></p>
      </div>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Mon profil";
require_once __DIR__ . '/../layout.php';

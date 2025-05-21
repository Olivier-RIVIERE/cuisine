<?php $connected = isset($_SESSION['user']); ?>

<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <a href="/cuisine/public/index.php" class="text-xl font-bold text-blue-600">Recette.io</a>

    <!-- Burger menu button -->
    <button id="menu-toggle" class="md:hidden text-gray-700 dark:text-gray-300 focus:outline-none">
      ☰
    </button>

    <!-- Desktop menu -->
    <div class="hidden md:flex items-center space-x-4" id="menu-desktop">
      <a href="/cuisine/views/plats/index.php" class="text-gray-700 hover:text-blue-600 dark:text-gray-200">Tous les plats</a>

      <?php if ($connected): ?>
        <a href="/cuisine/views/plats/create.php" class="text-gray-700 hover:text-blue-600 dark:text-gray-200">Ajouter un plat</a>

        <a href="/cuisine/views/user/profile.php" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 dark:text-gray-200">
          <?php if (!empty($_SESSION['user']['avatar'])): ?>
            <img src="/cuisine/public/<?= htmlspecialchars($_SESSION['user']['avatar']) ?>" alt="Avatar"
                 class="w-8 h-8 rounded-full object-cover border border-gray-300">
          <?php else: ?>
            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm text-gray-500 dark:bg-gray-600">
              ?
            </div>
          <?php endif; ?>
          <span>Mon profil</span>
        </a>

        <a href="/cuisine/controllers/LogoutController.php" class="text-red-600 hover:text-red-800 dark:text-red-400">Déconnexion</a>
      <?php else: ?>
        <a href="/cuisine/views/auth/login.php" class="text-gray-700 hover:text-blue-600 dark:text-gray-200">Connexion</a>
        <a href="/cuisine/views/auth/register.php" class="text-gray-700 hover:text-blue-600 dark:text-gray-200">Inscription</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Mobile menu -->
  <div class="md:hidden px-4 pb-4 space-y-2 hidden" id="menu-mobile">
    <a href="/cuisine/views/plats/index.php" class="block text-gray-700 dark:text-gray-200">Tous les plats</a>

    <?php if ($connected): ?>
      <a href="/cuisine/views/plats/create.php" class="block text-gray-700 dark:text-gray-200">Ajouter un plat</a>
      <a href="/cuisine/views/user/profile.php" class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
        <?php if (!empty($_SESSION['user']['avatar'])): ?>
          <img src="/cuisine/public/<?= htmlspecialchars($_SESSION['user']['avatar']) ?>" alt="Avatar"
               class="w-8 h-8 rounded-full object-cover border border-gray-300">
        <?php else: ?>
          <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm text-gray-500 dark:bg-gray-600">
            ?
          </div>
        <?php endif; ?>
        <span>Mon profil</span>
      </a>
      <a href="/cuisine/controllers/LogoutController.php" class="block text-red-600 dark:text-red-400">Déconnexion</a>
    <?php else: ?>
      <a href="/cuisine/views/auth/login.php" class="block text-gray-700 dark:text-gray-200">Connexion</a>
      <a href="/cuisine/views/auth/register.php" class="block text-gray-700 dark:text-gray-200">Inscription</a>
    <?php endif; ?>
  </div>
</nav>

<script>
  const toggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('menu-mobile');

  toggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>

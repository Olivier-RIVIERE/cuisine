<?php
require_once __DIR__ . '/../../config/auth_required.php';
require_once __DIR__ . '/../../config/config.php';
ob_start();

if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

$id = intval($_GET['id']);

// Récupérer le plat
$stmt = $pdo->prepare("SELECT * FROM plats WHERE id = ?");
$stmt->execute([$id]);
$plat = $stmt->fetch();

if (!$plat || $_SESSION['user']['id'] != $plat['cuisinier_id']) {
  echo "<p style='color:red;'>Accès interdit</p>";
  exit;
}

// Récupérer les catégories
$catStmt = $pdo->query("SELECT id, nom FROM categories");
$categories = $catStmt->fetchAll();
?>

<section class="min-h-screen flex items-center justify-center px-4 py-8">
  <div class="w-full bg-white rounded-lg shadow md:max-w-xl p-6 dark:bg-gray-800">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Modifier le plat</h1>

    <form method="POST" action="../../controllers/PlatController.php" class="space-y-4" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $plat['id'] ?>">

      <div>
        <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($plat['nom']) ?>" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
      </div>

      <div>
        <label for="type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type / Catégorie</label>
        <select name="type_id" id="type_id" required
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
          <option value="">-- Choisir un type --</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['nom'] == $plat['type']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="image">Image du plat :</label>
        <input type="file" name="image" id="image" accept="image/*">
      </div>

      <div>
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
        <textarea name="description" id="description" rows="4"
          class="resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><?= htmlspecialchars($plat['description']) ?></textarea>
      </div>

      <button type="submit" name="update_plat"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Mettre à jour
      </button>
    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Modifier un plat";
require_once __DIR__ . '/../layout.php';

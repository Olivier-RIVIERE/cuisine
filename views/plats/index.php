<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session.php';
ob_start();

// Nombre de plats par page
$limit = 10;

// Page actuelle (par défaut : 1)
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Total de plats pour pagination
$totalStmt = $pdo->query("SELECT COUNT(*) FROM plats");
$totalPlats = $totalStmt->fetchColumn();
$totalPages = ceil($totalPlats / $limit);

// Recherche
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$searchClause = '';
$params = [];

if ($search) {
  $searchClause = "WHERE plats.nom LIKE :search OR plats.type LIKE :search";
  $params[':search'] = '%' . $search . '%';
}


// Requête paginée avec filtre
$sql = "SELECT plats.*, cuisiniers.nom AS cuisinier_nom 
        FROM plats 
        JOIN cuisiniers ON plats.cuisinier_id = cuisiniers.id 
        $searchClause
        ORDER BY plats.id DESC 
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
  $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$plats = $stmt->fetchAll();

?>

<section class="py-12">
  <div class="max-w-screen-xl mx-auto px-4">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 text-center">Liste des plats</h2>
    <form method="GET" class="mb-6 max-w-md mx-auto">
      <label for="q" class="sr-only">Rechercher un plat</label>
      <input type="text" name="q" id="q" placeholder="Rechercher par nom ou type"
        value="<?= htmlspecialchars($search) ?>"
        class="w-full p-2 border rounded shadow-sm" />
    </form>
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($plats as $plat): ?>
        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
          <?php if (!empty($plat['image'])): ?>
            <img class="rounded-t-lg w-full h-48 object-cover" src="/cuisine/public/<?= htmlspecialchars($plat['image']) ?>" alt="<?= htmlspecialchars($plat['nom']) ?>">
          <?php else: ?>
            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 italic">Pas d'image</div>
          <?php endif; ?>

          <div class="p-5">
            <h3 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= htmlspecialchars($plat['nom']) ?></h3>
            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($plat['type']) ?> — par <?= htmlspecialchars($plat['cuisinier_nom']) ?></p>
            <p class="mb-3 font-light text-gray-700 dark:text-gray-300"><?= htmlspecialchars(mb_strimwidth($plat['description'], 0, 100, '...')) ?></p>

            <div class="flex justify-between items-center">
              <a href="show.php?id=<?= $plat['id'] ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Voir en détail
              </a>

              <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $plat['cuisinier_id']): ?>
                <div class="text-sm text-right">
                  <a href="edit.php?id=<?= $plat['id'] ?>" class="text-gray-500 hover:underline mr-2">Modifier</a>
                  <a href="../../controllers/PlatController.php?delete=<?= $plat['id'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Supprimer ce plat ?')">Supprimer</a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-6 flex justify-center space-x-2">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"
          class="px-3 py-1 border rounded 
              <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Liste des plats";
require_once __DIR__ . '/../layout.php';

<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session.php';

ob_start();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT plats.*, cuisiniers.nom AS cuisinier_nom FROM plats JOIN cuisiniers ON plats.cuisinier_id = cuisiniers.id WHERE plats.id = ?");
$stmt->execute([$id]);
$plat = $stmt->fetch();

if (!$plat) {
    echo "<p class='text-red-500'>Plat introuvable.</p>";
    exit;
}
?>

<section class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white"><?= htmlspecialchars($plat['nom']) ?></h1>

    <?php if (!empty($plat['image'])): ?>
        <img src="/cuisine/public/<?= htmlspecialchars($plat['image']) ?>" alt="Image du plat"
             class="w-full max-h-80 object-cover rounded mb-6 border">
    <?php endif; ?>

    <p class="mb-2"><strong>Type :</strong> <?= htmlspecialchars($plat['type']) ?></p>
    <p class="mb-2"><strong>Cuisinier :</strong> <?= htmlspecialchars($plat['cuisinier_nom']) ?></p>
    <p class="mb-6"><strong>Description :</strong><br><?= nl2br(htmlspecialchars($plat['description'])) ?></p>

    <a href="index.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">← Retour</a>
</section>

<?php
$content = ob_get_clean();
$title = "Détail du plat";
require_once __DIR__ . '/../layout.php';

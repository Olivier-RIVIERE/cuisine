<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/auth_required.php';
ob_start();

$catStmt = $pdo->query("SELECT id, nom FROM categories");
$categories = $catStmt->fetchAll();
?>

<section class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full bg-white rounded-lg shadow md:max-w-xl p-6 dark:bg-gray-800">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Ajouter un plat</h1>

        <div id="category-message" class="hidden p-4 mb-4 rounded-lg text-sm font-medium" role="alert"></div>

        <form method="POST" action="../../controllers/PlatController.php" class="space-y-4" enctype="multipart/form-data">

            <div>
                <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom du plat</label>
                <input type="text" name="nom" id="nom" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>

            <div>
                <label for="type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type / Catégorie</label>
                <div class="flex gap-2">
                    <select name="type_id" id="category-select" required
                        class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Choisir un type --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="toggleNewCategory()"
                        class="text-sm text-blue-600 hover:underline">+ Nouveau</button>
                </div>
            </div>

            <div id="new-category-field" style="display: none;">
                <label for="new-category-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nouvelle
                    catégorie</label>
                <div class="flex gap-2">
                    <input type="text" id="new-category-name"
                        class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    <button type="button" onclick="addCategory()"
                        class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Ajouter</button>
                </div>
            </div>

            <div>
                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image du plat</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white dark:border-gray-600 dark:bg-gray-700" />
            </div>

            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            </div>

            <button type="submit" name="add_plat"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Ajouter le plat
            </button>
        </form>
    </div>
</section>

<script>
    function toggleNewCategory() {
        const field = document.getElementById('new-category-field');
        field.style.display = field.style.display === 'none' ? 'block' : 'none';
    }

    function addCategory() {
        const name = document.getElementById('new-category-name').value.trim();
        if (!name) return showCategoryMessage("Nom de catégorie requis", "error");

        fetch('../../controllers/CategoryController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'add_category=1&nom=' + encodeURIComponent(name)
            })
            .then(res => {
                if (!res.ok) return res.text().then(text => Promise.reject(text));
                return res.text();
            })
            .then(() => {
                const select = document.getElementById('category-select');
                const option = document.createElement('option');
                option.text = name;
                option.value = 'new';
                select.add(option);
                select.value = option.value;
                showCategoryMessage("Catégorie ajoutée avec succès", "success");
            })
            .catch(error => {
                showCategoryMessage(error, "error");
            });
    }

    function showCategoryMessage(message, type = "success") {
        const box = document.getElementById('category-message');
        const styles = {
            success: "bg-green-100 text-green-800 border border-green-300",
            error: "bg-red-100 text-red-800 border border-red-300"
        };

        box.className = `p-4 mb-4 rounded-lg text-sm font-medium ${styles[type] || styles.success}`;
        box.textContent = message;
        box.style.display = 'block';

        setTimeout(() => {
            box.style.display = 'none';
        }, 3000);
    }
</script>

<?php
$content = ob_get_clean();
$title = "Créer un plat";
require_once __DIR__ . '/../layout.php';

<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../config/session.php';

// Ajout
if (isset($_POST['add_plat'])) {
    $nom = trim($_POST['nom']);
    $type_id = intval($_POST['type_id']);
    $description = trim($_POST['description']);
    $cuisinier_id = $_SESSION['user']['id'];

    // Validation
    $errors = [];
    if (strlen($nom) < 3) $errors[] = "Nom trop court.";
    if (empty($type_id)) $errors[] = "Type requis.";
    if (empty($cuisinier_id)) $errors[] = "Cuisinier requis.";

    // Gestion de l’image
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $maxSize = 2 * 1024 * 1024;
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) $errors[] = "Format d’image non autorisé.";
        if ($_FILES['image']['size'] > $maxSize) $errors[] = "Image trop lourde.";

        if (count($errors) === 0) {
            $imagePath = 'uploads/' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../public/' . $imagePath);
        }
    }

    if (count($errors) === 0) {
        $stmt = $pdo->prepare("
            INSERT INTO plats (nom, type, description, cuisinier_id, image)
            VALUES (?, (SELECT nom FROM categories WHERE id = ?), ?, ?, ?)
        ");
        $stmt->execute([$nom, $type_id, $description, $cuisinier_id, $imagePath]);

        set_flash('success', 'Plat ajouté avec succès.');
        header("Location: ../views/plats/index.php");
        exit;
    } else {
        set_flash('error', implode('<br>', $errors));
        header("Location: ../views/plats/create.php");
        exit;
    }
}

// Suppression
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Vérifie que l'utilisateur est bien le propriétaire
    $stmt = $pdo->prepare("SELECT cuisinier_id FROM plats WHERE id = ?");
    $stmt->execute([$id]);
    $plat = $stmt->fetch();

    if ($plat && $_SESSION['user']['id'] == $plat['cuisinier_id']) {
        $deleteStmt = $pdo->prepare("DELETE FROM plats WHERE id = ?");
        $deleteStmt->execute([$id]);
    }

    set_flash('success', 'Plat supprimé.');
    header("Location: ../views/plats/index.php");
    exit;
}

// Modification
if (isset($_POST['update_plat'])) {
    $id = intval($_POST['id']);
    $nom = trim($_POST['nom']);
    $type_id = intval($_POST['type_id']);
    $description = trim($_POST['description']);

    // Récupérer l'ancien plat pour vérifier le propriétaire
    $check = $pdo->prepare("SELECT cuisinier_id FROM plats WHERE id = ?");
    $check->execute([$id]);
    $plat = $check->fetch();

    if (!$plat || $_SESSION['user']['id'] != $plat['cuisinier_id']) {
        die("Accès interdit");
    }

    // Récupérer le nom de la catégorie
    $catStmt = $pdo->prepare("SELECT nom FROM categories WHERE id = ?");
    $catStmt->execute([$type_id]);
    $cat = $catStmt->fetch();

    if (!$cat) {
        die("Catégorie invalide");
    }

    $update = $pdo->prepare("UPDATE plats SET nom = ?, type = ?, description = ? WHERE id = ?");
    $update->execute([$nom, $cat['nom'], $description, $id]);

    set_flash('success', 'Plat modifié avec succès.');
    header("Location: ../views/plats/index.php");
    exit;
}

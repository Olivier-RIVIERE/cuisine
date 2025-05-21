<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
  $nom = trim($_POST['nom']);
  if (strlen($nom) < 2) {
    http_response_code(400);
    echo "Nom trop court";
    exit;
  }

  $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
  $stmt->execute([$nom]);

  http_response_code(200);
  echo "Catégorie ajoutée";
  exit;
}

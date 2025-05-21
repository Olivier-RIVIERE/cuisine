<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../config/session.php';

// Inscription
if (isset($_POST['register'])) {
  $nom = trim($_POST['nom']);
  $specialite = trim($_POST['specialite']);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $password = $_POST['password'];

  // Vérifications de base
  $errors = [];
  if (!$email) $errors[] = "Email invalide.";
  if (strlen($password) < 8) $errors[] = "Mot de passe trop court.";

  // Gestion de l'avatar
  $avatarPath = null;
  if (!empty($_FILES['avatar']['name'])) {
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $maxSize = 2 * 1024 * 1024;
    $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) $errors[] = "Format d’image non autorisé.";
    if ($_FILES['avatar']['size'] > $maxSize) $errors[] = "Image trop lourde.";

    if (count($errors) === 0) {
      $avatarPath = 'uploads/' . uniqid() . '.' . $ext;
      move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../public/' . $avatarPath);
    }
  }

  if (count($errors) === 0) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO cuisiniers (nom, specialite, email, password, avatar) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $specialite, $email, $hash, $avatarPath]);

    set_flash('success', 'Inscription réussie ! Vous pouvez vous connecter.');
    header("Location: ../views/auth/login.php");
    exit;
  } else {
    if (count($errors) > 0) {
      set_flash('error', implode('<br>', $errors));
      header("Location: ../views/auth/register.php");
      exit;
    }
  }
}

// Connexion
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM cuisiniers WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;
    header("Location: ../views/plats/create.php");
    exit;
  } else {
    set_flash('error', 'Email ou mot de passe incorrect.');
    header("Location: ../views/auth/login.php");
    exit;
  }
}

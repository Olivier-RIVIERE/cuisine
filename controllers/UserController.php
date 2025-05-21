<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../config/session.php';


if (isset($_POST['update_profile']) && isset($_SESSION['user'])) {
  $id = $_SESSION['user']['id'];
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $specialite = trim($_POST['specialite']);
  $avatarPath = $_SESSION['user']['avatar'];

  $errors = [];
  if (!$email) $errors[] = "Email invalide.";

  // Gestion du mot de passe
  if (!empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
    $newPassword = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (strlen($newPassword) < 8) {
      $errors[] = "Le mot de passe doit faire au moins 8 caractères.";
    } elseif ($newPassword !== $confirm) {
      $errors[] = "Les mots de passe ne correspondent pas.";
    } else {
      $hash = password_hash($newPassword, PASSWORD_DEFAULT);
      $pdo->prepare("UPDATE cuisiniers SET password = ? WHERE id = ?")->execute([$hash, $id]);
    }
  }

  // Gestion de l’avatar
  if (!empty($_FILES['avatar']['name'])) {
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $maxSize = 2 * 1024 * 1024;
    $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) $errors[] = "Format non autorisé.";
    if ($_FILES['avatar']['size'] > $maxSize) $errors[] = "Image trop lourde.";

    if (count($errors) === 0) {
      $avatarPath = 'uploads/' . uniqid() . '.' . $ext;
      move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../public/' . $avatarPath);
    }
  }

  if (count($errors) === 0) {
    $stmt = $pdo->prepare("UPDATE cuisiniers SET email = ?, specialite = ?, avatar = ? WHERE id = ?");
    $stmt->execute([$email, $specialite, $avatarPath, $id]);

    // Met à jour la session
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['specialite'] = $specialite;
    $_SESSION['user']['avatar'] = $avatarPath;

    set_flash('success', 'Profil modifié avec succès !');
    header("Location: ../views/user/profile.php");
    exit;

  } else {
    set_flash('error', implode('<br>', $errors));
    header("Location: ../views/user/edit.php");
    exit;
  }
}

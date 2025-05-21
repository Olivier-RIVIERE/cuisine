<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/flash.php';

unset($_SESSION['user']); // Ne détruit pas toute la session
set_flash('info', 'Vous avez été déconnecté.');

header("Location: ../views/auth/login.php");
exit;

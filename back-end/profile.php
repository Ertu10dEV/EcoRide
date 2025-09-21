<?php
session_start();

// --- Vérifier si l'utilisateur est connecté ---
if (!isset($_SESSION['user'])) {
    header('Location: ../front-end/login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
</head>
<body>
    <h1>Bienvenue <?= htmlspecialchars($user['name']) ?> 👋</h1>

    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
    <p>Rôle : <?= htmlspecialchars($user['role']) ?></p>

    <a href="../back-end/logout.php">Se déconnecter</a>
</body>
</html>

<?php
session_start();

// Si l'utilisateur n'est pas connecté, on le renvoie vers login.php
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
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
        <a href="logout.php">Se déconnecter</a>

</body>

</html>

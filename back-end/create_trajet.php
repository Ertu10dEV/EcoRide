<?php
session_start();
require __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../front-end/login.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $depart = trim($_POST['depart'] ?? '');
    $arrive = trim($_POST['arrive'] ?? '');
    $date = $_POST['date'] ?? '';
    $places = filter_var($_POST['places'], FILTER_VALIDATE_INT);
    $prix = filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT);

    if (!$depart || !$arrive || !$date || !$places || !$prix) {
        $error = "Tous les champs sont obligatoires et doivent être valides.";
    } elseif ($places < 1) {
        $error = "Le nombre de places doit être au moins 1.";
    } elseif ($prix < 0) {
        $error = "Le prix doit être positif.";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO trajets (depart, arrive, date, utilisateur_id, places_disponibles, statut, prix)
            VALUES (?, ?, ?, ?, ?, 'disponible', ?)
        ");
        $stmt->execute([$depart, $arrive, $date, $_SESSION['user']['id'], $places, $prix]);
        header('Location: ../front-end/espace-utilisateur.php');
        exit;
    }
}

if ($error) {
    echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
    echo "<p><a href='../front-end/ajout-trajet.php'>Retour au formulaire</a></p>";
}

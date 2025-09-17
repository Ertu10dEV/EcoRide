<?php
session_start();
include '../includes/db.php'; // adapte le chemin si besoin

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: ../front-end/login.php');
    exit;
}

$idUtilisateur = $_SESSION['user']['id'];

// Vérifier que trajet_id est bien un entier
$trajetId = filter_input(INPUT_POST, 'trajet_id', FILTER_VALIDATE_INT);
if (!$trajetId) {
    die('Trajet invalide.');
}

try {
    // Vérifier que le trajet existe et est dispo
    $stmt = $pdo->prepare("SELECT id, statut, places_disponibles, prix 
                           FROM trajets 
                           WHERE id = ?");
    $stmt->execute([$trajetId]);
    $trajet = $stmt->fetch();

    if (!$trajet) {
        die('Trajet introuvable.');
    }
    if ($trajet['statut'] !== 'disponible') {
        die('Trajet non disponible.');
    }
    if ($trajet['places_disponibles'] <= 0) {
        die('Plus de places disponibles.');
    }

    // Vérifier que l'utilisateur a assez de crédits
    $stmt = $pdo->prepare("SELECT credit FROM utilisateur WHERE id = ?");
    $stmt->execute([$idUtilisateur]);
    $user = $stmt->fetch();

    if ($user['credit'] < $trajet['prix']) {
        die("Crédits insuffisants pour réserver ce trajet.");
    }

    // Empêcher la double réservation
    $stmt = $pdo->prepare("SELECT id FROM reservation 
                           WHERE utilisateur_id = ? AND trajet_id = ?");
    $stmt->execute([$idUtilisateur, $trajetId]);
    if ($stmt->fetch()) {
        die('Vous avez déjà réservé ce trajet.');
    }

    // -----------------------
    // Transaction sécurisée
    // -----------------------
    $pdo->beginTransaction();

    // Insérer la réservation
    $stmt = $pdo->prepare("INSERT INTO reservation (utilisateur_id, trajet_id) 
                           VALUES (?, ?)");
    $stmt->execute([$idUtilisateur, $trajetId]);

    // Déduire les crédits du passager
    $stmt = $pdo->prepare("UPDATE utilisateur 
                           SET credit = credit - ? 
                           WHERE id = ?");
    $stmt->execute([$trajet['prix'], $idUtilisateur]);

    // Mettre à jour les places restantes
    $stmt = $pdo->prepare("UPDATE trajets 
                           SET places_disponibles = places_disponibles - 1 
                           WHERE id = ?");
    $stmt->execute([$trajetId]);

    // Si plus de places, changer le statut
    if ($trajet['places_disponibles'] - 1 <= 0) {
        $stmt = $pdo->prepare("UPDATE trajets 
                               SET statut = 'complet' 
                               WHERE id = ?");
        $stmt->execute([$trajetId]);
    }

    $pdo->commit();

    // Rediriger vers espace utilisateur
    header('Location: ../front-end/espace-utilisateur.php');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erreur lors de la réservation : " . $e->getMessage());
}

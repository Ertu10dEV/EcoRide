<?php
session_start();
require __DIR__ . '/../includes/db.php';

// --- Vérifier si l'utilisateur est connecté ---
if (!isset($_SESSION['user'])) {
    header('Location: ../front-end/login.php');
    exit;
}

$idUtilisateur = $_SESSION['user']['id'];

// --- Vérifier que trajet_id est bien un entier ---
$trajetId = filter_input(INPUT_POST, 'trajet_id', FILTER_VALIDATE_INT);
if (!$trajetId) {
    $error = "Trajet invalide.";
}

// --- Si pas d'erreur, traiter la réservation ---
if (empty($error)) {
    try {
        // Vérifier que le trajet existe et est disponible
        $stmt = $pdo->prepare("SELECT id, statut, places_disponibles, prix FROM trajets WHERE id = ?");
        $stmt->execute([$trajetId]);
        $trajet = $stmt->fetch();

        if (!$trajet) {
            $error = "Trajet introuvable.";
        } elseif ($trajet['statut'] !== 'disponible') {
            $error = "Trajet non disponible.";
        } elseif ($trajet['places_disponibles'] <= 0) {
            $error = "Plus de places disponibles.";
        }

        // Vérifier crédits
        $stmt = $pdo->prepare("SELECT credit FROM utilisateur WHERE id = ?");
        $stmt->execute([$idUtilisateur]);
        $user = $stmt->fetch();

        if ($user['credit'] < $trajet['prix']) {
            $error = "Crédits insuffisants pour réserver ce trajet.";
        }

        // Vérifier double réservation
        $stmt = $pdo->prepare("SELECT id FROM reservation WHERE utilisateur_id = ? AND trajet_id = ?");
        $stmt->execute([$idUtilisateur, $trajetId]);
        if ($stmt->fetch()) {
            $error = "Vous avez déjà réservé ce trajet.";
        }

        // --- Si tout est OK, effectuer la réservation ---
        if (empty($error)) {
            $pdo->beginTransaction();

            // Insérer réservation
            $stmt = $pdo->prepare("INSERT INTO reservation (utilisateur_id, trajet_id) VALUES (?, ?)");
            $stmt->execute([$idUtilisateur, $trajetId]);

            // Déduire crédits
            $stmt = $pdo->prepare("UPDATE utilisateur SET credit = credit - ? WHERE id = ?");
            $stmt->execute([$trajet['prix'], $idUtilisateur]);

            // Mettre à jour places restantes
            $placesRestantes = $trajet['places_disponibles'] - 1;
            $statut = $placesRestantes <= 0 ? 'complet' : 'disponible';
            $stmt = $pdo->prepare("UPDATE trajets SET places_disponibles = ?, statut = ? WHERE id = ?");
            $stmt->execute([$placesRestantes, $statut, $trajetId]);

            $pdo->commit();

            // Redirection
            header('Location: ../front-end/espace-utilisateur.php');
            exit;
        }

    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Une erreur est survenue lors de la réservation.";
    }
}

// --- Affichage simple si erreur (optionnel) ---
if (!empty($error)) {
    echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
    echo "<p><a href='../front-end/espace-utilisateur.php'>Retour à votre espace</a></p>";
}

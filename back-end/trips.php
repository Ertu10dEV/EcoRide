<?php
require __DIR__ . '/../includes/db.php';

try {
    // --- Requête pour récupérer tous les trajets avec le nom du chauffeur ---
    $stmt = $pdo->query("
        SELECT t.id, t.depart, t.arrive, t.date, u.name
        FROM trajets t
        JOIN utilisateur u ON t.utilisateur_id = u.id
    ");
    $trajets = $stmt->fetchAll();

    // --- Affichage des trajets ---
    if ($trajets) {
        foreach ($trajets as $trajet) {
            echo "Trajet de " . htmlspecialchars($trajet['depart']) .
                 " à " . htmlspecialchars($trajet['arrive']) .
                 " le " . htmlspecialchars($trajet['date']) .
                 " proposé par " . htmlspecialchars($trajet['name']) . "<br>";
        }
    } else {
        echo "Aucun trajet disponible.";
    }

} catch (PDOException $e) {
    // Message neutre pour l'utilisateur
    echo "Une erreur est survenue lors de la récupération des trajets.";
}


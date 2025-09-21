<?php
require __DIR__ . '/../includes/db.php';
session_start();

// Récupérer tous les trajets disponibles
$stmt = $pdo->query("
    SELECT t.id, t.depart, t.arrive, t.date, t.prix, t.places_disponibles,
        u.name AS chauffeur, u.photo AS chauffeur_photo
    FROM trajets t
    JOIN utilisateur u ON t.utilisateur_id = u.id
    WHERE t.statut = 'disponible'
        AND t.places_disponibles > 0
        AND t.utilisateur_id != 1   -- filtre pour exclure l'admin
    ORDER BY t.date ASC
");
$trajets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturages disponibles – EcoRide</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <h1>Covoiturages trouvés</h1>
    <nav>
        <a href="index.html">Accueil</a>
    </nav>
</header>
<main class="results-container">
    <?php if ($trajets): ?>
        <?php foreach ($trajets as $trajet): ?>
        <div class="ride-card">
            <div class="driver-info">
                <img src="<?= htmlspecialchars($trajet['chauffeur_photo']) ?>" 
                alt="Photo conducteur" class="driver-photo">

                <div>
                    <strong><?= htmlspecialchars($trajet['chauffeur']) ?></strong><br>
                    ⭐ 4.5 / 5
                </div>
            </div>
            <div class="ride-details">
                <p><strong>Trajet :</strong> <?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['arrive']) ?></p>
                <p><strong>Date :</strong> <?= htmlspecialchars($trajet['date']) ?></p>
                <p><strong>Places restantes :</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?></p>
                <p><strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> €</p>
                <button>Voir le détail</button>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun trajet disponible pour le moment.</p>
    <?php endif; ?>
</main>
</body>
</html>

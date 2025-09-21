<?php
require __DIR__ . '/../includes/db.php';
session_start();

// Récupérer l'id du trajet depuis l'URL
$idTrajet = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$idTrajet) {
    // Rediriger vers la liste des trajets si aucun id
    header('Location: covoiturage.php');
    exit;
}

// Récupérer le trajet et le conducteur
$stmt = $pdo->prepare("
    SELECT t.*, u.name, u.photo
    FROM trajets t
    JOIN utilisateur u ON t.utilisateur_id = u.id
    WHERE t.id = ?
");
$stmt->execute([$idTrajet]);
$trajet = $stmt->fetch();

if (!$trajet) {
    die("Trajet non trouvé.");
}

// Si l'utilisateur n'a pas de photo, on met une par défaut
$photoConducteur = $trajet['photo'] ?: 'default-user.jpg';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du covoiturage – EcoRide</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <h1>Détail du covoiturage</h1>
    <a href="covoiturage.php">Retour aux résultats</a>
</header>
<main>
    <section class="fiche-trajet">
        <div class="conducteur">
            <img src="<?= htmlspecialchars($photoConducteur) ?>" 
                 alt="Photo du conducteur" class="photo-profil">

            <div class="info-conducteur">
                <p class="nom"><?= htmlspecialchars($trajet['name']) ?></p>
                <p class="note">⭐ 4.5 / 5</p>
            </div>

            <div class="infos-trajet">
                <p><strong>Départ :</strong> <?= htmlspecialchars($trajet['depart']) ?> – <?= htmlspecialchars($trajet['date']) ?></p>
                <p><strong>Arrivée :</strong> <?= htmlspecialchars($trajet['arrive']) ?></p>
                <p><strong>Places restantes :</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?></p>
                <p><strong>Prix :</strong> <?= htmlspecialchars($trajet['prix']) ?> €</p>
                <form method="post" action="../back-end/reserver.php">
                    <input type="hidden" name="trajet_id" value="<?= $trajet['id'] ?>">
                    <button type="submit" class="btn-reserver">Réserver ce trajet</button>
                </form>
            </div>
        </div>
    </section>
</main>
</body>
</html>

<?php
session_start();
include '../includes/db.php'; // connexion à la base

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$idUtilisateur = $_SESSION['user']['id'];

// Récupérer les infos de l'utilisateur depuis la base
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
$stmt->execute([$idUtilisateur]);
$user = $stmt->fetch();

// Récupérer les réservations de l'utilisateur
$stmt = $pdo->prepare("
  SELECT r.id AS res_id, t.id AS trajet_id, t.depart, t.arrive, t.date, u2.name AS chauffeur, t.prix
  FROM reservation r
  JOIN trajets t ON r.trajet_id = t.id
  JOIN utilisateur u2 ON t.utilisateur_id = u2.id
  WHERE r.utilisateur_id = ?
  ORDER BY t.date DESC
");
$stmt->execute([$idUtilisateur]);
$trajetsReserves = $stmt->fetchAll();

// Récupérer les trajets disponibles (hors réservations déjà prises par cet utilisateur)
$stmt = $pdo->prepare("
  SELECT t.id, t.depart, t.arrive, t.date, t.prix, t.places_disponibles, u.name AS chauffeur
  FROM trajets t
  JOIN utilisateur u ON t.utilisateur_id = u.id
  WHERE t.statut = 'disponible'
  AND t.places_disponibles > 0
  AND t.id NOT IN (SELECT trajet_id FROM reservation WHERE utilisateur_id = ?)
  ORDER BY t.date ASC
");
$stmt->execute([$idUtilisateur]);
$trajetsDisponibles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace - EcoRide</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <main>
        <section class="espace-utilisateur">
            <!-- Profil -->
            <div class="profil">
                <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'https://randomuser.me/api/portraits/women/18.jpg' ?>" 
                alt="photo utilisateur" class="photo-utilisateur">
                <div class="infos-profil">
                    <h2>Bonjour, <?= htmlspecialchars($user['name']) ?></h2>
                    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
                    <p>Crédits : <?= htmlspecialchars($user['credit']) ?></p>
                    <p>Téléphone : <?= htmlspecialchars($user['telephone'] ?? 'Non renseigné') ?></p>
                </div>  
            </div>

            <!-- Véhicule préféré -->
            <div class="vehicule">
                <h3>Véhicule préféré</h3>
                <p><?= htmlspecialchars($user['vehicule_prefere'] ?? 'Non renseigné') ?></p>
            </div>

            <!-- Mes trajets réservés -->
            <div class="reservation">
                <h3>Mes trajets réservés</h3>
                <ul>
                    <?php if ($trajetsReserves): ?>
                        <?php foreach ($trajetsReserves as $trajet): ?>
                            <li>
                                <?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['arrive']) ?> |
                                <?= date('d M Y à H:i', strtotime($trajet['date'])) ?> |
                                Chauffeur : <?= htmlspecialchars($trajet['chauffeur']) ?> |
                                Prix : <?= htmlspecialchars($trajet['prix']) ?> crédits
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Aucun trajet réservé pour le moment.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Trajets disponibles -->
            <div class="disponibles">
                <h3>Trajets disponibles</h3>
                <ul>
                    <?php if ($trajetsDisponibles): ?>
                        <?php foreach ($trajetsDisponibles as $trajet): ?>
                            <li>
                                <?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['arrive']) ?> |
                                <?= date('d M Y à H:i', strtotime($trajet['date'])) ?> |
                                Chauffeur : <?= htmlspecialchars($trajet['chauffeur']) ?> |
                                Prix : <?= htmlspecialchars($trajet['prix']) ?> crédits |
                                Places dispo : <?= htmlspecialchars($trajet['places_disponibles']) ?>

                                <form action="../back-end/reserver.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="trajet_id" value="<?= $trajet['id'] ?>">
                                    <button type="submit">Réserver</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Aucun trajet disponible pour le moment.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <button class="modifier">Modifier mes informations</button>
        </section>
    </main>
</body>
</html>

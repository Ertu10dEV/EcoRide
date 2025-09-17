<?php
include 'db.php';

$sql = "SELECT t.id, t.départ, t.arrivé, t.date, u.name 
        FROM trajets t 
        JOIN Utilisateur u ON t.utilisateur_id = u.id";

$result = $conn->query($sql);

// Vérifier si la requête a fonctionné
if($result === false){
    die("Erreur SQL : " . $conn->error);
}

// Afficher les trajets
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Trajet de " . $row["départ"] . " à " . $row["arrivé"] . " le " . $row["date"] . " proposé par " . $row["name"] . "<br>";
    }
} else {
    echo "Aucun trajet disponible.";
}

$conn->close();
?>

<?php
include 'db.php';

// Vérifie si le formulaire a été soumis
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête SQL pour ajouter l'utilisateur
    $sql = "INSERT INTO Utilisateur (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

$conn->close();
?>

<!-- Formulaire HTML simple -->
<form method="post" action="">
    <input type="text" name="name" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <button type="submit" name="submit">S'inscrire</button>
</form>

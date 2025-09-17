<?php
include '../includes/db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $credits = 20;

    // Préparer la requête
    $stmt = $pdo->prepare("INSERT INTO utilisateur (name, email, password, credit) VALUES (:name, :email, :password, :credit)");

    // Exécuter avec les valeurs
    if ($stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $password,
        ':credit' => 20
    ])) {
        header("Location: ../front-end/login.php");
        exit;
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Erreur : " . $errorInfo[2];
    }
}
?>

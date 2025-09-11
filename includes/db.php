<?php
$DB_HOST = 'localhost';
$DB_NAME = 'ecoride';   // ton nom de base
$DB_USER = 'root';      // utilisateur par défaut XAMPP
$DB_PASS = '';          // mot de passe vide sur XAMPP

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>

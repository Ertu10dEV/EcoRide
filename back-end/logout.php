<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// --- Redirection vers la page de connexion ---
header("Location: ../front-end/login.php");
exit;
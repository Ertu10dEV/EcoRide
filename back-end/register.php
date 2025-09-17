<?php
require '../includes/db.php';
session_start();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || strlen($password) < 8) {
        $error = "Tous les champs sont obligatoires et le mot de passe doit contenir au moins 8 caractères.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Un compte existe déjà avec cet email.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateur (name, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$name, $email, $hash]);
            $success = "✅ Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        }
    }
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
    </head>

    <body>
        <h1>Créer un compte</h1>

        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Nom :</label><br>
            <input name="name" required><br><br>

            <label>Email :</label><br>
            <input name="email" type="email" required><br><br>

            <label>Mot de passe :</label><br>
            <input name="password" type="password" required><br><br>

            <button type="submit">S'inscrire</button>
        </form>

        <p>Déjà un compte ? <a href="../login.php">Se connecter</a></p>
    </body>
    
</html>

<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || strlen($password) < 8) {
        $error = "Nom, email valides et mot de passe (≥ 8 caractères) requis.";
    } else {
        // Vérifie si un compte existe déjà avec cet email
        $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Un compte existe déjà avec cet email.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateur (name,email,password,role) VALUES (?,?,?, 'admin')");
            $stmt->execute([$name,$email,$hash]);
            $success = "✅ Compte admin créé avec succès. Supprimez create_admin.php maintenant.";
        }
    }
}
?>
<!doctype html>

<html lang="fr">
<head><meta charset="utf-8"><title>Créer admin</title></head>

<body>

    <h1>Créer un compte admin</h1>

    <?php if(!empty($error)): ?><p style="color:red;"><?=htmlspecialchars($error)?></p><?php endif; ?>
    <?php if(!empty($success)): ?><p style="color:green;"><?=htmlspecialchars($success)?></p><?php endif; ?>

    <form method="post">
        <label>Nom :</label><br>
        <input name="name" required><br><br>

        <label>Email :</label><br>
        <input name="email" type="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input name="password" type="password" required><br><br>

        <button>Créer</button>
</form>

</body>

</html>

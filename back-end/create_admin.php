<?php
require __DIR__ . '/../includes/db.php'; // 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Nettoyage et validation ---
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || strlen($password) < 8) {
        $error = "Nom et email valides requis + mot de passe ≥ 8 caractères.";
    } else {
        try {
            // --- Vérifie si un compte existe déjà ---
            $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = "Un compte existe déjà avec cet email.";
            } else {
                // --- Insertion en base avec mot de passe hashé ---
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("
                    INSERT INTO utilisateur (name, email, password, role, credit)
                    VALUES (?, ?, ?, 'admin', 20)
                ");
                $stmt->execute([$name, $email, $hash]);

                $success = "✅ Compte admin créé avec succès. 
                            Pensez à supprimer ce fichier (create_admin.php) ensuite.";
            }
        } catch (PDOException $e) {
            // Message neutre (on ne montre pas $e->getMessage() à l'utilisateur)
            $error = "Une erreur est survenue lors de la création du compte.";
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Créer un compte admin</title>
</head>
<body>
    <h1>Créer un compte administrateur</h1>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post" novalidate>
        <label>Nom :</label><br>
        <input name="name" required><br><br>

        <label>Email :</label><br>
        <input name="email" type="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input name="password" type="password" required><br><br>

        <button type="submit">Créer</button>
    </form>
</body>
</html>

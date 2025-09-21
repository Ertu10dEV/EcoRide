<?php
require __DIR__ . '/../includes/db.php'; // 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Nettoyage et validation des données ---
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || strlen($password) < 8) {
        $error = "Nom et email valides requis + mot de passe ≥ 8 caractères.";
    } else {
        try {
            // --- Vérifier si l'email existe déjà ---
            $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = "Un compte existe déjà avec cet email.";
            } else {
                // --- Hashage du mot de passe ---
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // --- Insertion dans la base ---
                $stmt = $pdo->prepare("
                    INSERT INTO utilisateur (name, email, password, credit, role)
                    VALUES (?, ?, ?, 20, 'user')
                ");
                $stmt->execute([$name, $email, $hash]);

                // --- Redirection vers la page de login ---
                header("Location: ../front-end/login.php");
                exit;
            }
        } catch (PDOException $e) {
            $error = "Une erreur est survenue lors de l'inscription.";
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription utilisateur</h1>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" novalidate>
        <label>Nom :</label><br>
        <input name="name" required><br><br>

        <label>Email :</label><br>
        <input name="email" type="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input name="password" type="password" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>

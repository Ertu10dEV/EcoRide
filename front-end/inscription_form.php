<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRide - Inscription</title>
    <link rel="stylesheet" href="../css/styles.css"/>
</head>
<body>
    <header>
        <h1 class="logo">EcoRide</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="covoiturage.php">Covoiturage</a></li>
                <li><a href="login.php">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <main class="connexion">
        <h1>Créer un compte</h1>

        <form action="../back-end/inscription.php" method="POST" class="form-ajout">
            <label for="pseudo">Pseudo</label>
            <input id="pseudo" name="name" type="text" required/>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" required/>

            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required minlength="8"/>

            <p class="aide-mdp">Règle : 8 caractères minimum.</p>

            <button type="submit" name="submit" class="modifier">S'inscrire</button>
            <p class="petit">Déjà inscrit ? <a href="login.php">Se connecter</a></p>

            <div id="message" class="message"></div>
        </form>
    </main>

    <footer>
        <p>© 2025 EcoRide – contact@ecoride.fr</p>
    </footer>

    <script src="../js/signup.js"></script>
</body>

</html>
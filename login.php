<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion EcoRide</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<main>

    <section class="connexion">
        <h1>Connexion à EcoRide</h1>

        <form class="formulaire-connexion">
          <div class="champ">  
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" required>
          </div> 

          <div class="champ">
            <label for="motdepasse">Mot de passe:</label>
            <input type="password" id="mot de passe" name="motdepasse" required>
          </div>  

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore de compte? <a href="#">Créer un compte</a></p>
    </section>

</main>
</body>
</html>
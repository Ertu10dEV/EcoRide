<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer un trajet - EcoRide</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    
    <main>
        <section class="form-ajout">
            <h2>Proposer un trajet</h2>

            <form action="#" method="post">

                <label for="depart">Ville de départ</label>
                <input type="text" id="depart" name="depart" required>

                <label for="arrivee">Ville d'arrivée</label>
                <input type="text" id="arrivee" name="arrivee" required>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <label for="heure">Heure de départ</label>
                <input type="time" id="heure" name="heure" required>

                <label for="places">Places disponibles</label>
                <input type="number" id="places" name="places" min="1" max="8" required>

                <label for="prix">Prix (en € )</label>
                <input type="number" id="prix" name="prix" step="0.5" required>

                <button type="submit">Publier le trajet</button>

            </form>
        </section>            
    </main>
    
</body>
</html>
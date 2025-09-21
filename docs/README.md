# EcoRide - Plateforme de covoiturage éco-responsable

EcoRide est une application web (front-end) qui permet de rechercher un trajet de covoiturage et de consulter un page de détail.
Objectif : poposer une solution plus "verte" et "économique" avec une interface simple.

## Fonctionnalités (version front)
-Page d'accueil avec des recherche (départ, arrivée, date)
-Page résultats avec cartes de trajets
-Page détails d'un covoiturage (conducteur, véhicule, prix, règles, bouton "Réserver")
-Page connexion (maquette fonctionnelle, sans vrai back)
-Page espace utilisateur (profil/infos - affichage statique pour l'instant)
-Page ajout de trajet (formulaire - affichage statique également)
-Design simple, responsive de base (mobile/desktop)

Pas de base de donées ni de vraie API pour le moment. Le back sera ajouté plus tard (PHP + MySQL).

Arborescence du projet 

EcoRide/
├─ index.html # Accueil + recherche
├─ covoiturage.html # Résultats
├─ details.html # Détail d'un trajet
├─ login.html # Connexion
├─ profil.html # Espace utilisateur
├─ ajout-trajet.html # Formulaire ajout
├─ css/
│ └─ styles.css # Styles globaux
├─ js/
│ └─ app.js # (placeholder)
└─ img/
├─ logo.png # Logo EcoRide
└─ hero.jpg # Image d'accueil (Pixabay)

# Tech utilisées
-*HTML5 / CSS3 / JavaScript*
-Pas de framework CSS (pas de Bootstrap)
-Editeur : *VsCode*
-Versionning : *Git & Github*

# Lancer le projet en local
Pas besoin d'installer quoi que ce soit :
1. Télécharge ou clone le dépôt
2. Ouvre 'index.html' dans ton avigateur

Option sympa (facultatif) : utiliser l'extention *Live Server* de VsCode.

# Déploiement (Front) - GitHub Pages
1. Pousse ton code sur GitHub (branche 'main')
2. Sur GitHub: **Settings** -> **Pages** 
3. Section "Build and deployment" :
    -Source : **Deploy from a branch**
    -Branch : **main** / **root**
    -**SAVE**
4. Attendre 1-2 minutes, ton site sera dispo sur : 
'https://<ton-pseudo>.github.io/<nom-du-repo>/'

# Sécurité (ce qui est prévu)
Côté front (déjà pris en compte) :
    - Champs de formulaire typés ('type="email"', 'type="date"'...)
    -Attributs HTML ('required' , 'min' , etc..)
    -Messages d'erreur côté client (à compléter)

Côté back (à faire plus tard) :
    - Validation/sanitation serveur (PHP)
    - Mots de passe hashés (bcrypt)
    - Requêtes SQL avec *PDO + requêtes préparées*
    - Jetons CSRF pour formulaires sensibles


# Roadmap (prochaine US)
- US7 : Création de compte + règles mot de passe + crédits de départ
- US8 : Espace utilisateur (vraie persistance)
- US9 : Saisie de voyage (enregistrement)
- US10 : Historique de covoiturages
- US11 : Démarrer/Arrêter un covoiturage
- US12/US13 : Espace employé / admin

# Crédits 
-Photo d'accueil : **PIXABAY** (libre de droits)
-Avatars : **RANDOMUSER.ME**
-Aide ponctuelle: **CHATGPT** (idées et relectures)


# Contact
Projet pédagogique - ECF (TP Graduate Développeur web fullstack )
Auteur : *VURAL Ertugrul* - *vural.ertu@outlook.fr*

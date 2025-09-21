-- ==========================================
-- Table utilisateur
-- ==========================================
CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    credit INT DEFAULT 20,
    role VARCHAR(20) DEFAULT 'membre',
    telephone VARCHAR(20) DEFAULT NULL,
    vehicule_prefere VARCHAR(100) DEFAULT NULL,
    photo VARCHAR(255) DEFAULT NULL
);

-- ==========================================
-- Table trajets
-- ==========================================
CREATE TABLE IF NOT EXISTS trajets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    depart VARCHAR(100) NOT NULL,
    arrive VARCHAR(100) NOT NULL,
    date DATETIME NOT NULL,
    utilisateur_id INT NOT NULL,
    prix INT NOT NULL,
    places_disponibles INT DEFAULT 3,
    statut VARCHAR(20) DEFAULT 'disponible',
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

-- ==========================================
-- Table reservation
-- ==========================================
CREATE TABLE IF NOT EXISTS reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    trajet_id INT NOT NULL,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),
    FOREIGN KEY (trajet_id) REFERENCES trajets(id)
);

-- ==========================================
-- Données de test
-- ==========================================
INSERT INTO utilisateur (name, email, password, credit, role)
VALUES
('Ertu', 'ertu@ecoride.fr', '1234', 50, 'membre'),
('MarineEco', 'marineeco@ecoride.fr', 'Azerty1234', 30, 'chauffeur'),
('Naim67', 'naim67@ecoride.fr', 'Azerty1234', 30, 'chauffeur'),
('Izelgic', 'izelgic@ecoride.fr', '$2y$10$hQH9E0fakeHashForDemo', 20, 'membre');

INSERT INTO trajets (depart, arrive, date, utilisateur_id, prix, places_disponibles, statut)
VALUES
('Paris', 'Strasbourg', '2025-09-15 14:30:00', 2, 20, 3, 'disponible'),
('Colmar', 'Lyon', '2025-09-16 09:00:00', 2, 15, 3, 'disponible'),
('Lyon', 'Paris', '2025-09-17 18:00:00', 3, 25, 3, 'disponible'),
('Strasbourg', 'Colmar', '2025-09-18 10:00:00', 3, 10, 3, 'disponible');

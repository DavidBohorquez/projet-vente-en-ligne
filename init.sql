CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    motDePasse VARCHAR(255) NOT NULL,
    dateInscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    type ENUM('client', 'admin', 'vendeur') DEFAULT 'client',
    adresseLivraison TEXT NULL,
    boutique VARCHAR(255) NULL,
    commission DECIMAL(5,2) NULL,
    niveauAcces INT NULL,
    derniereConnexion DATETIME NULL
);

CREATE TABLE Categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE Produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    type ENUM('physique', 'numerique', 'perissable') NOT NULL,
    poids DECIMAL(10, 2) NULL,
    longueur DECIMAL(10, 2) NULL,
    largeur DECIMAL(10, 2) NULL,
    hauteur DECIMAL(10, 2) NULL,
    lienTelechargement VARCHAR(255) NULL,
    tailleFichier DECIMAL(10, 2) NULL,
    formatFichier VARCHAR(255) NULL,
    dateExpiration DATETIME NULL,
    temperatureStockage DECIMAL(5, 2) NULL,
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id)
);

CREATE TABLE Panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id)
);

CREATE TABLE Panier_Produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    panier_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (panier_id) REFERENCES Panier(id),
    FOREIGN KEY (produit_id) REFERENCES Produit(id)
);

CREATE TABLE Commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    dateCommande DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id)
);

CREATE TABLE Commande_Produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prixUnitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES Commande(id),
    FOREIGN KEY (produit_id) REFERENCES Produit(id)
);
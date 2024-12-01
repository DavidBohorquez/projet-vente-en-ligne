<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Davidb\ProjetVenteEnLigne\Entity\Produit\ProduitPhysique;
use Davidb\ProjetVenteEnLigne\Entity\Produit\ProduitNumerique;
use Davidb\ProjetVenteEnLigne\Entity\Produit\ProduitPerissable;
use Davidb\ProjetVenteEnLigne\Entity\Categorie;
use Davidb\ProjetVenteEnLigne\Entity\Panier;
use Davidb\ProjetVenteEnLigne\Entity\Utilisateur\Client;
use Davidb\ProjetVenteEnLigne\Entity\Utilisateur\Admin;
use Davidb\ProjetVenteEnLigne\Entity\Utilisateur\Vendeur;

// Création de différents types de produits
echo "<h2> Création de différents types de produits ...\n </h2>";

// Création d'un produit physique
$produit1 = new ProduitPhysique(
    "Ordinateur portable", 
    "Un ordinateur performant pour tous vos besoins.", 
    1200.99, 
    10, 
    2.5,  // Poids en kg
    35,    // Longueur en cm
    25,    // Largeur en cm
    2      // Hauteur en cm
);

// Création d'un produit numérique
$produit2 = new ProduitNumerique(
    "Logiciel Antivirus", 
    "Protégez votre PC avec cet antivirus de pointe.", 
    49.99, 
    100, 
    "https://example.com/telecharger/antivirus",  // Lien de téléchargement
    250,   // Taille du fichier en Mo
    "exe"   // Format du fichier
);

// Création d'un produit périssable
$produit3 = new ProduitPerissable(
    "Pomme", 
    "Pomme bio fraîche.", 
    0.5, 
    50, 
    new \DateTime('2024-12-15'),  // Date d'expiration
    4      // Température de stockage en °C
);

echo "Produits créés :\n <br>";
//var_dump($produit1, $produit2, $produit3);
//echo $produit1->getNom();
echo '<pre>' . $produit1->toJson() . '</pre>';
echo '<pre>' . $produit2->toJson() . '</pre>';
echo '<pre>' . $produit3->toJson() . '</pre>';


// Manipulation du panier
echo "<br> <h2> \nManipulation du panier ...\n </h2>";

$panier = new Panier();
$panier->ajouterArticle($produit1, 1); // Ajout d'un ordinateur
$panier->ajouterArticle($produit3, 10); // Ajout de 10 pommes
echo "Articles dans le panier après ajouts :\n <br>";
//var_dump($panier);
echo '<pre>' . $panier->afficherProduits() . '</pre>';

$panier->retirerArticle($produit3, 5); // Retirer 5 pommes
echo "Articles dans le panier après retrait :\n <br>";
echo '<pre>' . $panier->afficherProduits() . '</pre>';

$total = $panier->calculerTotal();
echo "Total du panier : {$total} €\n <br>";

$panier1 = clone $panier;
$panier->vider();
echo "Panier vidé :\n <br>";
echo '<pre>' . $panier->afficherProduits() . '</pre>';

// Création et gestion des utilisateurs
echo "<br> <h2> \nCréation et gestion des utilisateurs ...\n </h2>";

// Création d'un client
$client = new Client(
    "Jean Dupont", 
    "jean.dupont@example.com", 
    "password123", 
    "123 Rue de Paris, 75001 Paris",  // Adresse de livraison
    $panier1  // Panier du client
);

// Mise à jour du profil
$client->mettreAJourProfil("Jean Dupont", "jean.new@example.com", "newpassword123");

echo "<h3> Profil du client après mise à jour :\n </h3>";
//var_dump($client);
echo '<pre>' . $client->toJson() . '</pre>';

// Création d'un administrateur
$admin = new Admin(
    "Admin User", 
    "admin@example.com", 
    "securepassword", 
    niveauAcces: 5, 
    derniereConnexion: new DateTime() // Dernière connexion à l'instant actuel
);

echo "<h3> Profil de l'administrateur :\n </h3>";
echo '<pre>' . $admin->toJson() . '</pre>';

// Création d'un vendeur
$vendeur = new Vendeur(
    "Marc Vendeur", 
    "marc.vendeur@example.com", 
    "vendeurpass", 
    "La Boutique de Marc", 
    10.5
);

$vendeur->ajouterProduit($produit1);
$vendeur->ajouterProduit($produit3);
echo "<h3> Profil du vendeur et ses produits :\n </h3>";
echo '<pre>' . $vendeur->toJson() . '</pre>';

// Catégories et leur relation avec les produits
echo "<br> <h2> \nCatégories et gestion des produits dans les catégories ...\n </h2>";

$categorieTechnologie = new Categorie("Technologie", "Produits technologiques modernes");
$categorieTechnologie->ajouterProduit($produit1);
$categorieTechnologie->ajouterProduit($produit2);

$categorieAlimentation = new Categorie("Alimentation", "Produits frais et bio");
$categorieAlimentation->ajouterProduit($produit3);

echo "<h3> Produits dans la catégorie Technologie :\n </h3>";
//var_dump($categorieTechnologie->listerProduits());
echo '<pre>'. $categorieTechnologie->toJson() . '<pre>';

echo "<h3> Produits dans la catégorie Alimentation :\n </h3>";
echo '<pre>'. $categorieAlimentation->toJson() . '<pre>';

// Simulation d'une commande (vide pour l'instant)
echo "<h3> \nPassage d'une commande pour le client ...\n <h3>";
$client->passerCommande(); // Méthode à implémenter plus tard
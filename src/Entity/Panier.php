<?php

declare(strict_types=1);

namespace Davidb\ProjetVenteEnLigne\Entity;

use Davidb\ProjetVenteEnLigne\Entity\Produit\Produit;

/**
 * Classe représentant un panier d'achats.
 */
class Panier
{
    /**
     * Articles du panier.
     * Tableau associatif où la clé est l'ID du produit,
     * et la valeur contient un tableau avec les clés :
     * - 'produit' : le produit lui-même
     * - 'quantite' : la quantité de ce produit
     * 
     * @var array
     */
    private array $articles;

    /**
     * Date de création du panier.
     * @var \DateTime
     */
    private \DateTime $dateCreation;

    /**
     * Constructeur de la classe Panier.
     */
    public function __construct()
    {
        $this->articles = [];
        $this->dateCreation = new \DateTime();
    }

    // Getters

    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Ajouter un article au panier.
     * 
     * @param Produit $produit
     * @param int $quantite
     * @throws \InvalidArgumentException Si la quantité est négative ou zéro.
     */
    public function ajouterArticle(Produit $produit, int $quantite): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité doit être supérieure à zéro.");
        }

        $id = $produit->getId();
        if (isset($this->articles[$id])) {
            // Si le produit est déjà présent, on augmente la quantité
            $this->articles[$id]['quantite'] += $quantite;
        } else {
            // Sinon, on ajoute le produit avec la quantité
            $this->articles[$id] = [
                'produit' => $produit,
                'quantite' => $quantite,
            ];
        }
    }

    /**
     * Retirer un article du panier.
     * 
     * @param Produit $produit
     * @param int $quantite
     * @throws \InvalidArgumentException Si la quantité est négative.
     */
    public function retirerArticle(Produit $produit, int $quantite): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité doit être supérieure à zéro.");
        }

        $id = $produit->getId();
        if (isset($this->articles[$id])) {
            $this->articles[$id]['quantite'] -= $quantite;
            if ($this->articles[$id]['quantite'] <= 0) {
                unset($this->articles[$id]);
            }
        }
    }

    /**
     * Vider complètement le panier.
     */
    public function vider(): void
    {
        $this->articles = [];
    }

    /**
     * Calculer le total du panier en fonction des prix TTC.
     * 
     * @return float
     */
    public function calculerTotal(): float
    {
        $total = 0;
        foreach ($this->articles as $article) {
            /** @var Produit $produit */
            $produit = $article['produit'];
            $quantite = $article['quantite'];
            $total += $produit->calculerPrixTTC() * $quantite;
        }
        return $total;
    }

    /**
     * Compter le nombre total d'articles dans le panier.
     * 
     * @return int
     */
    public function compterArticles(): int
    {
        $total = 0;
        foreach ($this->articles as $article) {
            $total += $article['quantite'];
        }
        return $total;
    }

    /**
     * Obtenir les produits du panier en format JSON.
     * 
     * @return string
     */
    public function afficherProduits(): string
    {
        $produitsArray = [];
        
        foreach ($this->articles as $article) {
            /** @var Produit $produit */
            $produit = $article['produit'];
            $produitsArray[] = [
                'produit' => json_decode($produit->toJson()), // Décoder le JSON pour l'ajouter comme un tableau
                'quantite' => $article['quantite']
            ];
        }

        return json_encode($produitsArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
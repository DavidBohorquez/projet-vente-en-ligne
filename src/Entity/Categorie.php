<?php

declare(strict_types=1);

namespace Davidb\ProjetVenteEnLigne\Entity;

use Davidb\ProjetVenteEnLigne\Entity\Produit\Produit;

/**
 * Classe représentant une catégorie de produits.
 */
class Categorie
{
    /**
     * Identifiant unique de la catégorie.
     * @var int|null
     */
    private ?int $id;

    /**
     * Nom de la catégorie.
     * @var string
     */
    private string $nom;

    /**
     * Description de la catégorie.
     * @var string
     */
    private string $description;

    /**
     * Liste des produits associés à la catégorie.
     * @var Produit[]
     */
    private array $produits;

    /**
     * Constructeur de la classe Categorie.
     * 
     * @param string $nom
     * @param string $description
     * @param int|null $id
     */
    public function __construct(string $nom, string $description, ?int $id = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->produits = [];
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Ajouter un produit à la catégorie.
     * 
     * @param Produit $produit
     */
    public function ajouterProduit(Produit $produit): void
    {
        $this->produits[] = $produit;
    }

    /**
     * Retirer un produit de la catégorie.
     * 
     * @param Produit $produit
     */
    public function retirerProduit(Produit $produit): void
    {
        foreach ($this->produits as $index => $p) {
            if ($p === $produit) {
                unset($this->produits[$index]);
                $this->produits = array_values($this->produits); // Réindexer l'array
                break;
            }
        }
    }

    /**
     * Retourne la liste des produits de la catégorie.
     * 
     * @return Produit[]
     */
    public function listerProduits(): array
    {
        return $this->produits;
    }

    /**
     * Retourne une représentation JSON de la catégorie et de ses produits.
     * 
     * @return string
     */
    public function toJson(): string
    {
        $produitsArray = array_map(function (Produit $produit) {
            return json_decode($produit->toJson(), true); // Assurez-vous que Produit a une méthode toJson()
        }, $this->produits);

        $data = [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'produits' => $produitsArray,
        ];

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
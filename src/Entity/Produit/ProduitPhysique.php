<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Produit;

use Davidb\ProjetVenteEnLigne\Entity\Produit\Produit;

use JsonSerializable;

/**
 * Classe représentant un produit physique.
 */
class ProduitPhysique extends Produit implements JsonSerializable
{
    /**
     * Poids du produit en kg.
     * @var float
     */
    private float $poids;

    /**
     * Dimensions du produit (en cm).
     * @var float
     */
    private float $longueur;
    private float $largeur;
    private float $hauteur;

    public function __construct(
        string $nom,
        string $description,
        float $prix,
        int $stock,
        float $poids,
        float $longueur,
        float $largeur,
        float $hauteur,
        ?int $id = null
    ) {
        parent::__construct($nom, $description, $prix, $stock, $id);
        $this->poids = $poids;
        $this->longueur = $longueur;
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
    }

    public function calculerVolume(): float
    {
        return $this->longueur * $this->largeur * $this->hauteur;
    }

    public function calculerFraisLivraison(): float
    {
        return $this->poids * 0.5; // Exemple : frais de 0.5 € par kg.
    }

    public function afficherDetails(): string
    {
        return "Produit Physique: {$this->getNom()}, Volume: {$this->calculerVolume()} cm³, Poids: {$this->poids} kg}";
    }

    // Implémentation de JsonSerializable
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    // Redéfinition de toArray pour ajouter des propriétés spécifiques à ProduitPhysique
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['poids'] = $this->poids;
        $data['longueur'] = $this->longueur;
        $data['largeur'] = $this->largeur;
        $data['hauteur'] = $this->hauteur;
        return $data;
    }
}
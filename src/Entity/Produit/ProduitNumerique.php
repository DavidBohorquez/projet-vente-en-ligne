<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Produit;

use JsonSerializable;

/**
 * Classe représentant un produit numérique.
 */
class ProduitNumerique extends Produit implements JsonSerializable
{
     /**
     * Lien de téléchargement.
     * @var string
     */
    private string $lienTelechargement;

    /**
     * Taille du fichier en MB.
     * @var float
     */
    private float $tailleFichier;

    /**
     * Format du fichier (e.g. PDF, MP3).
     * @var string
     */
    private string $formatFichier;

    public function __construct(
        string $nom,
        string $description,
        float $prix,
        int $stock,
        string $lienTelechargement,
        float $tailleFichier,
        string $formatFichier,
        ?int $id = null
    ) {
        parent::__construct($nom, $description, $prix, $stock, $id);
        $this->lienTelechargement = $lienTelechargement;
        $this->tailleFichier = $tailleFichier;
    }

    public function genererLienTelechargement(): string 
    {
        return "{$this->lienTelechargement}?token=" . uniqid();
    }

    public function calculerFraisLivraison(): float
    {
        return 0; // Pas de frais pour les produits numériques.
    }

    public function afficherDetails(): string
    {
        return "Produit Numérique: {$this->getNom()}, Taille: {$this->tailleFichier} MB, Format: {$this->formatFichier}";
    }

    // Implémentation de JsonSerializable
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    // Redéfinition de toArray pour ajouter des propriétés spécifiques à ProduitNumerique
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['lienTelechargement'] = $this->lienTelechargement;
        $data['tailleFichier'] = $this->tailleFichier;
        return $data;
    }
}
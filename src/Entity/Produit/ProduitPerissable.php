<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Produit;

use DateTime;
use JsonSerializable;

/**
 * Classe représentant un produit périssable.
 */
class ProduitPerissable extends Produit implements JsonSerializable
{
    /**
     * Date d'expiration.
     * @var DateTime
     */
    private DateTime $dateExpiration;

    /**
     * Température de stockage recommandée.
     * @var float
     */
    private float $temperatureStockage;

    public function __construct(
        string $nom,
        string $description,
        float $prix,
        int $stock,
        DateTime $dateExpiration,
        float $temperatureStockage,
        ?int $id = null
    ) {
        parent::__construct($nom, $description, $prix, $stock, $id);
        $this->dateExpiration = $dateExpiration;
        $this->temperatureStockage = $temperatureStockage;
    }

    public function estPerime(): bool
    {
        return new DateTime() > $this->dateExpiration;
    }

    public function calculerFraisLivraison(): float
    {
        return parent::calculerPrixTTC() + 5; // Frais supplémentaires pour produits frais.
    }

    public function afficherDetails(): string
    {
        return "Produit Périssable: {$this->getNom()}, Expire le: {$this->dateExpiration->format('Y-m-d')}";
    }

    // Implémentation de JsonSerializable
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    // Redéfinition de toArray pour ajouter des propriétés spécifiques à ProduitPerissable
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['dateExpiration'] = $this->dateExpiration;
        $data['temperatureStockage'] = $this->temperatureStockage . " °C";
        return $data;
    }
}
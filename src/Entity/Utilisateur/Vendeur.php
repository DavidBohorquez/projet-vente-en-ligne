<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Utilisateur;

use Davidb\ProjetVenteEnLigne\Entity\Produit\Produit;

class Vendeur extends Utilisateur
{
    private string $boutique;
    private float $commission;

    public function __construct(
        string $nom,
        string $email,
        string $motDePasse,
        string $boutique,
        float $commission,
        ?int $id = null,
        ?\DateTime $dateInscription = null
    ) {
        parent::__construct($nom, $email, $motDePasse, ['ROLE_VENDEUR'], $id, $dateInscription);
        $this->boutique = $boutique;
        $this->commission = $commission;
    }

    public function ajouterProduit(Produit $produit): void
    {
        // Logic to add a product
    }

    public function gererStock(Produit $produit, int $quantite): void
    {
        // Logic to manage stock
    }

    public function afficherRoles(): string
    {
        return implode(', ', $this->getRoles());
    }
}
<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Produit;

use \Davidb\ProjetVenteEnLigne\Config\ConfigurationManager;

/**
 * Classe abstraite représentant un produit.
 */
abstract class Produit 
{
    // Propriétés
    
    /**
     * Identifiant unique du produit.
     * @var int|null $id.
     * @var string $nom.
     * @var string $description.
     * @var float $prix.
     * @var int $stock.
     */
    private ?int $id;
    private string $nom;
    private string $description;
    private float $prix;
    private int $stock;

    /**
     * Constructeur de la classe Produit.
     * 
     * @param int|null $id
     * @param string $nom
     * @param string $description
     * @param float $prix
     * @param int $stock
     * @throws \InvalidArgumentException Si les données ne respectent pas les règles de validation.
     */
    public function __construct(
        string $nom, 
        string $description,
        float $prix,
        int $stock,
        ?int $id = null
    ) {
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->stock = $stock;
        $this->id = $id;
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
        if(empty($nom)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
        }
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

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void
    {
        if ($prix <= 0) {
            throw new \InvalidArgumentException("Le prix doit être un nombre positif.");
        }
        $this->prix = $prix;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new \InvalidArgumentException("Le stock ne peut pas être négatif.");
        }
        $this->stock = $stock;
    }

    // Méthodes

     /**
     * Calculer le prix TTC avec une TVA de 20%.
     * 
     * @return float
     */
    public function calculerPrixTTC(): float
    {
        $config = ConfigurationManager::getInstance();
        $tva = $config->get('tva');
        return $this->prix * (1 + $tva / 100);
    }

    /**
     * Vérifie si le stock est suffisant pour une quantité donnée.
     * 
     * @param int $quantite
     * @return bool
     */
    public function verifierStock(int $quantite): bool
    {
        return $this->stock >= $quantite; 
    }

    // Méthodes abstraites
    /**
     * Méthode abstraite pour calculer les frais de livraison.
     * 
     * @return float
     */
    abstract public function calculerFraisLivraison(): float;

    /**
     * Méthode abstraite pour afficher les détails du produit.
     * 
     * @return string
     */
    abstract public function afficherDetails(): string;

    // Méthode pour convertir l'objet en tableau
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix,
            'stock' => $this->stock
        ];
    }

     // Méthode pour obtenir l'objet en format JSON
     public function toJson(): string
     {
         return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
     }
}
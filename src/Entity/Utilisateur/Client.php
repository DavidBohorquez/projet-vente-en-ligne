<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Utilisateur;

use DateTime;

use Davidb\ProjetVenteEnLigne\Entity\Panier;

/**
 * Classe représentant un client dans le système.
 */
class Client extends Utilisateur
{
    /**
     * Adresse de livraison du client.
     * @var string
     */
    private string $adresseLivraison;

    /**
     * Panier du client.
     * @var Panier
     */
    private Panier $panier;

    /**
     * Constructeur de la classe Client.
     *
     * @param string $nom Nom du client.
     * @param string $email Email du client.
     * @param string $motDePasse Mot de passe non hashé.
     * @param string $adresseLivraison Adresse de livraison.
     * @param Panier $panier Instance du panier.
     * @param int|null $id Identifiant du client.
     * @param DateTime|null $dateInscription Date d'inscription.
     */
    public function __construct(
        string $nom,
        string $email,
        string $motDePasse,
        string $adresseLivraison,
        Panier $panier,
        ?int $id = null,
        ?DateTime $dateInscription = null
    ) {
        parent::__construct($nom, $email, $motDePasse, ['ROLE_CLIENT'], $id, $dateInscription);
        $this->adresseLivraison = $adresseLivraison;
        $this->panier = $panier;
    }

    /**
     * Retourne l'adresse de livraison du client.
     * @return string
     */
    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }

    /**
     * Définit l'adresse de livraison.
     *
     * @param string $adresseLivraison Nouvelle adresse.
     */
    public function setAdresseLivraison(string $adresseLivraison): void
    {
        $this->adresseLivraison = $adresseLivraison;
    }

    /**
     * Retourne le panier du client.
     * @return Panier
     */
    public function getPanier(): Panier
    {
        return $this->panier;
    }

    /**
     * Passe une commande à partir des articles du panier.
     *
     * @return void
     */
    public function passerCommande(): void
    {
        // TODO: Implémenter la logique de création de commande.
    }

    /**
     * Consulte l'historique des commandes passées.
     *
     * @return array
     */
    public function consulterHistorique(): array
    {
        // TODO: Retourner l'historique des commandes.
        return [];
    }

    /**
     * Retourne une représentation textuelle des rôles.
     *
     * @return string
     */
    public function afficherRoles(): string
    {
        return implode(', ', $this->getRoles());
    }
    
    public function toArray(): array
    {
        $data = parent::toArray();
        $data['adresseLivraison'] = $this->adresseLivraison;
         // Utilisation de la méthode afficherProduits() pour afficher les produits du panier
        $data['panier'] = json_decode($this->panier->afficherProduits(), true);
        return $data;
    }
}
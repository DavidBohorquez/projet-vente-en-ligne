<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Utilisateur;

use DateTime;

/**
 * Classe représentant un administrateur dans le système.
 */
class Admin extends Utilisateur
{
    /**
     * Niveau d'accès de l'administrateur.
     * @var int
     */
    private int $niveauAcces;

    /**
     * Dernière connexion de l'administrateur.
     * @var DateTime
     */
    private DateTime $derniereConnexion;

    /**
     * Constructeur de la classe Admin.
     *
     * @param string $nom Nom de l'administrateur.
     * @param string $email Email de l'administrateur.
     * @param string $motDePasse Mot de passe non hashé.
     * @param int $niveauAcces Niveau d'accès.
     * @param DateTime $derniereConnexion Date de dernière connexion.
     * @param int|null $id Identifiant de l'administrateur.
     * @param DateTime|null $dateInscription Date d'inscription.
     */
    public function __construct(
        string $nom,
        string $email,
        string $motDePasse,
        int $niveauAcces,
        DateTime $derniereConnexion,
        ?int $id = null,
        ?DateTime $dateInscription = null
    ) {
        parent::__construct($nom, $email, $motDePasse, ['ROLE_ADMIN'], $id, $dateInscription);
        $this->niveauAcces = $niveauAcces;
        $this->derniereConnexion = $derniereConnexion;
    }

    /**
     * Gère les utilisateurs (ajout, modification, suppression).
     *
     * @return void
     */
    public function gererUtilisateurs(): void
    {
        // TODO: Implémenter la logique de gestion des utilisateurs.
    }

    /**
     * Accède au journal système.
     *
     * @return array
     */
    public function accederJournalSysteme(): array
    {
        // TODO: Retourner les logs du système.
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
}
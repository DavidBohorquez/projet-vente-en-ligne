<?php

declare(strict_types=1);
namespace Davidb\ProjetVenteEnLigne\Entity\Utilisateur;

/**
 * Classe abstraite représentant un utilisateur.
 */
abstract class Utilisateur
{
    // Propriétés

    /**
     * Identifiant unique de l'utilisateur.
     * @var int|null $id.
     * @var string $nom.
     * @var string $email.
     * @var string $motDePasse.
     * @var \DataTime $dateInscription.
     */
    private ?int $id;
    private string $nom;
    private string $email;
    private string $motDePasse;
    private \DateTime $dateInscription;

    /**
     * Rôles de l'utilisateur.
     * @var array
     */
    protected array $roles;

    /**
     * Constructeur de la classe Utilisateur.
     *
     * @param int|null $id L'identifiant de l'utilisateur, ou null pour un nouvel utilisateur.
     * @param string $nom Le nom de l'utilisateur.
     * @param string $email L'adresse email de l'utilisateur.
     * @param string $motDePasse Le mot de passe de l'utilisateur.
     * @param array roles.
     * @param \DateTime $dateIncription.
     * @throws \InvalidArgumentException Si les données ne respectent pas les règles de validation.
     */
    public function __construct(
        string $nom,
        string $email,
        string $motDePasse,
        array $roles,
        ?int $id = null,
        ?\DateTime $dateInscription = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->roles = $roles;
        $this->setMotDePasse($motDePasse); //password_hash($motDePasse, PASSWORD_BCRYPT);
        $this->dateInscription = $dateInscription ?? new \DateTime();
    }

    // Getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * Définit l'identifiant de l'utilisateur.
     * 
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Définit le nom de l'utilisateur.
     * 
     * @param string $nom
     * @throws \InvalidArgumentException Si le nom est vide.
     */
    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
        }
        $this->nom = $nom;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Définit l'adresse email de l'utilisateur.
     * 
     * @param string $email
     * @throws \InvalidArgumentException Si l'adresse email n'est pas valide.
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("L'email fourni n'est pas valide.");
        }
        $this->email = $email;
    }

    /**
     * Retourne le mot de passe de l'utilisateur.
     * 
     * @return string
     */
    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    /**
     * Définit le mot de passe de l'utilisateur.
     * 
     * @param string $motDePasse
     * @throws \InvalidArgumentException Si le mot de passe contient moins de 8 caractères.
     */
    public function setMotDePasse(string $motDePasse): void
    {
        if (strlen($motDePasse) < 8) {
            throw new \InvalidArgumentException("Le mot de passe doit comporter au moins 8 caractères.");
        }
        $this->motDePasse = $motDePasse;
    }

    public function getDateInscription(): \DateTime
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTime $dateInscription): void
    {
        $this->dateInscription = $dateInscription;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

     // Méthodes

    /**
     * Vérifie si un mot de passe correspond à celui de l'utilisateur.
     * 
     * @param string $motDePasse Le mot de passe à vérifier.
     * @return bool Retourne true si le mot de passe correspond, sinon false.
     */
     public function verifierMotDePasse(string $motDePasse): bool
     {
        return $this->motDePasse === $motDePasse;
     }

     /**
     * Met à jour le profil de l'utilisateur.
     * 
     * @param string $nom Le nouveau nom de l'utilisateur.
     * @param string $email La nouvelle adresse email de l'utilisateur.
     * @param string $motDePasse Le nouveau mot de passe de l'utilisateur.
     * @return void
     */
    public function mettreAJourProfil(string $nom, string $email, string $motDePasse): void
    {
        $this->setNom($nom);
        $this->setEmail($email);
        $this->setMotDePasse($motDePasse);
    }

    /**
     * Méthode abstraite pour afficher les rôles de l'utilisateur.
     * 
     * @return string
     */
    abstract public function afficherRoles(): string;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email,
            'roles' => $this->roles,
            'dateInscription' => $this->dateInscription ? $this->dateInscription->format('Y-m-d H:i:s') : null
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
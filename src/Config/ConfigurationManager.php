<?php

declare(strict_types=1);

namespace Davidb\ProjetVenteEnLigne\Config;

/**
 * Classe pour gérer la configuration du projet (Singleton).
 */
class ConfigurationManager
{
    private static ?ConfigurationManager $instance = null;
    private array $config;

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct()
    {
        $this->config = [
            'tva' => 20.0, // Par défaut : 20%
            'devise' => 'EUR',
            'frais_livraison_base' => 5.0,
            'email_contact' => 'contact@boutique.com',
        ];
    }

    // Méthode statique pour obtenir l'instance unique
    public static function getInstance(): ConfigurationManager
    {
        if (self::$instance === null) {
            self::$instance = new ConfigurationManager();
        }
        return self::$instance;
    }

    // Obtenir un paramètre
    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->config)) {
            throw new \InvalidArgumentException("La clé de configuration '{$key}' n'existe pas.");
        }
        return $this->config[$key];
    }

    // Définir un paramètre
    public function set(string $key, mixed $value): void
    {
        $this->validate($key, $value);
        $this->config[$key] = $value;
    }

    // Charger une configuration depuis un tableau ou un fichier
    public function charger(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    // Validation des paramètres
    private function validate(string $key, mixed $value): void
    {
        switch ($key) {
            case 'tva':
                if (!is_float($value) || $value < 0 || $value > 100) {
                    throw new \InvalidArgumentException("La TVA doit être un pourcentage entre 0 et 100.");
                }
                break;
            case 'devise':
                if (!is_string($value) || strlen($value) !== 3) {
                    throw new \InvalidArgumentException("La devise doit être un code ISO 4217 à 3 lettres.");
                }
                break;
            case 'frais_livraison_base':
                if (!is_float($value) || $value < 0) {
                    throw new \InvalidArgumentException("Les frais de livraison doivent être un montant positif.");
                }
                break;
            case 'email_contact':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException("L'email de contact est invalide.");
                }
                break;
            default:
                throw new \InvalidArgumentException("Clé de configuration non reconnue : '{$key}'.");
        }
    }
}
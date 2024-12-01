<?php

declare(strict_types=1);

namespace Davidb\ProjetVenteEnLigne\Factory;

use Davidb\ProjetVenteEnLigne\Entity\Produit\ProduitPhysique;
use Davidb\ProjetVenteEnLigne\Entity\Produit\ProduitNumerique;
use Davidb\ProjetVenteEnLigne\Entity\Produit\ProduitPerissable;
use InvalidArgumentException;

class ProduitFactory
{
    /**
     * Crée un produit en fonction du type et des données fournies.
     * 
     * @param string $type Type du produit ("physique", "numerique", "perissable").
     * @param array $data Données nécessaires à la création du produit.
     * @return mixed Instance du produit créé.
     * @throws InvalidArgumentException Si le type ou les données sont invalides.
     */
    public static function creerProduit(string $type, array $data)
    {
        switch (strtolower($type)) {
            case 'physique':
                return self::creerProduitPhysique($data);
            case 'numerique':
                return self::creerProduitNumerique($data);
            case 'perissable':
                return self::creerProduitPerissable($data);
            default:
                throw new InvalidArgumentException("Type de produit invalide : $type");
        }
    }

    private static function creerProduitPhysique(array $data): ProduitPhysique
    {
        self::validerDonnees($data, ['nom', 'description', 'prix', 'stock', 'poids', 'longueur', 'largeur', 'hauteur']);
        return new ProduitPhysique(
            $data['nom'],
            $data['description'],
            (float)$data['prix'],
            (int)$data['stock'],
            (float)$data['poids'],
            (float)$data['longueur'],
            (float)$data['largeur'],
            (float)$data['hauteur'],
            $data['id'] ?? null
        );
    }

    private static function creerProduitNumerique(array $data): ProduitNumerique
    {
        self::validerDonnees($data, ['nom', 'description', 'prix', 'stock', 'lienTelechargement', 'tailleFichier', 'formatFichier']);
        return new ProduitNumerique(
            $data['nom'],
            $data['description'],
            (float)$data['prix'],
            (int)$data['stock'],
            $data['lienTelechargement'],
            (float)$data['tailleFichier'],
            $data['formatFichier'],
            $data['id'] ?? null
        );
    }

    private static function creerProduitPerissable(array $data): ProduitPerissable
    {
        self::validerDonnees($data, ['nom', 'description', 'prix', 'stock', 'dateExpiration', 'temperatureStockage']);
        return new ProduitPerissable(
            $data['nom'],
            $data['description'],
            (float)$data['prix'],
            (int)$data['stock'],
            new \DateTime($data['dateExpiration']),
            (float)$data['temperatureStockage'],
            $data['id'] ?? null
        );
    }

    private static function validerDonnees(array $data, array $champsRequis): void
    {
        foreach ($champsRequis as $champ) {
            if (!isset($data[$champ])) {
                throw new InvalidArgumentException("Le champ requis '$champ' est manquant.");
            }
        }
    }
}

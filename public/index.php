<?php
# phpinfo();

require_once __DIR__ . '/../vendor/autoload.php';

use Davidb\ProjetVenteEnLigne\Entity\Produit;

$produit = new Produit("Chaise", "Une chaise confortable", 99.99, 10, null);
echo "Prix TTC : " . $produit->calculerPrixTTC();
<?php
require __DIR__ . '/../vendor/autoload.php';
require '../models/commandes.php';
include "./navbar.php";
include './verifConnexion.php';


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

if(isset($_SESSION["erreurNouvCommande"])){
    $erreurs = $_SESSION["erreurNouvCommande"];
}else{
    $erreurs = "";
}

$listeCategories = commandes::listeCategories();

echo $twig->render('commande.html.twig', [
    'erreurs' => $erreurs,
    'listeCategories' => $listeCategories
]);
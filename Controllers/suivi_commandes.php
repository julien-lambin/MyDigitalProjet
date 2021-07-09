<?php
require __DIR__ . '/../vendor/autoload.php';
require '../models/commandes.php';
include './verifConnexion.php';
include "./navbar.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

if(isset($_SESSION["idEntreprise"])){
    $listeCommandes = commandes::listeCommandesPro();
    $pro = 1;
}else{
    $listeCommandes = commandes::listeCommandesClient();
    $pro = 0;
}

echo $twig->render('dashboard.html.twig', [
    "listeCommandes" => $listeCommandes,
    "pro" => $pro
]);
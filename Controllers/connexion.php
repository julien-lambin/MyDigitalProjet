<?php
require __DIR__ . '/../vendor/autoload.php';
session_start();
if(isset($_SESSION["prenomNom"])){
    header("location:./accueil.php");
    exit();
}

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

if(isset($_SESSION['erreurMDP'])){
    $_SESSION['erreurMDP'] = "";
}

if(isset($_SESSION['erreurInscription'])){
    $_SESSION['erreurInscription'] = "";
}

if(isset($_SESSION["erreurConnexion"])){
    $erreurs = $_SESSION["erreurConnexion"];
}else{
    $erreurs = "";
}

echo $twig->render('connexion.html.twig', [
    'erreurs' => $erreurs
]);
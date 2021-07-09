<?php
require __DIR__ . '/../vendor/autoload.php';

session_start();
if(isset($_SESSION["prenomNom"])){
    header("location:Controllers/accueil.php");
    exit();
}

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

if(isset($_SESSION['erreurMDP'])){
    $_SESSION['erreurMDP'] = "";
}

if(isset($_SESSION['erreurConnexion'])){
    $_SESSION['erreurConnexion'] = "";
}

if(isset($_SESSION["erreurInscription"])){
    $erreurs = $_SESSION["erreurInscription"];
    $_SESSION["erreurInscription"] = "";
}else{
    $erreurs = "";
}



echo $twig->render('inscription.html.twig', [
    'erreurs' => $erreurs
]);

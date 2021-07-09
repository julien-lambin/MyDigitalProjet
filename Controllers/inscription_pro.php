<?php
require __DIR__ . '/../vendor/autoload.php';
require '../models/commandes.php';
require '../models/inscription_pro.php';

session_start();
if(isset($_SESSION["prenomNom"])){
    header("location:accueil.php");
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

$etape = "";

if(isset($_GET["num"]) && isset($_GET["code"])){
    
    $etape = inscription_pro::checkCode($_GET["num"], $_GET["code"]);
    
    if($etape == 4){
        $resultat = inscription_pro::inscriptionProEtape5($_GET["num"]);

        if($resultat == 5){
            unset($_SESSION['email']);
            header("Location:http://localhost/DoneIT/controllers/connexion_pro.php");
        }
    }
}

if(isset($_SESSION["email"])){
    $etape = inscription_pro::getEtape($_SESSION["email"]);
}

$listeCategories = commandes::listeCategories();

echo $twig->render('inscription_pro.html.twig', [
    'etape' => $etape,
    'listeCategories' => $listeCategories
]);

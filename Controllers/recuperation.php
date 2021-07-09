<?php
require __DIR__ . '/../vendor/autoload.php';
// include './verifConnexion.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

if(isset($_SESSION["erreurMDP"])){
    $erreurs = $_SESSION["erreurMDP"];
}else{
    $erreurs = "";
}

if(isset($_GET['section'])){
    $section = $_GET['section'];
}else{
    $section = "";
}

if(isset($_SESSION['recup_mail'])){
    $mail = $_SESSION['recup_mail'];
}else{
    $mail = "";
}

echo $twig->render('recuperation.html.twig', [
    'section' => $section,
    'erreurs' => $erreurs,
    'mail' => $mail
]);
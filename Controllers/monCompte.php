<?php
require __DIR__ . '/../vendor/autoload.php';
include "./navbar.php";
include './verifConnexion.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

echo $twig->render('monCompte.html.twig', [

]);
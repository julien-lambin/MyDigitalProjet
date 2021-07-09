<?php
require __DIR__ . '/../vendor/autoload.php';
require '../models/commandes.php';
include "./navbar.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

$listeCategories = commandes::listeCategories();

echo $twig->render('accueil.html.twig', [
    'listeCategories' => $listeCategories,
    'session' => $_SESSION
]);
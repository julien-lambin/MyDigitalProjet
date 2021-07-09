<?php
require __DIR__ . '/../vendor/autoload.php';

if(!isset($_SESSION)){
    session_set_cookie_params(60 , "/");
    session_start();
}


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

echo $twig->render('navbar.html.twig', [
    'session' => $_SESSION
]);
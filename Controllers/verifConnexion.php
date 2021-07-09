<?php
session_set_cookie_params(60 , "/");
session_start();
if(!isset($_SESSION['prenomNom'])){
    header('Location: ./accueil.php');
    exit;
}

?>
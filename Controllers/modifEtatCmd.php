<?php
require '../models/commandes.php';
session_start();

$cmdModif = new stdClass();

$cmdModif->numCommande=$_POST["numCommande"];
$cmdModif->etat=$_POST["etatActuel"];
$cmdModif->email=$_SESSION["email"];

commandes::modifEtatCmd($cmdModif);
?>
<?php
include 'bdd.php';

session_start();

global $bdd;

//Vérifie la que tous les champs soit bien rempli
if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"])){
    //Récupération des données et suppréssion des caractères spéciaux
    $email=trim(htmlspecialchars($_POST["email"]));
    $password=trim(htmlspecialchars($_POST["password"]));

    //Récupération des informations de l'utilisateur connecté
    $connexion=$bdd->prepare("SELECT num_entreprise, nom_entreprise, password, email from professionnels WHERE email=? limit 1");
    $connexion->execute(array($email));
    $connexionBDD=$connexion->fetchObject();
    //Vérication du mot de passe

    if(password_verify($password, $connexionBDD->password)){
        $_SESSION["prenomNom"]=ucfirst(strtolower($connexionBDD->nom_entreprise));
        $_SESSION["autoriser"]="oui";
        $_SESSION["email"]=$connexionBDD->email;
        $_SESSION["idEntreprise"]=$connexionBDD->num_entreprise;

        $_SESSION["erreurConnexion"] = "";
        header("location:../controllers/accueil.php");
        die;
    }else{//Alerte
        $_SESSION["erreurConnexion"] = "Adresse mail ou mot de passe incorrect, veuillez réessayer.";
        header('Location:http://localhost/DoneIT/controllers/connexion_pro.php');
    }
}else{//Alerte si tous les champs ne sont pas remplie
    $_SESSION["erreurConnexion"] = "Veuillez renseigner tous les champs.";
    header('Location:http://localhost/DoneIT/controllers/connexion_pro.php');
}  
?>
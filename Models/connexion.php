<?php
include 'bdd.php';

session_start();

global $bdd;

$statut = "0";

//Vérifie la que tous les champs soit bien rempli
if(isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["password"])){
    //Récupération des données et suppréssion des caractères spéciaux
    $email=trim(htmlspecialchars($_POST["email"]));
    $password=trim(htmlspecialchars($_POST["password"]));

    //Récupération des informations de l'utilisateur connecté
    $connexion=$bdd->prepare("SELECT Num_Client, prenom, nom, email, password FROM users WHERE email=? limit 1");
    $connexion->execute(array($email));
    if($tab = $connexion->fetchObject()){

    //Vérication du mot de passe
    if(password_verify($password, $tab->password)){
        $_SESSION["prenomNom"]=ucfirst(strtolower($tab->prenom))." ".strtoupper($tab->nom);
        $_SESSION["autoriser"]="oui";
        $_SESSION["email"]=$tab->email;
        $_SESSION["idUser"]=$tab->Num_Client;

        $statut = "1";

    }
    }else{//Alerte

        $connexion=$bdd->prepare("SELECT num_entreprise, prenom, nom, email, password from professionnels WHERE email=? limit 1");
        $connexion->execute(array($email));
        if($tab = $connexion->fetchObject()){

        if(password_verify($password, $tab->password)){
            $_SESSION["prenomNom"]=ucfirst(strtolower($tab->prenom))." ".strtoupper($tab->nom);
            $_SESSION["autoriser"]="oui";
            $_SESSION["email"]=$tab->email;
            $_SESSION["idEntreprise"]=$tab->num_entreprise;
            $statut = "1";

        }else{
            $_SESSION["erreurConnexion"] = "Adresse mail ou mot de passe incorrect, veuillez réessayer.";
            header("location:../controllers/accueil.php");
        }
    }
}
}else{//Alerte si tous les champs ne sont pas remplie
    $_SESSION["erreurConnexion"] = "Veuillez renseigner tous les champs.";
}  
echo $statut;
?>
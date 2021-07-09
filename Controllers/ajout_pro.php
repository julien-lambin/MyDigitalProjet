<?php
require '../models/inscription_pro.php';
require __DIR__ . '/../vendor/autoload.php';

session_start();
if(isset($_SESSION["prenomNom"])){
    header("location:Controllers/accueil.php");
    exit();
}

//Traitement étape 1
if(
    isset($_POST['nom']) && !empty($_POST['nom']) &&
    isset($_POST['prenom']) && !empty($_POST['prenom']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['newsletter']) && !empty($_POST['newsletter'])
){
    $newPro = new stdClass();

    //Récupération des données et suppréssion des caractères spéciaux
    $newPro->nom = trim(htmlspecialchars($_POST['nom']));
    $newPro->prenom = trim(htmlspecialchars($_POST['prenom']));
    $newPro->email = trim(htmlspecialchars($_REQUEST['email']));
    if($_POST['newsletter'] == "on"){
        $newPro->newsletter = 1;
    }else{
        $newPro->newsletter = 0;
    }
    $erreur = "";

    //Vérification de l'adresse mail
    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $newPro->email)){
        $_SESSION['erreurInscription'] = "Le format de l'addresse mail n'est pas correct !";
        header("Location:http://localhost/DoneIT/controllers/inscription.php");
        die;
    }

if(isset($_FILES['photo_profil'])){

    if($_FILES['photo_profil']['error'] > 0){
        $_SESSION["erreurInscription"] = 'Erreur';
        header('Location: ../controllers/inscription_pro.php');
        die;
    }
    
    //Récupération de la taille de l'image
    $fileSize = $_FILES['photo_profil']['size'];

    //Vérification de la taille maximale
    if($fileSize > $maxSize){
        $_SESSION["erreurInscription"] = 'Fichier trop volumineux !';
        header('Location: ../controllers/inscription_pro.php');
        die;
    }

    //Récupération de le l'extention de l'image
    $fileExt = ".".strtolower(substr(strrchr($_FILES['photo_profil']['name'],'.'),1));

    //Vérifie que l'extention est valide
    if(!in_array($fileExt, $validExt)){
        $_SESSION["erreurInscription"] = "Cette extention n'est pas prise en charge.";
        header('Location: ../controllers/inscription_pro.php');
        die;
    }
}else{//Initialisation du nom de 
    $newPro->idPhoto = "pp_pro_default";
}

$etape = inscription_pro::inscriptionProEtape1($newPro);

if($etape == ""){
    header('Location: ../controllers/inscription_pro.php');
}

}



//Traitement étape 2
if(
    isset($_REQUEST['password']) && !empty($_REQUEST['password']) &&
    isset($_REQUEST['password-confirm']) && !empty($_REQUEST['password-confirm']) &&
    isset($_SESSION['email']) && !empty($_SESSION['email'])
){
    $newPro = new stdClass();

    //Récupération des données et suppréssion des caractères spéciaux
    $newPro->password = $_REQUEST['password'];
    $newPro->passwordConfirm = $_REQUEST['password-confirm'];
    $newPro->email = $_SESSION['email'];
    $erreur = "";

    //Vérification du mot de passe
    // if(!preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,55})$#',$newPro->password)){
    //     $_SESSION['erreurInscription'] = "Le mot de passe doit contenir au moins 8 caractères, 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spéciaux";
    //     header("Location:http://localhost/DoneIT/controllers/inscription.php");
    //     error_log("test1");
    //     die;
    // }

    //Vérifie que les mots de passe corresponde bien
    if($newPro->password == $newPro->passwordConfirm){
        $etape = inscription_pro::inscriptionProEtape2($newPro);
    }

    if($etape == ""){
        header('Location: ../controllers/inscription_pro.php');
    }
}



//Traitement étape 3
if(
    isset($_REQUEST['phone']) && !empty($_REQUEST['phone']) &&
    isset($_REQUEST['adresse']) && !empty($_REQUEST['adresse']) &&
    isset($_REQUEST['ville']) && !empty($_REQUEST['ville']) &&
    isset($_REQUEST['code_postal']) && !empty($_REQUEST['code_postal']) &&
    isset($_SESSION['email']) && !empty($_SESSION['email'])
){
    $newPro = new stdClass();
   
    //Récupération des données et suppréssion des caractères spéciaux
    $newPro->telephone = preg_replace('/[^0-9]/', '',trim(htmlspecialchars($_REQUEST['phone'])));
    $newPro->adresse = htmlspecialchars($_REQUEST['adresse']);
    $newPro->ville = htmlspecialchars($_REQUEST['ville']);
    $newPro->code_postal = htmlspecialchars($_REQUEST['code_postal']);
    $newPro->email = $_SESSION['email'];
    $erreur = "";

    $etape = inscription_pro::inscriptionProEtape3($newPro);
    
    if($etape == ""){
        header('Location: ../controllers/inscription_pro.php');
    }
}


//Traitement étape 4
if(
    isset($_REQUEST['categorie']) && !empty($_REQUEST['categorie']) &&
    isset($_REQUEST['nom_entreprise']) && !empty($_REQUEST['nom_entreprise']) &&
    isset($_REQUEST['siret']) && !empty($_REQUEST['siret']) &&
    isset($_FILES['contrat_pro']) && 
    isset($_FILES['diplome']) &&
    isset($_SESSION['email']) && !empty($_SESSION['email'])
){
    $newPro = new stdClass();

    //Récupération des données et suppréssion des caractères spéciaux

    $newPro->categorie = implode(" ",$_REQUEST['categorie']);
    $newPro->nom_entreprise = htmlspecialchars($_REQUEST['nom_entreprise']);
    $newPro->siret = htmlspecialchars($_REQUEST['siret']);
    $newPro->contrat_pro = $_FILES['contrat_pro']['name'];
    $newPro->diplome = $_FILES['diplome']['name'];
    $newPro->email = $_SESSION['email'];
    $erreur = "";

    $etape = inscription_pro::inscriptionProEtape4($newPro);
    
    if($etape == ""){
       header('Location: ../controllers/connexion_pro.php');
    }
}
?>
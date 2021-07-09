<?php
require '../models/commandes.php';
require __DIR__ . '/../vendor/autoload.php';
session_start();

if(
    isset($_FILES['uploadImage']) &&
    isset($_POST['numCommande']) && !empty($_POST['numCommande'])
){

        //Compte le nombre d'images
    if($_FILES['uploadImage']["name"][0] != ""){
        $countfiles = count($_FILES['uploadImage']['name']);
    }else{
        $countfiles = 0;
    }

    //Définition de la taille max des images
    $maxSize = 5000000;
    //Définition des extentions valide
    $validExt = array('.png', '.gif', '.jpg', '.jpeg');

    $nbPhoto = commandes::countPhotoCommande($_POST['numCommande']);
    
    $nbPhoto = 3 - $nbPhoto;
    
    //Envoi d'une alerte si il y a plus de 3 images
    if($countfiles > $nbPhoto){
        $_SESSION["erreurNouvCommande"] = 'Vous ne pouvez envoyer que 3 images !';
        header('Location: ../controllers/commande.php');
        die;
    }
    
    foreach($_FILES['uploadImage']['name'] as $key => $nomImage){
        
        if($_FILES['uploadImage']['error'][$key] > 0){
            $_SESSION["erreurNouvCommande"] = 'Erreur';
            if($_FILES['uploadImage']['error'][$key] == 1){
                $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
            }
            header('Location: ../controllers/commande.php');
            die;
        }

        //Récupére la taille de l'image
        $fileSize = $_FILES['uploadImage']['size'][$key];

        //Vérifie la taille maximal des images
        if($fileSize > $maxSize){
            $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
            header('Location: ../controllers/commande.php');
            die;
        }

        //Récupére l'extention
        $fileExt = ".".strtolower(substr(strrchr($_FILES['uploadImage']['name'][$key],'.'),1));

        //Vérifie que l'extention est valide
        if(!in_array($fileExt, $validExt)){//Erreur si l'extention n'est pas valide
            $_SESSION["erreurNouvCommande"] = "Cette extention n'est pas prise en charge.";
            header('Location: ../controllers/commande.php');
            die;
        }
        
        $newImage = new stdClass();

        $newImage->image = $_FILES['uploadImage']['name'][$key];
        $newImage->numCommande = $_POST['numCommande'];
        $newImage->fileName = md5(uniqid(rand(), true));
        $newImage->tempName = $_FILES['uploadImage']['tmp_name'][$key];
        $newImage->fileExt = $fileExt;

        commandes::addPhoto($newImage);
    }
    
}


if(
    isset($_FILES['uploadDevis']) &&
    isset($_POST['numCommande']) && !empty($_POST['numCommande'])
){

    //Définition de la taille max des images
    $maxSize = 5000000;
    //Définition des extentions valide
    $validExt = array('.pdf', '.docx');
    
    foreach($_FILES['uploadDevis']['name'] as $key => $nomImage){
        
        if($_FILES['uploadDevis']['error'][$key] > 0){
            $_SESSION["erreurNouvCommande"] = 'Erreur';
            if($_FILES['uploadDevis']['error'][$key] == 1){
                $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
            }
            header('Location: ../controllers/commande.php');
            die;
        }
        
        //Récupére la taille de l'image
        $fileSize = $_FILES['uploadDevis']['size'][$key];
        
        //Vérifie la taille maximal des images
        if($fileSize > $maxSize){
            $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
            header('Location: ../controllers/commande.php');
            die;
        }
        
        //Récupére l'extention
        $fileExt = ".".strtolower(substr(strrchr($_FILES['uploadDevis']['name'][$key],'.'),1));

        //Vérifie que l'extention est valide
        if(!in_array($fileExt, $validExt)){//Erreur si l'extention n'est pas valide
            $_SESSION["erreurNouvCommande"] = "Cette extention n'est pas prise en charge.";
            header('Location: ../controllers/commande.php');
            die;
        }
        
        $newDevis = new stdClass();

        $newDevis->image = $_FILES['uploadDevis']['name'][$key];
        $newDevis->numCommande = $_POST['numCommande'];
        $newDevis->fileName = md5(uniqid(rand(), true));
        $newDevis->tempName = $_FILES['uploadDevis']['tmp_name'][$key];
        $newDevis->fileExt = $fileExt;

        commandes::addDevis($newDevis);
    }
    
}


if(
    isset($_FILES['uploadFacture']) &&
    isset($_POST['numCommande']) && !empty($_POST['numCommande'])
){

    //Définition de la taille max des images
    $maxSize = 5000000;
    //Définition des extentions valide
    $validExt = array('.pdf', '.docx');
    
    foreach($_FILES['uploadFacture']['name'] as $key => $nomImage){
        
        if($_FILES['uploadFacture']['error'][$key] > 0){
            $_SESSION["erreurNouvCommande"] = 'Erreur';
            if($_FILES['uploadFacture']['error'][$key] == 1){
                $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
            }
            header('Location: ../controllers/commande.php');
            die;
        }
        
        //Récupére la taille de l'image
        $fileSize = $_FILES['uploadFacture']['size'][$key];
        
        //Vérifie la taille maximal des images
        if($fileSize > $maxSize){
            $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
            header('Location: ../controllers/commande.php');
            die;
        }
        
        //Récupére l'extention
        $fileExt = ".".strtolower(substr(strrchr($_FILES['uploadFacture']['name'][$key],'.'),1));

        //Vérifie que l'extention est valide
        if(!in_array($fileExt, $validExt)){//Erreur si l'extention n'est pas valide
            $_SESSION["erreurNouvCommande"] = "Cette extention n'est pas prise en charge.";
            header('Location: ../controllers/commande.php');
            die;
        }
        
        $newFacture = new stdClass();

        $newFacture->image = $_FILES['uploadFacture']['name'][$key];
        $newFacture->numCommande = $_POST['numCommande'];
        $newFacture->fileName = md5(uniqid(rand(), true));
        $newFacture->tempName = $_FILES['uploadFacture']['tmp_name'][$key];
        $newFacture->fileExt = $fileExt;

        commandes::addFacture($newFacture);
    }
    
}

?>
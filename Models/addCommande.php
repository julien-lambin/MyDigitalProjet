<?php
include 'bdd.php';

//Ouverture de la session
session_start();

//Récupération des données et suppréssion des caractères spéciaux
$dateRetrait = htmlspecialchars($_REQUEST['dateRetrait']);
$panne = htmlspecialchars($_REQUEST['naturePanne']);
$adresse = htmlspecialchars($_REQUEST['adresse']);
$categorie = htmlspecialchars($_REQUEST['categorie']);
$marque = htmlspecialchars($_REQUEST['marque']);
$ref = htmlspecialchars($_REQUEST['reference']);
$description = htmlspecialchars($_REQUEST['precisions']);

// //Compte le nombre d'images
// if($_FILES['images']["name"][0] != ""){
//     $countfiles = count($_FILES['images']['name']);
// }else{
//     $countfiles = 0;
// }


// //Définition de la taille max des images
// $maxSize = 500000;
// //Définition des extentions valide
// $validExt = array('.png', '.gif', '.jpg', '.jpeg');

// //Envoi d'une alerte si il y a plus de 3 images
// if($countfiles > 3){
//     $_SESSION["erreurNouvCommande"] = 'Vous ne pouvez envoyer que 3 images !';
//     header('Location: ../controllers/commande.php');
//     die;
// }


// //Boucle sur toutes les images
// if($countfiles > 0){
//     for($i=0;$i<$countfiles;$i++){

//         if($_FILES['images']['error'][$i] > 0){
//             $_SESSION["erreurNouvCommande"] = 'Erreur';
//             if($_FILES['images']['error'][$i] == 1){
//                 $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
//             }
//             header('Location: ../controllers/commande.php');
//             die;
//         }

//         //Récupére la taille de l'image
//         $fileSize = $_FILES['images']['size'][$i];

//         //Vérifie la taille maximal des images
//         if($fileSize > $maxSize){
//             $_SESSION["erreurNouvCommande"] = 'Fichier trop volumineux !';
//             header('Location: ../controllers/commande.php');
//             die;
//         }

//         //Récupére l'extention
//         $fileExt = ".".strtolower(substr(strrchr($_FILES['images']['name'][$i],'.'),1));

//         //Vérifie que l'extention est valide
//         if(!in_array($fileExt, $validExt)){//Erreur si l'extention n'est pas valide
//             $_SESSION["erreurNouvCommande"] = "Cette extention n'est pas prise en charge.";
//             header('Location: ../controllers/commande.php');
//             die;
//         }
//     }
// }

//Ouverture de la connexion avec la base de données
global $bdd;

//Récupération de la date du jour
$date = new DateTime();

//Ajout d'une commande
$addCommande = $bdd->prepare("INSERT INTO commandes (email_client,adresse,categorie,panne,marque,reference,description,date_retrait,date_creation) values(?,?,?,?,?,?,?,?,?)");
if($addCommande->execute(array($_SESSION["email"],$adresse,$categorie,$panne,$marque,$ref,$description,$dateRetrait,$date->format("d/m/Y")))){
    $_SESSION["erreurNouvCommande"] = "Commande créée avec succés !";
}else{
    $_SESSION["erreurNouvCommande"] = "Erreur lors de la création de la commande !";
    die;
}

//Récupération du dernier id des commandes
// $maxCommandeId=$bdd->query("SELECT MAX(num_commande) AS MAXID FROM commandes");
// if($tab=$maxCommandeId->fetch()){
//     $idCommande = $tab["MAXID"];
// }else{
//     $idCommande = 0;
// }

// //Boucle sur toutes les images
// if($countfiles > 0){
//     for($i=0;$i<$countfiles;$i++){

//         $image = $_FILES['images']['name'][$i];
//         $fileName = md5(uniqid(rand(), true));

//         //Ajoute les informations de l'image en BDD
//         $addFichier = $bdd->prepare("INSERT INTO commande_images (code,id_commande,nom,type) values(?,?,?,?)");
//         if($addFichier->execute(array($fileName,$idCommande,$image))){
//             //Ajoute l'image dans le dossier
//             if(move_uploaded_file($_FILES['images']['tmp_name'][$i], '../commande_images/'.$fileName.$fileExt)){
//                 $_SESSION["erreurNouvCommande"] = "Commande créée avec succés !";
//             }else{
//                 $_SESSION["erreurNouvCommande"] = "Erreur lors du transfert !";
//             }
//         }
//     }
// }
// header('Location: ../controllers/commande.php');

?>
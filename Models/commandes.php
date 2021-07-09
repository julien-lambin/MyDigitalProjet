<?php
include 'bdd.php';

class commandes {

    //Récupére la liste des catégories
    static function listeCategories(){
        global $bdd;
        $resultat=array();

        $listeCategories=$bdd->prepare("SELECT nom FROM categorie");
        if($listeCategories->execute(array())){
            while ($categoriesBDD = $listeCategories->fetchObject()) {

                $categories = new stdClass();

                $categories->nom = $categoriesBDD->nom;

                $resultat[]=$categories;
            }
        }
        return $resultat;
    }

    //Récupération des commandes pour un utilisateur
    static function listeCommandesClient(){
        global $bdd;
        $resultat=array();

        $listeCommandes=$bdd->prepare("SELECT num_commande, email_reparateur, categorie, marque, reference, description, etat, date_retrait, date_creation
            FROM commandes
            WHERE email_client=?
            ORDER BY date_creation");
        if($listeCommandes->execute(array($_SESSION["email"]))){
            while ($commandesBDD = $listeCommandes->fetchObject()) {
                
                $commandes = new stdClass();

                $commandes->idCommande = $commandesBDD->num_commande;
                $commandes->emailReparateur = $commandesBDD->email_reparateur;
                $commandes->categorie = $commandesBDD->categorie;
                $commandes->marque = $commandesBDD->marque;
                $commandes->reference = $commandesBDD->reference;
                $commandes->description = $commandesBDD->description;
                $dateRetrait = explode("-", $commandesBDD->date_retrait);
                $commandes->dateRetrait = $dateRetrait[2]."/".$dateRetrait[1]."/".$dateRetrait[0];
                $commandes->etat = $commandesBDD->etat;
               
                $commandes->codeImages = "";
                $commandes->nomImages = "";

                $listeImages=$bdd->prepare("SELECT code, nom FROM commande_images WHERE id_commande=? AND type = 0");
                if($listeImages->execute(array($commandes->idCommande))){
                    while ($imagesBDD = $listeImages->fetchObject()) {
                        $commandes->codeImages .= ";".$imagesBDD->code;
                        $commandes->nomImages .= ";".$imagesBDD->nom;
                    }
                
                    $codeImages = explode(";", $commandes->codeImages);
                    unset($codeImages[0]);

                    $nomImages = explode(";", $commandes->nomImages);
                    unset($nomImages[0]);

                    
                    $cptCode = 1;
                    $cptNom = 1;
                    foreach ($codeImages as $key => $codeImage) {
                        $commandes->codeImage[$cptCode] = $codeImage;
                        $cptCode++;
                    }

                    foreach ($nomImages as $key => $nomImage) {
                        $commandes->nomImage[$cptNom] = $nomImage;
                        $cptNom++;
                    }
                }
                $resultat[]=$commandes;
            }
        }
        return $resultat;
    }

        //Récupération des commandes pour un utilisateur
        static function listeCommandesPro(){
            global $bdd;
            $resultat=array();
    
            $listeCommandes=$bdd->prepare("SELECT commandes.num_commande, commandes.email_reparateur, commandes.categorie, commandes.marque, commandes.reference, commandes.description, commandes.etat, commandes.date_retrait, commandes.date_creation, users.adresse
                FROM commandes commandes
                LEFT JOIN users users ON users.email=commandes.email_client
                ORDER BY commandes.date_creation");
            if($listeCommandes->execute()){
                while ($commandesBDD = $listeCommandes->fetchObject()) {
                    
                    $commandes = new stdClass();
    
                    $commandes->idCommande = $commandesBDD->num_commande;
                    $commandes->emailReparateur = $commandesBDD->email_reparateur;
                    $commandes->categorie = $commandesBDD->categorie;
                    $commandes->marque = $commandesBDD->marque;
                    $commandes->reference = $commandesBDD->reference;
                    $commandes->description = $commandesBDD->description;
                    $commandes->etat = $commandesBDD->etat;
                    $commandes->adresse = $commandesBDD->adresse;
                    $dateRetrait = explode("-", $commandesBDD->date_retrait);
                    $commandes->dateRetrait = $dateRetrait[2]."/".$dateRetrait[1]."/".$dateRetrait[0];
                   
                    $commandes->codeImages = "";
                    $commandes->nomImages = "";
    
                    $listeImages=$bdd->prepare("SELECT code, nom FROM commande_images WHERE id_commande=? AND type = 0");
                    if($listeImages->execute(array($commandes->idCommande))){
                        while ($imagesBDD = $listeImages->fetchObject()) {
                            $commandes->codeImages .= ";".$imagesBDD->code;
                            $commandes->nomImages .= ";".$imagesBDD->nom;
                        }
                    
                        $codeImages = explode(";", $commandes->codeImages);
                        unset($codeImages[0]);
    
                        $nomImages = explode(";", $commandes->nomImages);
                        unset($nomImages[0]);
    
                        
                        $cptCode = 1;
                        $cptNom = 1;
                        foreach ($codeImages as $key => $codeImage) {
                            $commandes->codeImage[$cptCode] = $codeImage;
                            $cptCode++;
                        }
    
                        foreach ($nomImages as $key => $nomImage) {
                            $commandes->nomImage[$cptNom] = $nomImage;
                            $cptNom++;
                        }
                    }
                    $resultat[]=$commandes;
                }
            }
            return $resultat;
        }

    static function modifEtatCmd($cmdModif) {
        global $bdd;

        if($cmdModif->etat == 0){

            $nouvEtat = $cmdModif->etat + 1;

            $requete = $bdd->prepare("UPDATE commandes SET email_reparateur = ?, etat = ? WHERE num_Commande = ?");
            if($requete->execute(array($cmdModif->email,$nouvEtat, $cmdModif->numCommande))){
                error_log("L\'état de la commande : ".$cmdModif->numCommande." a été modifié de ".$cmdModif->etat." à ".$nouvEtat);
            }
        }else{
            
            $nouvEtat = $cmdModif->etat + 1;

            $requete = $bdd->prepare("UPDATE commandes SET etat = ? WHERE num_Commande = ?");
            if($requete->execute(array($nouvEtat, $cmdModif->numCommande))){
                error_log("L\'état de la commande : ".$cmdModif->numCommande." a été modifié de ".$cmdModif->etat." à ".$nouvEtat);
            }
        }

    }


    static function countPhotoCommande($numCommande) {
        global $bdd;

        $requete = $bdd->prepare("SELECT COUNT(id) AS COUNTPHOTO FROM commande_images WHERE id_Commande = ?");
        if($requete->execute(array($numCommande))){
            $imagesBDD = $requete->fetchObject();
            $resultat = $imagesBDD->COUNTPHOTO;
        }
        return $resultat;
    }


    static function addPhoto($newImage) {
        global $bdd;

        //Ajoute les informations de l'image en BDD
        $addFichier = $bdd->prepare("INSERT INTO commande_images (code,id_commande,nom,type) values(?,?,?,0)");
        if($addFichier->execute(array($newImage->fileName,$newImage->numCommande,$newImage->image))){
            //Ajoute l'image dans le dossier
            if(move_uploaded_file($newImage->tempName, '../commande_images/'.$newImage->fileName.$newImage->fileExt)){

            }else{
              
            }
        }
    }


    static function addDevis($newDevis) {
        global $bdd;

        $supprFichier = $bdd->prepare("DELETE FROM commande_images WHERE id_commande = ? AND type = 1");
        if($supprFichier->execute(array($newDevis->numCommande))){

            //Ajoute les informations de l'image en BDD
            $addFichier = $bdd->prepare("INSERT INTO commande_images (code,id_commande,nom,type) values(?,?,?,1)");
            if($addFichier->execute(array($newDevis->fileName,$newDevis->numCommande,$newDevis->image))){
                //Ajoute l'image dans le dossier
                if(move_uploaded_file($newDevis->tempName, '../commande_images/'.$newDevis->fileName.$newDevis->fileExt)){

                }else{
                
                }
            }
        }
    }


    static function addFacture($newFacture) {
        global $bdd;

        $supprFichier = $bdd->prepare("DELETE FROM commande_images WHERE id_commande = ? AND type = 2");
        if($supprFichier->execute(array($newFacture->numCommande))){

            //Ajoute les informations de l'image en BDD
            $addFichier = $bdd->prepare("INSERT INTO commande_images (code,id_commande,nom,type) values(?,?,?,2)");
            if($addFichier->execute(array($newFacture->fileName,$newFacture->numCommande,$newFacture->image))){
                //Ajoute l'image dans le dossier
                if(move_uploaded_file($newFacture->tempName, '../commande_images/'.$newFacture->fileName.$newFacture->fileExt)){

                }else{
                
                }
            }
        }
    }

}
?>
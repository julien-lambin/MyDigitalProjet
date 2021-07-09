<?php
include 'bdd.php';

class inscription_pro {

    
    static function getEtape($email){
        global $bdd;
        $etape="";

        $requeteProExistant = $bdd->prepare("SELECT email, etape FROM professionnels WHERE email = ? limit 1");
        if($requeteProExistant->execute(array($email))){
            if($proExistantBDD = $requeteProExistant->fetchObject()){
                $etape = $proExistantBDD->etape;
                
            }
        }
        return $etape;
    }


    //Récupére la liste des catégories
    static function inscriptionProEtape1($newPro){
        global $bdd;
        $etape="";

        $requeteProExistant = $bdd->prepare("SELECT email, etape FROM professionnels WHERE email = ? limit 1");
        if($requeteProExistant->execute(array($newPro->email))){
            if($proExistantBDD = $requeteProExistant->fetchObject()){
                $date = new DateTime();
                if($proExistantBDD->etape < 5){

                    $updatePro = $bdd->prepare("UPDATE professionnels SET nom = ?, prenom = ?, newsletter = ?, etape = 1, date_debut_creation = ? WHERE email = ?");
                    if($updatePro->execute(array($newPro->nom,$newPro->prenom,$newPro->newsletter,$date->format("d/m/Y"), $newPro->email))){
                        $etape = "mdp";
                        $_SESSION["email"] = $newPro->email;
                        if(isset($_FILES['photo_profil'])){
                            
                            //Récupération de l'id de l'utilisateur créée
                            $maxUserId=$bdd->query("SELECT num_entreprise AS MAXID FROM professionnels WHERE email = ".$newPro->email."");
                            if($maxUserIdBDD=$maxUserId->fetchObject()){
                                $idPhoto = "pp_pro".$maxUserIdBDD->MAXID;
                            }else{
                                $idPhoto = "pp_pro0";
                            }
    
                            //Ajout de l'identifiant de la photo de profil
                            $updatePP = $bdd->prepare("UPDATE professionnels SET photo_profil = ? WHERE email = ?");
                            if($updatePP->execute(array($newPro->idPhoto, $newPro->email))){
                                if(move_uploaded_file($_FILES['photo_profil']['tmp_name'], '../photo_profil/'.$idPhoto.$fileExt)){
                                    $etape = "mdp";
                                }else{
                                    $_SESSION["erreurInscription"] = "Erreur lors du transfert !";
                                }
                            }
    
                        }
                    }
                }else{
                    $etape = $proExistantBDD->etape;
                }


            }else{
                $_SESSION["email"] = $newPro->email;
                $date = new DateTime();
                
                $addUser = $bdd->prepare("INSERT INTO professionnels (nom,prenom,email,newsletter,date_debut_creation,etape) values(?,?,?,?,?,1)");
                if($addUser->execute(array($newPro->nom,$newPro->prenom,$newPro->email,$newPro->newsletter,$date->format("d/m/Y")))){
                    $etape = "1";
                    $_SESSION["email"] = $newPro->email;
                    if(isset($_FILES['photo_profil'])){
                            
                        //Récupération de l'id de l'utilisateur créée
                        $maxUserId=$bdd->query("SELECT num_entreprise AS MAXID FROM professionnels WHERE email = ".$newPro->email."");
                        if($maxUserIdBDD=$maxUserId->fetchObject()){
                            $idPhoto = "pp_pro".$maxUserIdBDD->MAXID;
                        }else{
                            $idPhoto = "pp_pro0";
                        }

                        //Ajout de l'identifiant de la photo de profil
                        $updatePP = $bdd->prepare("UPDATE professionnels SET photo_profil = ? WHERE email = ?");
                        if($updatePP->execute(array($newPro->idPhoto, $newPro->email))){
                            if(move_uploaded_file($_FILES['photo_profil']['tmp_name'], '../photo_profil/'.$idPhoto.$fileExt)){
                                $etape = "1";
                            }else{
                                $_SESSION["erreurInscription"] = "Erreur lors du transfert !";
                            }
                        }

                    }
                }
            }
        }
        return $etape;
    }


    static function inscriptionProEtape2($newPro){
        global $bdd;
        $etape="";

        $updateProPassword = $bdd->prepare("UPDATE professionnels SET password = ?, etape = 2 WHERE email = ?");
        if($updateProPassword->execute(array(password_hash($newPro->password, PASSWORD_BCRYPT), $newPro->email))){
            $etape="2";
        }
        return $etape;
    }


    static function inscriptionProEtape3($newPro){
        global $bdd;
        $etape="";

        $updateProAdresse = $bdd->prepare("UPDATE professionnels SET tel = ?, adresse = ?, ville = ?, code_postal = ?, etape = 3 WHERE email = ?");
        if($updateProAdresse->execute(array($newPro->telephone, $newPro->adresse, $newPro->ville, $newPro->code_postal, $newPro->email))){
            $etape="3";
        }
        return $etape;
    }


    static function inscriptionProEtape4($newPro){
        global $bdd;
        $etape="";

        $code_provi = "";

        for($i=0; $i < 8; $i++) {
            $code_provi .= mt_rand(0,9);
        }

        $updateProAdresse = $bdd->prepare("UPDATE professionnels SET categorie_materiel = ?, nom_entreprise = ?, siret = ?, contrat_pro = ?, diplome = ?, code_provi = ?, etape = 4 WHERE email = ?");
        if($updateProAdresse->execute(array($newPro->categorie, $newPro->nom_entreprise, $newPro->siret, $newPro->contrat_pro, $newPro->diplome,$code_provi, $newPro->email))){
            
            $infosPro = $bdd->prepare("SELECT num_entreprise, nom, prenom FROM professionnels WHERE email = ? ");
            if($infosPro->execute(array($newPro->email))){
                $infosProBDD = $infosPro->fetchObject();

                $header="MIME-Version: 1.0\r\n";
                $header.='From: DoneIT <no-reply@DoneIT.fr>'."\n";
                $header.='Content-Type:text/html; charset="utf-8"'."\n";
                $header.='Content-Transfer-Encoding: 8bit';
                $message = '
                <html>
                <head>
                 <title>Récupération de mot de passe - DoneIT</title>
                 <meta charset="utf-8" />
                </head>
                <body>
                 <font color="#303030";>
                 <div align="center">
                    <table width="600px">
                     <tr>
                         <td>
                            
                            <div align="center">Bonjour <b>'.$infosProBDD->nom.' '.$infosProBDD->prenom.'</b>,</div>
                            <div align="center">Cliqué ici pour valider votre compte: <b> http://localhost/doneit/controllers/inscription_pro.php?num='.$infosProBDD->num_entreprise.'&amp;code='.$code_provi.'</b></div>
                         </td>
                     </tr>
                     <tr>
                         <td align="center">
                            <font size="2">
                             Ceci est un email automatique, merci de ne pas y répondre
                            </font>
                         </td>
                     </tr>
                    </table>
                 </div>
                 </font>
                </body>
                </html>
                ';
                if(mail($newPro->email, "Validation compte professionnel - DoneIT", $message, $header)){
                    $etape="4";
                    die;
                }else{
                    error_log($newPro->email);
                    $error = "Erreur lors de l'envoi de l'email";
                }
            }
        }
        return $etape;
    }

    static function checkCode($num, $code){
        global $bdd;
        $etape="";
    
        $infosPro = $bdd->prepare("SELECT code_provi FROM professionnels WHERE num_entreprise = ?");
        if($infosPro->execute(array($num))){
            $infosProBDD = $infosPro->fetchObject();

            if($infosProBDD->code_provi == $code){
                $etape="4";
            }
            
        }
        return $etape;
    }


    static function inscriptionProEtape5($num){
        global $bdd;
        $etape="";

        $date = new DateTime();
        $date = $date->format("d/m/Y");

        $updateProEtat = $bdd->prepare("UPDATE professionnels SET etape = 5, code_provi = 0, date_creation = $date WHERE num_entreprise = ?");
        if($updateProEtat->execute(array($num))){
            $etape="5";
        }
        return $etape;
    }


}
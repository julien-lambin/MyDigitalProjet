<?php
include 'bdd.php';

session_start();

$statut = "0";

// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(empty($_POST['recaptcha-response'])){
        $_SESSION['erreurInscription'] = "Vous êtes un robot !";
        header("Location:http://localhost/DoneIT/controllers/inscription.php");
        die;
    }else{
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LdsjloaAAAAADXfXRkrzlLuIyDipTqzbCkWOIqR&response={$_POST['recaptcha-response']}";

        // On vérifie si curl est installé
        if(function_exists('curl_version')){
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
        }else{
            // On utilisera file_get_contents
            $response = file_get_contents($url);
        }
            // On vérifie qu'on a une réponse
        if(empty($response) || is_null($response)){
            header("Location:http://localhost/DoneIT/controllers/inscription.php");
        }else{
            $data = json_decode($response);
            if($data->success){
                
                //Vérifie la que tous les champs soit bien rempli
                if(
                    isset($_REQUEST['nom']) && !empty($_REQUEST['nom']) &&
                    isset($_REQUEST['prenom']) && !empty($_REQUEST['prenom']) &&
                    isset($_REQUEST['email']) && !empty($_REQUEST['email']) &&
                    isset($_REQUEST['tel']) && !empty($_REQUEST['tel']) &&
                    isset($_REQUEST['adresse']) && !empty($_REQUEST['adresse']) &&
                    isset($_REQUEST['ville']) && !empty($_REQUEST['ville']) &&
                    isset($_REQUEST['codePostal']) && !empty($_REQUEST['codePostal']) &&
                    isset($_REQUEST['password']) && !empty($_REQUEST['password']) &&
                    isset($_REQUEST['passwordConfirm']) && !empty($_REQUEST['passwordConfirm'])
                ){
                    //Récupération des données et suppréssion des caractères spéciaux
                    $nom = trim(htmlspecialchars($_REQUEST['nom']));
                    $prenom = trim(htmlspecialchars($_REQUEST['prenom']));
                    $email = trim(htmlspecialchars($_REQUEST['email']));
                    $tel = preg_replace('/[^0-9]/', '',trim(htmlspecialchars($_REQUEST['tel'])));
                    $adresse = htmlspecialchars($_REQUEST['adresse']);
                    $ville = htmlspecialchars($_REQUEST['ville']);
                    $codePostal = htmlspecialchars($_REQUEST['codePostal']);
                    $password = $_REQUEST['password'];
                    $passwordConfirm = $_REQUEST['passwordConfirm'];
                    $erreur = "";
                    
                    //Vérification de l'adresse mail
                    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)){

                        echo "erreurMail";
                        die;
                    }

                    //Vérification du mot de passe
                    if(!preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,55})$#',$password)){
                        
                        echo "erreurPassword";
                        die;
                    }
                    
                    global $bdd;

                    //Vérifie que les mots de passe corresponde bien
                    if($password==$passwordConfirm){
                        
                        //Vérification de l'adresse mail
                        $testMail=$bdd->prepare("SELECT Num_Client FROM users where email=? limit 1");
                        $testMail->execute(array($email));
                        $tab=$testMail->fetchAll();
                        if(count($tab)>0){

                            echo "mailUse";
                            die;
                        }
                        
                        //Vérification du numéro de téléphone
                        $testPhone=$bdd->prepare("SELECT Num_Client FROM users where tel=? limit 1");
                        $testPhone->execute(array($tel));
                        $tab=$testPhone->fetchAll();
                        if(count($tab)>0){
                           
                            echo "telUse";
                            die;
                        }

                        // //Définition de la taille maximale de l'image
                        // $maxSize = 500000;
                        // //Définition des extention valide
                        // $validExt = array('.png', '.jpeg', '.jpg');
                        
                        // if(isset($_FILES['photo_profil'])){

                        //     if($_FILES['photo_profil']['error'] > 0){
                        //         $_SESSION["erreurInscription"] = 'Erreur';
                        //         header('Location: ../controllers/inscription.php');
                        //         die;
                        //     }
                            
                        //     //Récupération de la taille de l'image
                        //     $fileSize = $_FILES['photo_profil']['size'];
                        
                        //     //Vérification de la taille maximale
                        //     if($fileSize > $maxSize){
                        //         $_SESSION["erreurInscription"] = 'Fichier trop volumineux !';
                        //         header('Location: ../controllers/inscription.php');
                        //         die;
                        //     }

                        //     //Récupération de le l'extention de l'image
                        //     $fileExt = ".".strtolower(substr(strrchr($_FILES['photo_profil']['name'],'.'),1));

                        //     //Vérifie que l'extention est valide
                        //     if(!in_array($fileExt, $validExt)){
                        //         $_SESSION["erreurInscription"] = "Cette extention n'est pas prise en charge.";
                        //         header('Location: ../controllers/inscription.php');
                        //         die;
                        //     }
                        // }else{//Initialisation du nom de 
                            $idPhoto = "pp_default";
                        // }

                        $date = new DateTime();
                        
                        
                            $addUser = $bdd->prepare("INSERT INTO users (nom,prenom,email,tel,adresse,ville,code_postal,password,date_creation) values(?,?,?,?,?,?,?,?,?)");
                            if($addUser->execute(array($nom,$prenom,$email,$tel,$adresse,$ville,$codePostal,password_hash($password, PASSWORD_BCRYPT),$date->format("d/m/Y")))){
                                $statut = 1;
                                // if(isset($_FILES['photo_profil'])){
                                    
                                //     //Récupération de l'id de l'utilisateur créée
                                //     $maxUserId=$bdd->query("SELECT MAX(num_client) AS MAXID FROM users");
                                //     if($tab=$maxUserId->fetch()){
                                //         $idPhoto = "pp_".$tab["MAXID"];
                                //     }else{
                                //         $idPhoto = "pp_0";
                                //     }
                                // }
                                    
                                // //Ajout de l'identifiant de la photo de profil
                                // $updatePP = $bdd->prepare("UPDATE users SET photo_profil = ? WHERE email = ?");
                                // if($updatePP->execute(array($idPhoto, $email))){
                                //     if(move_uploaded_file($_FILES['photo_profil']['tmp_name'], '../photo_profil/'.$idPhoto.$fileExt)){
                                //         $_SESSION["erreurInscription"] = "Transfert terminé !";
                                //     }else{
                                //         $_SESSION["erreurInscription"] = "Erreur lors du transfert !";
                                //     }
                                // }
                                // header("location:../controllers/connexion.php");
                            }
                        
                    }else{
                        $erreur = "Les mots de passe ne correspondent pas.";
                    }
                }else{
                    $erreur = "Veuillez renseigner tous les champs.";
                }
            }else{
                $erreur = "Vous avez dépassé le temps de validité du formulaire, veuillez réessayer.";
            }
        }
    }
}
echo $statut;
?>
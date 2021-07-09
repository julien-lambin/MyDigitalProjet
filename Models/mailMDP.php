<?php
include('bdd.php');
 
session_start();

if(isset($_GET['section'])) {
    $section = htmlspecialchars($_GET['section']);
    }

    $_SESSION['erreurMDP'] = "";
 
if(isset($_POST['recup_submit'],$_POST['verif_email'],$_POST['confirm_verif_email'])) {
   if(!empty($_POST['verif_email'])) {
    if($_POST['verif_email'] == $_POST['confirm_verif_email']){
      $recup_mail = htmlspecialchars($_POST['verif_email']);
      if(filter_var($recup_mail,FILTER_VALIDATE_EMAIL)) {
         $mailexist = $bdd->prepare('SELECT Num_Client,nom,prenom FROM users WHERE email = ?');
         $mailexist->execute(array($recup_mail));
         $mailexist_count = $mailexist->rowCount();
         if($mailexist_count == 1) {
            $nomPrenom = $mailexist->fetch();
            $nom = $nomPrenom['nom'];
            $prenom = $nomPrenom['prenom'];
            
            $_SESSION['recup_mail'] = $recup_mail;
            $recup_code = "";
            for($i=0; $i < 8; $i++) {
                $recup_code .= mt_rand(0,9);
            }
            $mail_recup_exist = $bdd->prepare('SELECT id FROM recuperation WHERE email = ?');
            $mail_recup_exist->execute(array($recup_mail));
            $mail_recup_exist = $mail_recup_exist->rowCount();
            if($mail_recup_exist == 1) {
               $recup_insert = $bdd->prepare('UPDATE recuperation SET code = ? WHERE email = ?');
               $recup_insert->execute(array($recup_code,$recup_mail));
            } else {
               $recup_insert = $bdd->prepare('INSERT INTO recuperation(email,code) VALUES (?, ?)');
               $recup_insert->execute(array($recup_mail,$recup_code));
            }
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
                     
                     <div align="center">Bonjour <b>'.$nom.' '.$prenom.'</b>,</div>
                     <div align="center">Voici votre code de récupération: <b>'.$recup_code.'</b></div>
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
         if(mail($recup_mail, "Récupération de mot de passe - DoneIT", $message, $header)){
            header("Location:http://localhost/DoneIT/controllers/recuperation.php?section=code");
            $_SESSION['erreurMDP'] = "";
            die;
         }else{
            $error = "Erreur lors de l'envoi de l'email";
         }
         } else {
            $error = "Cette adresse mail n'est pas enregistrée";
         }
      } else {
         $error = "Adresse mail invalide";
      }
   } else{
    $error = "Les adresses mail ne correspondent pas";
   }
    } else {
        $error = "Veuillez entrer votre adresse mail";
     }
     $_SESSION['erreurMDP'] = $error;
     header("Location:http://localhost/DoneIT/controllers/recuperation.php");
}

if(isset($_POST['verif_submit'],$_POST['verif_code'])) {
   if(!empty($_POST['verif_code'])) {
      $verif_code = htmlspecialchars($_POST['verif_code']);
      $verif_req = $bdd->prepare('SELECT id FROM recuperation WHERE email = ? AND code = ?');
      $verif_req->execute(array($_SESSION['recup_mail'],$verif_code));
      $verif_req = $verif_req->rowCount();
      if($verif_req == 1) {
         $up_req = $bdd->prepare('UPDATE recuperation SET confirme = 1 WHERE email = ?');
         $up_req->execute(array($_SESSION['recup_mail']));
         header('Location:http://localhost/DoneIT/controllers/recuperation.php?section=changemdp');
         $_SESSION['erreurMDP'] = "";
         die;
      } else {
         $error = "Code invalide";
      }
   } else {
      $error = "Veuillez entrer votre code de confirmation";
   }
   $_SESSION['erreurMDP'] = $error;
   header("Location:http://localhost/DoneIT/controllers/recuperation.php?section=code");
}
if(isset($_POST['change_submit'])) {
   if(isset($_POST['change_mdp'],$_POST['change_mdpc'])) {
      $verif_confirme = $bdd->prepare('SELECT confirme FROM recuperation WHERE email = ?');
      $verif_confirme->execute(array($_SESSION['recup_mail']));
      $verif_confirme = $verif_confirme->fetch();
      $verif_confirme = $verif_confirme['confirme'];
      if($verif_confirme == 1) {
         $mdp = htmlspecialchars($_POST['change_mdp']);
         $mdpc = htmlspecialchars($_POST['change_mdpc']);
         if(!empty($mdp) AND !empty($mdpc)) {
            if($mdp == $mdpc) {
               $ins_mdp = $bdd->prepare('UPDATE users SET password = ? WHERE email = ?');
               $ins_mdp->execute(array(password_hash($mdp, PASSWORD_BCRYPT),$_SESSION['recup_mail']));
               $del_req = $bdd->prepare('DELETE FROM recuperation WHERE email = ?');
               $del_req->execute(array($_SESSION['recup_mail']));
               header('Location:http://localhost/DoneIT/controllers/connexion.php');
               $_SESSION['erreurMDP'] = "";
               die;
            } else {
               $error = "Vos mots de passes ne correspondent pas";
            }
         } else {
            $error = "Veuillez remplir tous les champs";
         }
      } else {
         $error = "Veuillez valider votre mail grâce au code de vérification qui vous a été envoyé par mail";
      }
   } else {
      $error = "Veuillez remplir tous les champs";
   }
   $_SESSION['erreurMDP'] = $error;
   header("Location:http://localhost/DoneIT/controllers/recuperation.php?section=changemdp");
}
?>


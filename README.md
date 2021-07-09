# coffre-fort
## Pour l’installation :
#### Attention il est conseillé d’utiliser Wamp ou Xamp, une base de donnée mysql et une version de php supérieur à php 7.

## Récupération du projet
Créer un dossier coffre-fort.

Faite un git clone du projet :
``` git clone https://github.com/neri-xavier/coffre-fort.git ```

Pour récupérer la base de données, créer une base de données « coffre_fort ». Ensuite ouvrez le dossier « Installation », puis Database et insérez dans votre nouvelle base de données le fichier « coffre_fort.sql »

## Sendmail
Afin de tester la récupération de mot de passe et l’envoi de mail vous aller devoir installer « Sendmail ». Pour cela rendez-vous dans le dossier « Installation », puis copiez collez le dossier « sendmail » dans le dossier « wamp64 ».

Ensuite rendez-vous dans le fichier php.ini

![image](https://user-images.githubusercontent.com/51157220/109821466-4bfecc80-7c36-11eb-9733-36095fbbdc91.png)

Rechercher "mail function"

![image](https://user-images.githubusercontent.com/51157220/109821743-95e7b280-7c36-11eb-9668-0704aa5ee330.png)

Puis remplacez la configuration par défaut avec cette nouvelle configuration :

```
[mail function]
; For Win32 only.
; http://php.net/smtp
SMTP = smtp.gmail.com
; http://php.net/smtp-port
smtp_port = 587

; For Win32 only.
; http://php.net/sendmail-from
sendmail_from ="help.coffre.fort@gmail.com"

; For Unix only.  You may supply arguments as well (default: "sendmail -t -i").
; http://php.net/sendmail-path
sendmail_path = "\"E:\Software\wamp64\sendmail\sendmail.exe\" -t"

; Force the addition of the specified parameters to be passed as extra parameters
; to the sendmail binary. These parameters will always replace the value of
; the 5th parameter to mail().
;mail.force_extra_parameters =

; Add X-PHP-Originating-Script: that will include uid of the script followed by the filename
mail.add_x_header = Off

; The path to a log file that will log all mail() calls. Log entries include
; the full path of the script, line number, To address and headers.
;mail.log =
; Log mail to syslog (Event Log on Windows).
;mail.log = syslog
```

Vous pouvez maintenant redémarrer Wamp.

Si vous rencontrez des problèmes n'hésitez à nous contacter.

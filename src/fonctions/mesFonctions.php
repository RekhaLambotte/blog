<?php

    // Je crée ma fonction grain de sel qui va générer une chaine aléatoire que l'on rajoutera
    // au hash du mot de passe pour compléxifier sa décryption par un éventuel hackeur.
    function grainDeSel($x){
        // je crée une variable qui contiendra les caractères qui peuvent composer un hash md5
        $chars = "0123456789abcdef";
        $string = "";
        // je créer une boucle qui va choisir une série de x caractère
        // le x étant le paramètre de ma fonction qui sera lui aussi généré aléatoirement
        for($i = 0; $i < $x; $i++){
            $string .= $chars[rand(0, strlen($chars) -1)];
        }
        return $string;
    }

    // Fonction pour envoyer une image qui prendra en compte l'endroit ou sera envoyé l'upload selon
    // que ce soit un avatar ou pour un article
    function sendImg($photo, $destination){
        // Décider ou doit aller ma photo
        if($destination == "avatar"){
            $dossier = "../../src/img/avatar/" . time();
        } else {
            $dossier = "../../src/img/article/" . time();
        }

        // Créer un tableau avec les extension autorisée
        $extensionArray = ["png", "jpg", "jpeg", "jfif", "PNG", "JPG", "JPEG", "JFIF"];
        // récupérer toutes les infos du fichier envoyé
        $infofichier = pathinfo($photo["name"]);
        // Je récupère l'extensio du fichier envoyé
        $extensionImage = $infofichier["extension"];
    
        // Extension autorisée ? 
        if(in_array($extensionImage, $extensionArray)){
            // préparer le chemin repertoire + nom fichier
            $dossier .= basename($photo["name"]);
            // envoyer mon fichier
            move_uploaded_file($photo["tmp_name"], $dossier);
        }
        return $dossier;
    }

    // fonction pour savoir si un user est connecté ou nojn
    function estConnecte(){
        if(isset($_SESSION["connecté"]) && $_SESSION["connecté"] == true){
            header("location: ../../index.php");
        }
    }
?>
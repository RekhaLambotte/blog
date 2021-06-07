<?php 

    // Je crée ma fonction grain de sel qui va générer une chaine de aléatoire que l'on ajoutera au hash du mot pour complexifier sa décryptation pour un éventuel hackeur.

    function grainDeSel($x){
        //je crée une variable qui contiendra kes caractères qui peuvent composer un hash md5
        $chars = "0123456789abcdef";
        $sting ="";

        //Je crée une boucle qui va choisir une série de caravtère
        // le x étant le parametre de la fonction qui sera lui aussi généré aléatoirement
        for($i=0 ; $i< $x; $i++){
            $string = $string.$chars[rand(0, strlen($chars)-1)];
        }
        return $string;
    }


    // fonction pour envoyer une image qui prendra en compte l'endroit ou sera envoyé le téléchatgement selon que ce soit pour un avatar ou pour un article

    function sendImg($photo, $destination){
        // Décider où doit aller la photo
        if($destination == "avatar") {
            $dossier = "../../src/img/avatar";
        }else {
            $dossier = "../../src/img/article";
        }

        // Création d'un tableau avec les extentions autorisée
        $ententionArray = ["png", "jpg", "jpeg", "jfif", "PNG", "JPG", "JPEG", "JFIF"];

        // Récupérer les infos du fichier envoyé
        $infoFichier = pathinfo($photo["name"]);

        // je récupère l'extention du fichier envoyé qui va définir le type de fichier que c'est
        $entensionImage = $infoFichier["extension"];

        // extention autorisé? 
        if(in_array($extensionImage, $ententionArray)){

            //préparer le chemin répertoire + le nom du fichier
            $dossier = $dossier.basename($photo["name"]);

            // envoie du fichier $photo = origin vers $dossier = destination
            move_uploaded_file($photo["tmp_name"], $dossier);
        }
        return $dossier;
    }

    // fonction pour savoir si un user est connéecté ou non 
    function estConnecte () {

        // s'il y une session "connecté" et qu'elle est true alors on va sur index.php
        if(isset($_SESSION["connecté"]) && $_SESSION["connecté"]== true){
            header("location: ../../index.php")
        }
    }

?>
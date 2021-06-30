<?php

    // Je crée une fonction qui va générer une chaine de caratère aléatoire
    function grainDeSel($x){
        // Je crée une variable contenant tous les caractère permis en sha1
        $chars = '0123456789abcdef';
        // Une variable string pour acceuillir le résultat de ce random
        $string = '';
        // Je crée une boucle qui va choisir aléatoirement une série de x caractère, 
        // le x étant le paramètre de ma fonction qui sera lui aussi généré aléatoirement
        for($i = 0; $i < $x; $i++){
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

        // Fonction pour envoyer image qui prends en compte l'endroit ou sera envoyée l'upload selon
    // que ce soit un avatar ou une image pour un article.
    function sendImg($photo, $destination){
        // décider de l'endroit ou upload la photo
        if($destination == "avatar"):
            $dossier = "../../src/img/avatar/" . time();
        else:
            $dossier = "../../src/img/article/" . time();
        endif;

        // Vérifier la taille du fichier recu (1M = 1000000o)
        if($photo["size"] <= 10000000)
        {
            // Extension autorisée pour l'upload:
            $extensionArray = ["png", "PNG", "gif", "GIF", "jpg", "JPG", "JPEG", "jfif", "JFIF", "jpeg"];
            // récupérer toutes les infos du fichier envoyé
            $infoFichier = pathinfo($photo["name"]);
            // Je récupére l'extension du fichier qui a été envoyé
            $extensionImage = $infoFichier["extension"];

            // Extension autorisée ? 
            if(in_array($extensionImage, $extensionArray)){
                // préparation chemin repertoire + renommer le fichier
                $dossier .= basename($photo["name"]);
                // envoi fichier
                move_uploaded_file($photo["tmp_name"], $dossier);
            }
        } 
        return $dossier;
    }

    // fonction pour savoir si un user est connecté ou non
    function estConnecté(){
        // Si mon user est connecté, je le renvoie sur la page d'acceuil
        if(isset($_SESSION["connecté"]) && $_SESSION["connecté"] == true):
            header("location: ../../index.php");
        endif;
    }
?>
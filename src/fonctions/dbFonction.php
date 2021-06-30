<?php

// Enregister un nouvel user dans ma base de donnée
    function createUser($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban, $verification, $verified){
    
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO users(avatar, login, nom, prenom, email, mdp, roleId, ban, verificationKey, verified)
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $requete->execute(array($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban, $verification, $verified)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();
    }

// Fonction pour se connecter au site
    function login($user, $password){
        // connection à la db
        $bdd = dbAccess();
        // requete pour récupérer l'user correspondant au login entré
        $requete = $bdd->query('SELECT * 
                                FROM users u 
                                INNER JOIN role r ON r.roleId = u.roleId;') or die(print_r($requete->errorInfo(), TRUE));

        // Traitement de la requete
        while($result = $requete->fetch()){
            if($result["login"] == $user){
                // sel du mdp envoyé avec le sel contenu dans la colonne ban
                $sel = md5($password) . $result["ban"];
                
                //J'active ma session user avec les infos dont je pourrai avoir besoin
                // tant que mon utilisateur est connecté 
                if($result["mdp"] == $sel){
                    $_SESSION["connect"] = true;
                    $_SESSION["user"] = [
                        "id" => $result["userId"],
                        "nom" => $result["nom"],
                        "prenom" => $result["prenom"],
                        "photo" => $result["avatar"],
                        "login" => $result["login"],
                        "email" => $result["email"],
                        "role" => $result["nomRole"]
                    ];
                    // J'active la session connecté
                    $_SESSION["connecté"] = true;
                    // Je ferme ma connection
                    $requete->closeCursor();
                    // Je redirige vers la page account
                    header("location: ../../src/pages/account.php");
                    exit();
                }
                else{
                    
                    header("location: ../../src/pages/login.php?erreur=Mot de passe incorrect");
                    exit();
                }
            }
        }
        // Si mon script arrive ici, il est sorti de ma boucle sans trouver de user
        header("location: ../../src/pages/login.php?erreur=Identifiant inconnu, veuillez recommencer!");
        exit();
    }

    // FONCTION POUR UPDATER UNE PHOTO
    function updateImg($files){
        $bdd = dbAccess();
        $requete = $bdd->prepare("UPDATE users
                                SET avatar = ? 
                                WHERE userId = ? ");
        $requete->execute(array($files, $_SESSION["user"]["id"])) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();
}

    // // Function pour récupérer les catégorie de console
    // function getHardCategorie(){
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->query("SELECT * FROM hardware") or die(print_r($requete->errorInfo(), TRUE));

    //     $listCategorie = [];
    //     // Je distribue mes données dans une variable tableau
    //     while($données = $requete->fetch()){
    //         $listCategorie[] = $données["console"];
    //     }
    //     $requete->closeCursor();

    //     // J'envoie les données dans mon appli
    //     return $listCategorie;
    // }

    // // DELETE HARD CATEGORIE
    // function deleteHardCategorie($console){
    //     var_dump($console);
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->prepare("DELETE FROM hardware WHERE console = ?");
    //     $requete->execute(array($console));
    //     $requete->closeCursor();

    // }

    // // AJOUTER UNE CONSOLE
    // function addHardCategorie($console){
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->prepare("INSERT INTO hardware(console) VALUES(?)");
    //     $requete->execute(array($console));
    //     $requete->closeCursor();

    // }

    // // CATEGORIE ARTICLE
    // function getCategorie(){
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->query("SELECT * FROM categorie") or die(print_r($requete->errorInfo(), TRUE));

    //     $listCategorie = [];
    //     // Je distribue mes données dans une variable tableau
    //     while($données = $requete->fetch()){
    //         $listCategorie[] = $données["nomCategorie"];
    //     }
    //     $requete->closeCursor();

    //     // J'envoie les données dans mon appli
    //     return $listCategorie;
    // }

    //     // DELETE CATEGORIE D'ARTICLE
    //     function deleteTypeCategorie($type){
    //         var_dump($type);
    //         $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //         $requete = $bdd->prepare("DELETE FROM categorie WHERE nomCategorie = ?");
    //         $requete->execute(array($type));
    //         $requete->closeCursor();
    
    //     }
    
    //     // AJOUTER UNE CATEGORIE D'ARTICLE
    //     function addTypeCategorie($type){
    //         $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //         $requete = $bdd->prepare("INSERT INTO categorie(nomCategorie) VALUES(?)");
    //         $requete->execute(array($type));
    //         $requete->closeCursor();
    
    //     }

    //     // CATEGORIE GAME
    // function getGameCategorie(){
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->query("SELECT * FROM gameCategory") or die(print_r($requete->errorInfo(), TRUE));

    //     $listCategorie = [];
    //     // Je distribue mes données dans une variable tableau
    //     while($données = $requete->fetch()){
    //         $listCategorie[] = $données["genre"];
    //     }
    //     $requete->closeCursor();

    //     // J'envoie les données dans mon appli
    //     return $listCategorie;
    // }

    // // DELETE TYPE CATEGORIE
    // function deleteGameCategorie($genre){
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->prepare("DELETE FROM gameCategory WHERE genre = ?");
    //     $requete->execute(array($genre));
    //     $requete->closeCursor();

    // }

    // // AJOUTER UNE CONSOLE
    // function addGameCategorie($genre){
    //     $bdd = new PDO("mysql:host=localhost;dbname=game_from_belgium;charset=utf8", "root", "");
    //     $requete = $bdd->prepare("INSERT INTO gameCategory(genre) VALUES(?)");
    //     $requete->execute(array($genre));
    //     $requete->closeCursor();
    // }



    
    
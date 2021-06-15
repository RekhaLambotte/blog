<?php
    // Enregistre un nouvel utilisteur dans notre base de données
    function createUser($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban){
        $bdd = dbAccess();
        $requete =$bdd->prepare("INSERT INTO users(avatar, login, nom, prenom, email, mdp, roleId, ban)
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute(array($avatar, $login, $nom, $prenom, $email, $mdp, $roleId, $ban)) or die(print_r($requete->errorInfo(), TRUE));
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


function updateImg($fichier){
    $bdd = dbAccess();
    // Preprarer la requete pour updater données
    $requete = $bdd->prepare("UPDATE users
                            SET avatar = ?
                            WHERE userId = ? ");
    $requete->execute(array($fichier, $_SESSION["user"]["id"]));
    $requete->closeCursor();  
     
}

// fonction pour aller chercher la catégorie
    function getHardCategorie(){
        $dbb= dbAccess();
        $requete = $dbb->query("SELECT * FROM hardware") or die(print_r($requete->errorInfo(), TRUE));

        while($données = $requete->fetch()){
            $listeHardCategorie[] = $données;
        }
        $requete->closeCursor();
        return $listeHardCategorie;

    }

    function addHardCategorie($console){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO hardware(console) VALUES(?)");
        $requete->execute(array($console));
        $requete->closeCursor();
    }

    function deleteHardCategorie($hardId){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM hardware WHERE hardID=?");
        $requete->execute(array($hardId)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();

    }


    // catégorie type d'article

    // chercher tous les types d'articles
    function getCategory(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM categorie");

        while ($donnees = $requete->fetch()){
            $listeCategorie[] = $donnees;
        }

        $requete->closeCursor();
        return $listeCategorie;
    }

    function addTypeCategorie($typeArticle){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO categorie(nomCategorie) VALUES(?)");
        $requete->execute(array($typeArticle));
        $requete->closeCursor();
    }


    function deleteTypeCategorie($categorieId){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM categorie WHERE categorieId=?");
        $requete->execute(array($categorieId)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();

    }


    // catégorie type de jeux

    // chercher tous les types de jeux
    function getGameCategory(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM gamecategory");

        while ($donnees = $requete->fetch()){
            $listeGameCategorie[] = $donnees;
        }

        $requete->closeCursor();
        return $listeGameCategorie;
    }
    
    function addTypeGameCategorie($typeGame){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO gamecategory(genre) VALUES(?)");
        $requete->execute(array($typeGame));
        $requete->closeCursor();
    }


    function deleteTypeGameCategorie($categorieGameId){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM gamecategory WHERE gameCategoryId=?");
        $requete->execute(array($categorieGameId)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();

    }

?>  
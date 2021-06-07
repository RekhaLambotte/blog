<?php 
    // Enregistrer un nouvel utilisateur dans notre base de données

    const createUser ($avatar, $prenom, $nom, $login, $email, $mdp, $roleId, $ban) => {
        $bdd = new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8","root","root")
        $requet = $bdd->prepare(" INSERT INTO users(avatar, prenom, nom, login, email, mdp, roleId, ban)")
                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?);
        $requete->execute(array($avatar, $prenom, $nom, $login, $email, $mdp, $roleId, $ban)) or die(print);
        $requete->closeCursor();
    }

?>
<?php

// Function pour récupérer les catégorie de console
    function getHardCategorie(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM hardware") or die(print_r($requete->errorInfo(), TRUE));

        $listCategorie = [];
        // Je distribue mes données dans une variable tableau
        while($données = $requete->fetch()){
            $listCategorie[] = $données["console"];
        }
        $requete->closeCursor();

        // J'envoie les données dans mon appli
        return $listCategorie;
    }

    // DELETE HARD CATEGORIE
    function deleteHardCategorie($console){
        var_dump($console);
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM hardware WHERE console = ?");
        $requete->execute(array($console));
        $requete->closeCursor();

    }

    // AJOUTER UNE CONSOLE
    function addHardCategorie($console){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO hardware(console) VALUES(?)");
        $requete->execute(array($console));
        $requete->closeCursor();

    }

    // CATEGORIE ARTICLE
    function getCategorie(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM categorie") or die(print_r($requete->errorInfo(), TRUE));

        $listCategorie = [];
        // Je distribue mes données dans une variable tableau
        while($données = $requete->fetch()){
            $listCategorie[] = $données["nomCategorie"];
        }
        $requete->closeCursor();

        // J'envoie les données dans mon appli
        return $listCategorie;
    }

        // DELETE CATEGORIE D'ARTICLE
        function deleteTypeCategorie($type){
            var_dump($type);
            $bdd = dbAccess();
            $requete = $bdd->prepare("DELETE FROM categorie WHERE nomCategorie = ?");
            $requete->execute(array($type));
            $requete->closeCursor();
    
        }
    
        // AJOUTER UNE CATEGORIE D'ARTICLE
        function addTypeCategorie($type){
            $bdd = dbAccess();
            $requete = $bdd->prepare("INSERT INTO categorie(nomCategorie) VALUES(?)");
            $requete->execute(array($type));
            $requete->closeCursor();
    
        }

        // CATEGORIE GAME
    function getGameCategorie(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT * FROM gamecategory") or die(print_r($requete->errorInfo(), TRUE));

        $listCategorie = [];
        // Je distribue mes données dans une variable tableau
        while($données = $requete->fetch()){
            $listCategorie[] = $données["genre"];
        }
        $requete->closeCursor();

        // J'envoie les données dans mon appli
        return $listCategorie;
    }

    // DELETE TYPE CATEGORIE
    function deleteGameCategorie($genre){
        $bdd = dbAccess();
        $requete = $bdd->prepare("DELETE FROM gameCategory WHERE genre = ?");
        $requete->execute(array($genre));
        $requete->closeCursor();

    }

    // AJOUTER UNE CONSOLE
    function addGameCategorie($genre){
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO gameCategory(genre) VALUES(?)");
        $requete->execute(array($genre));
        $requete->closeCursor();
    }

    // CHERCHER UNE CATEGORIE D'ARTICLE PAR GENRE POUR RECUPERER SON ID
    function getTypeArticleByName($categorieId){
        $bdd = dbAccess();
        $requete = $bdd->prepare("SELECT categorieId FROM categorie
                                WHERE nomCategorie = ?");
        $requete->execute(array($categorieId))or die(print_r($requete->errorInfo(), TRUE));

        while($données = $requete->fetch()):
            $listCategorie[] = $données;
        endwhile;
        $requete->closeCursor();

        return $listCategorie;
    }

    // Chercher une categorie de jeu par son nom
    function getGameCategoryByName($valeur){
        $bdd = dbAccess();
        $requete = $bdd->prepare("SELECT * FROM gamecategory
                                    WHERE genre = ?");
        $requete->execute(array($valeur)) or die(print_r($requete->errorInfo(),TRUE));
        while($données = $requete->fetch()){
            $gameCategoryId = $données;
        }
        $requete->closeCursor();
        return $gameCategoryId;
        }
?>
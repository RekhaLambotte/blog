<?php

// Function pour récupérer la liste des jeux
    function getListGame(){
        $bdd = dbAccess();
        $requete = $bdd->query("SELECT jeux.gameId, jeux.nom, jeux.developpeur, jeux.editeur, 
                                jeux.dateDeSortie, jeux.cover, hardware.console, gamecategory.genre 
                                FROM jeux
                                INNER JOIN hardware ON hardware.hardId = jeux.consoleId
                                INNER JOIN gamecategory ON gamecategory.gameCategoryId = jeux.gameCategoryId") 
                                or die(print_r($requete->errorInfo(), TRUE));

        $listCategorie = [];
        // Je distribue mes données dans une variable tableau
        while($données = $requete->fetch()){
            $listCategorie[] = array(
                "id"                => $données["gameId"],
                "nom"               => $données["nom"],
                "developpeur"       => $données["developpeur"],
                "editeur"           => $données["editeur"],
                "dateDeSortie"    => $données["dateDeSortie"],
                "cover"             => $données["cover"],
                "console"           => $données["console"],
                "genre"             => $données["genre"]
            );
        }
        $requete->closeCursor();

        // J'envoie les données dans mon appli
        return $listCategorie;
    }


// <!-- FONCTION POUR RECUPERER LA LISTE DES HARDWARE ET DES GENRE -->
function getHard(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT * FROM hardware")or die(print_r($requete->errorInfo(), TRUE));;
    $listHardware = array();

    while($données = $requete->fetch()){
        $listHardware[] = [$données["hardId"], $données["console"]];
    }
    return $listHardware;
}

function getGenre(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT * FROM gamecategory")or die(print_r($requete->errorInfo(), TRUE));;
    $listCategorie = array();

    while($données = $requete->fetch()){
        $listCategorie[] = [$données["gameCategoryId"], $données["genre"]];
    }
    return $listCategorie;
}

// Ajouter un jeu
function addGame($jeux, $console, $genre, $dev, $edit, $release, $cover){
    $bdd = dbAccess();
    $requete = $bdd->prepare("INSERT INTO jeux(nom, consoleId, gameCategoryId, developpeur, editeur, dateDeSortie, cover)
                            VALUES(?, ?, ?, ?, ?, ?, ?)")or die(print_r($requete->errorInfo(), TRUE));
    $requete->execute(array($jeux, $console, $genre, $dev, $edit, $release, $cover))or die(print_r($requete->errorInfo(), TRUE));

    $requete->closeCursor();
}

// DELETE UN JEU

function deleteGame($jeux){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM jeux WHERE gameId = ?");
    $requete->execute(array($jeux))or die(print_r($requete->errorInfo(), TRUE));;
    $requete->closeCursor();
}

//REchercher un jeu par son nom
function getGameByName($valeur){
    $bdd = dbAccess();
    $requete = $bdd->prepare("SELECT *  FROM jeux
                                WHERE nom = ?");
    $requete->execute(array($valeur)) or die(print_r($requete->errorInfo(),TRUE));

    while($données = $requete->fetch()){
        $listeJeux[] = $données;
    }
    $requete->closeCursor();
    return $listeJeux;
}

//Fonction trouver une console par son nom
function getHardByNAme($valeur){
    $bdd = dbAccess();
    $requete = $bdd->prepare("SELECT * FROM hardware
                                WHERE console = ?");
    $requete->execute(array($valeur)) or die(print_r($requete->errorInfo(), TRUE));
    while($données = $requete->fetch()){
        $idHardware[] = $données;
    }
    $requete->closeCursor();
    return $idHardware;
}

?>
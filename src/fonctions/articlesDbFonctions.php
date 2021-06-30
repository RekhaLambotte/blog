<?php
    //Fonction pour créer un nouvel article
    function envoyerArticle($titre, $imgUrl, $content, $date, $categorieId, $gameCategoryId, $auteurId, $gameId, $hardId, $star){
        //Traitement de l'image envoyée
        $traiterImage = sendImg($imgUrl, "article");
        //Récuperer l'id de la catégorie d'article qui correspond à la selection de l'auteur
        $arrayCategorieId = getTypeArticleByName($categorieId);
        //J'envoie l'index récupéré dans une nouvelle variable
        $categorieId = $arrayCategorieId[0][0];
        // Récuperer id catégorie
        $arrayGameCategoryId = getGameCategoryByName($gameCategoryId);
        $gameCategoryId = $arrayGameCategoryId[0][0];    
        //Récuperer l'id du jeu
        $arrayGameName = getGameByName($gameId);
        $gameId = $arrayGameName[0][0];
        // Récupérer l'id HArdware
        $arrayHardware = getHardByNAme($hardId);
        $hardId = intval($arrayHardware[0][0]);
        //Envoyer article dans DB
        $bdd = dbAccess();
        $requete = $bdd->prepare("INSERT INTO articles(titre, imgUrl, content, date, categorieId, gameCategoryId, auteurId, gameId, hardId, star)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute(array($titre, $traiterImage, $content, $date, $categorieId, $gameCategoryId, $auteurId, $gameId, $hardId, $star)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();    
        //Vérifier si star est actif ou pas
        if($star == true)
        {
            //Envoyer l'article a la une dans la table star
            aLaUne($titre);
        }
    }
    function aLaUne($valeur)
    {
        $bdd = dbAccess();
        $requete = $bdd->prepare("SELECT articleId FROM articles
                                    WHERE titre = ?");
        $requete->execute(array($valeur)) or die(print_r($requete->errorInfo(), TRUE));
        while($donnees = $requete->fetch()){
            $articleId = $donnees[0];
        }
        $requete = $bdd->prepare("INSERT INTO stars(articleId) VALUES(?)");
        $requete->execute(array($articleId)) or die(print_r($requete->errorInfo(), TRUE));
        $requete->closeCursor();
    }
    function getTop()
    {
        $dbb = dbAccess();
        $requete = $dbb->query("SELECT *
                                FROM articles
                                WHERE star=1");
        while($donnees = $requete->fetch()){
            $articlesOnTop[] = $donnees;
        }
        $requete->closeCursor();
        return $articlesOnTop;
    }
    function getListArticle()
    {
        $bdd = dbAccess();
        $requete = $bdd->query(" SELECT articleId, titre
                                FROM articles ");
        while($donnees = $requete->fetch())
        {
            $listeArticles[] = $donnees;
        }
        $requete->closeCursor();
        return $listeArticles;
    }

?>
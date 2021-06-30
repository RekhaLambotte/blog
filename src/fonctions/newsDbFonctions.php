<?php

// récupérer les articles à la lune
function getArticleOnTop(){
    $bdd = dbAccess();
    $requete = $bdd->query("SELECT a.articleId, a.titre, a.imgUrl, a.content, a.date, c.nomCategorie, gc.genre, u.nom, u.prenom
                                FROM articles a
                                INNER JOIN categorie c on c.categorieId = a.categorieId
                                INNER JOIN gamecategory gc on gc.gameCategoryId = a.gameCategoryId
                                INNER JOIN users u on u.userId = a.auteurId
                                INNER JOIN jeux j on j.gameId = a.gameId
                                INNER JOIN hardware h on h.hardId = a.hardId
                                INNER JOIN stars s on s.articleId= a.articleId
                                WHERE s.articleId = a.articleId
                                ORDER BY StarId DESC LIMIT 3");
    while($donnees = $requete->fetch()){
        $listOnTop[] = $donnees;
    }
    return $listOnTop;
}

function lastArticle(){
    $dbb= dbAccess();
    $requete = $dbb->query("SELECT *
                            FROM articles
                            ORDER BY date DESC LIMIT 12 ");
    while($données = $requete->fetch()){
        $listArticle[] = $données;
    }
    return $listArticle;
    }

?>
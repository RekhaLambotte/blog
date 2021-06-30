<?php

// rechercher un article à afficher par son id
function getArticleContent($id){
    $bdd = dbAccess();
    $requete = $bdd->prepare("SELECT a.titre, a.imgUrl, a.content, a.date, c.nomCategorie, gc.genre,u.nom AS auteurNom, u.prenom AS auteurPrenom, j.nom, j.developpeur, j.editeur, j.dateDeSortie, j.cover, h.console 
                                FROM articles a
                                INNER JOIN categorie c ON c.categorieId = a.categorieID
                                INNER JOIN gamecategory gc ON gc.gameCategoryId = a.gameCategoryId
                                INNER JOIN users u ON u.userId = a.auteurId
                                INNER JOIN jeux j ON j.gameId = a.gameId
                                INNER JOIN hardware h ON h.hardId = a.hardId
                                WHERE a.articleId = ?");
$requete->execute(array($id))or die(print_r($requete->errorInfo(), TRUE));

while($données = $requete->fetch()):
    $contenuArticle[] = $données;
endwhile;

// si l'id envoyé par l'user existe, alors retourne les données recues par la requète
if($contenuArticle){
    return $contenuArticle;
}else{ // si l'id n'estiste pas, erreur
    header("location: ../../index.php?error=true&message= Le lieb suivi n'existe pas, eretour à la page d'acceuil");
}
};

// Afficher les articles sur account.php
function getafficherArticles($auteur)
{
    $bdd = dbAccess();
    $requete = $bdd->prepare("SELECT titre, articleId
                                FROM articles
                                WHERE auteurId = ? ");
    $requete->execute(array($auteur));
    while($donnees = $requete->fetch()):
        $listArticle[] = array(
            "titreArticleAccount" => $donnees["titre"],
            "articleIdAccount" => $donnees["articleId"]);
    endwhile;
    $requete->closeCursor();
    return $listArticle;
}

?>
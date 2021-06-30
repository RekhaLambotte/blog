<?php


function addCommentaire($articleId, $autorId, $pseudo, $date, $contenu ){
    $bdd = dbAccess();
    $requete = $bdd->prepare("INSERT INTO commentaires(articleId, auteurId, pseudo, dateCommentaire, contenu) VALUES(?, ?, ?, ?, ?)");
    $requete->execute(array($articleId, $autorId, $pseudo, $date, $contenu));
    $requete->closeCursor();
}
function afficherCommentaire($article){
    $dbb = dbAccess();
    $requete = $dbb->prepare("SELECT c.contenu, c.pseudo, c.dateCommentaire, u.avatar
                                FROM commentaires c
                                INNER JOIN users u ON c.auteurId = u.userId 
                                WHERE articleId = ?");
    $requete->execute(array($article));
    while($données = $requete->fetch()){
        $commentaires[] = $données;
    }
    $requete->closeCursor();
    return $commentaires;   
}
function getListCommentaires (){
    $dbb = dbAccess();
    $requete = $dbb->query("SELECT c.commentaireId, c.auteurId, c.pseudo, c.dateCommentaire, c.contenu, a.titre, u.login 
                            FROM commentaires c
                            INNER JOIN articles a ON a.articleId = c.articleId
                            LEFT JOIN users u ON c.auteurId = u.userId");
    while($donnees = $requete->fetch()){
        $listeCommentaires[] = array(
            "comId" => $donnees["commentaireId"],
            "titre" => $donnees["titre"],
            "auteur" => $donnees["auteurId"],
            "auteurLog" => $donnees["login"],
            "comPseudo" => $donnees["pseudo"],
            "comDate" => $donnees["dateCommentaire"],
            "contenu" => $donnees["contenu"]);
    }
    $requete->closeCursor();
    return $listeCommentaires;
}
// Afficher les commentaires sur account.php
function getAfficherCommentaires($auteur)
{
    $bdd = dbAccess();
    $requete = $bdd->prepare("SELECT c.contenu, c.articleId, a.titre
                                FROM commentaires c
                                INNER JOIN articles a ON a.articleId = c.articleId 
                                WHERE c.auteurId = ? ");
    $requete->execute(array($auteur));
    while($donnees = $requete->fetch()):
        $listArticle[] = array(
            "titreArticleAccount" => $donnees["titre"],
            "contenuCommentaireAccount" => $donnees["contenu"],
            "articleIdAccount" => $donnees["articleId"]);
    endwhile;
    $requete->closeCursor();
    return $listArticle;
}
function deleteUser($com){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM commentaires WHERE commentaireId = ?");
    $requete->execute(array($com))or die(print_r($requete->errorInfo(), TRUE));;
    $requete->closeCursor();
}

?>
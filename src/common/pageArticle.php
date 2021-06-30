<link rel="stylesheet" href="../css/article.css">
<link rel="stylesheet" media = "only screen and (max-width: 1226px)"  href="../css/mobileArticle1266px.css">
<link rel="stylesheet" media = "only screen and (max-width: 1100px)"  href="../css/mobileArticle1100px.css">

<?php
$titre = "Belgium Video Gaming";
//Appeler les fichier dont j'ai beosin
require "../../src/common/template.php";
require "../../src/fonctions/dbAccess.php";
require "../../src/fonctions/afficherArticleDbFonctions.php";
require "../../src/fonctions/newsDbFonctions.php";
require "../../src/fonctions/commentairesDbFonctions.php";
require "../../src/pages/articleIncludes/commentaires.php";


if(isset($_GET["id"]) && !empty($_GET["id"])){
    // envoyer l'entier dans une variable
    $id = intval($_GET["id"]);
    // exécuter une requete pour écupérer le contenu
    $contenuArticle = getArticleContent($id);
    //var_dump($contenuArticle);
}

// envoyer le commentaire dans la dbb
// récupérer la valeur du textarea
if(isset($_POST["comment"]) && !empty($_POST["comment"])){
    commentForm();
}

// COMMENTAIRES
// récupérer l'id de l'article
$article = intval($_GET["id"]);
// récupérer les données de la dbb
$listCommentaires = affichercommentaire($article);
//var_dump($listCommentaires);
      

?>


<section class="headerArticle">

    <?php
        if($contenuArticle[0]["cover"]){
        ?>
            <div>
                <img src="<?=$contenuArticle[0]["cover"] ?>" alt="cover du jeu">
            </div>
        <?php
        }else{
            ?>
            <div> </div>
            <?php
        }

    ?>

    <!-- info du jeu de l'article -->
    <div class="infoJeu">
        <h2><?=$contenuArticle[0]["nom"] ?></h2>
        <p>
            genre : <?=$contenuArticle[0]["genre"] ?> | éditeur : <?=$contenuArticle[0]["editeur"] ?>
            developpeur : <?=$contenuArticle[0]["developpeur"] ?> | disponible : <?=$contenuArticle[0]["dateDeSortie"] ?>
            Auteur : <?=$contenuArticle[0]["auteurNom"] ?> <?=$contenuArticle[0]["auteurPrenom"] ?>
        </p>
    </div>
</section>

<section class="monArticle">

    <!-- intégralité du contenu de mon article -->
    <div class="article">
        <div class="background" style="background: url(<?= $contenuArticle[0]["imgUrl"]?>) center center/cover; min-height: 50vh ">
            <div class="titreArticle">
                <h1><?=$contenuArticle[0]["titre"] ?></h1>
            </div>
        </div>
        <!-- contenu de l'article -->
        <div class="contenuArticle">
            <?=$contenuArticle[0]["content"] ?>
        </div>
        <!-- insertion commentaire a faire plus tard -->
        <div class="commentaires">
            <form  action="" method="POST">  
                <table>
                    <thead> 
                            <th><h6>Commentez cet article</h6></th>
                        
                    </thead>
                    <tbody>
                    <?php
                            // si l'utilisateur est connecté 
                            if(isset($_SESSION["user"])){
                                //echo $_SESSION["user"]["login"]
                                $signature = $_SESSION["user"]["login"];
                            ?>
                                <tr>
                                    <td class="imgCommentaire">
                                        <img src="<?= $_SESSION["user"]["photo"]; ?>" alt="">
                                        <?= $signature ?>
                                    </td>
                                </tr>
                            <?php
                            }else{
                                $signature = "Inconnu"
                            ?>
                                <tr>
                                    <td class="imgCommentaire">
                                        <img src="../../src/img/avatar/avatar-default.png" alt="" >
                                        <?= $signature ?>
                                    </td>
                                </tr>
                            <?php
                                echo" non connecté";
                            }
                            ?>
                        <tr> <td><textarea name="comment" id="comment" placeholder="Ecrivez votre commentaire ici ..." riquired cols="30" rows="10"></textarea></td></tr>
                        <tr> <td><input type="submit" value="Ajouter un commentaire"><td></tr>
                    </tbody>
                </table> 
                
                <div>
                    <?php
                        // boucle pour afficher les données de la dbb des commentaires
                        for($i=0; $i< count($listCommentaires); $i++):
                    ?>
                        <div>
                            <img src=<?= $listCommentaires[$i]["avatar"]?> alt="">
                            <?= $listCommentaires[$i]["pseudo"]?> <?= $listCommentaires[$i]["dateCommentaire"]?> 
                        </div> 
                        <p><?= $listCommentaires[$i]["contenu"]?></p>

                    <?php endfor?> 
                </div> 
            </form>
        </div>
    </div>

    
     <?php require "../../src/pages/articleIncludes/listeDerniersArticles.php"; ?>
    
</section>

<?php
    require "../../src/common/footer.php"
?>

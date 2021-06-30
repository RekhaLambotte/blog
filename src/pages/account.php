<?php
    $titre = "Votre compte";
    require "../../src/common/template.php";
    $mdpNok = false;
    require "../../src/fonctions/dbAccess.php";
    require "../../src/fonctions/dbFonction.php";
    require '../../src/fonctions/mesFonctions.php';
    require '../../src/fonctions/afficherArticleDbFonctions.php';
    require '../../src/fonctions/commentairesDbFonctions.php';
    
   
    
    // traiter le formulaire d'envoi de photo
    if(isset($_FILES["fichier"])):
        // j'appelle ma fonction envoyer image dans une variable
        $photo = sendImg($_FILES["fichier"], "avatar");
        // Je lance ma fonction pour mettre à jour la base de donnée
        updateImg($photo);
        // image envoyée et mise à jour de la bd ok, je peux effacer l'ancien avatar
        unlink($_SESSION["user"]["photo"]);
        // Je mets à jour ma variable session photo
        $_SESSION["user"]["photo"] = $photo;
        // je recharge la page
        header("location ../../src/pages/account.php?maj=true&message=Félicitation, votre avatar est mis à jour!");
        header("location ../../src/pages/account.php?maj=true&message=Félicitation, votre avatar est mis à jour!");
    endif;


    // AFFICHER LISTE ARTICLE
    $auteurId = $_SESSION["user"]["id"];
    // var_dump ($auteurId);
    $listArticle = getafficherArticles($auteurId);
    // var_dump($listArticle);
    // AFFICHER LISTE DE COMMENTAIRE
    $listCommentaire= getAfficherCommentaires($auteurId);
    // var_dump($listCommentaire);
?>

<section id="account">
    <div class="account">

        <div class="infosMembre p-2">
            <a href="../../src/pages/account.php?edit=true"><img title="Cliquez pour changer votre avatar" src="<?= $_SESSION["user"]["photo"] ?>" alt=""></a>
            <!-- Si mon user a cliqué sur la photo, faire apparaître le formulaire d'envoi de fichier -->
            <?php 
                if(isset($_GET["edit"]) && $_GET["edit"] == true):
            ?>
            <form method="post" action="../../src/pages/account.php" enctype="multipart/form-data">
                    <input type="file" name="fichier" required>
                    <input type="submit" value="Envoyez votre photo">
            </form>
            <?php endif; 
                // Si la mise à jour s'est bien passée, afficher l'information
                if(isset($_GET["maj"]) && isset($_GET["maj"]) == true):
                    echo "<h3>" . $_GET["message"] . "</h3>";
                endif;
            ?>
            <table>
                <tr>
                    <td>pseudo:</td>
                    <td><?= $_SESSION["user"]["login"] ?></td>
                </tr>
                <tr>
                    <td>Nom:</td>
                    <td><?= $_SESSION["user"]["nom"] ?></td>
                </tr>
                <tr>
                    <td>Prenom:</td>
                    <td><?= $_SESSION["user"]["prenom"] ?></td>
                </tr>
                <tr>
                    <td>Statut:</td>
                    <td><?= $_SESSION["user"]["role"] ?></td>
                </tr>
            </table>
        </div>
        <div class="contenuMembre p-2">
            <!-- Si le role est au moins auteur -->
            <?php
                if($_SESSION["user"]["role"] == "auteur" || $_SESSION["user"]["role"] == "admin"): 
            ?>
            <h2>Vos Articles</h2>
            <!-- LISTE DES ARTICLES -->
            <?php
                for ( $i=0; $i < count($listArticle); $i++ ):
            ?>
            <a href="../../src/common/pageArticle.php?id=<?= $listArticle[$i]["articleIdAccount"]?>" ><?= $listArticle[$i]["titreArticleAccount"] ?></a>
            
            <?php endfor; ?>
            <h2>Vos Commentaires</h2>
            <table>
                <tr>
                    <th> titre de l'article </th>
                    <th> votre commentaire </th>
                </tr>
                
                    
                    <?php
                        for ( $i=0; $i < count($listCommentaire); $i++ ):
                    ?>
                    <tr>
                    <td> <?= $listCommentaire[$i]["titreArticleAccount"] ?> </td>
                    <td> <a href="../../src/common/pageArticle.php?id=<?= $listCommentaire[$i]["articleIdAccount"]?>" ><?= $listCommentaire[$i]["contenuCommentaireAccount"] ?></a> </td>
                    </tr>
                    <?php endfor; endif; ?>
                    
                
            </table>
            
            <!-- LISTE DES COMMENTAIRES -->
            
        </div>
    </div>
</section>
<?php
    require "../../src/common/footer.php";
?>
<?php

    $titre = "votre compte";
    require "../../src/common/template.php";
    require "../../src/fonctions/dbFonction.php";
    require "../../src/fonctions/mesFonctions.php";

?>

<section id="account">
    <div class="account">
        <div class="infosMembre p-2">
            <a href="../../src/pages/account.php?edit=true"> 
                <img title="Cliquez-pour changer votre avatar" src="<?= $_SESSION["user"]["photo"]?>" alt="avatar du membre"> 
            </a>
                <!-- Si mon user veut changer le photo -->
                <?php
                    if(isset($_GET["edit"]) && $_GET["edit"] == true ){
                        echo "coucou";

                ?>
                    <form action="../../src/pages/account.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fichier">
                        <input type="submit" name="Envoyer votre avatar">
                    </form>

                <?php
                    }
                    // Message pour féliciter le t'l'chargement du formulaire

                ?>

                <table>
                    <tr>
                        <td> Pseudo : </td>
                        <td> <?= $_SESSION["user"]["login"] ?></td>
                    </tr>
                    <tr>
                        <td> Nom :</td>
                        <td>  <?= $_SESSION["user"]["nom"] ?></td>
                    </tr>
                    <tr>
                        <td> Prénom : </td>
                        <td>  <?= $_SESSION["user"]["prenom"] ?></td>
                    </tr>
                    <tr>
                        <td> Satut :</td>
                        <td>  <?= $_SESSION["user"]["role"] ?></td>
                    </tr>
                
                </table>
            
        </div>
        <div class="contentMembre p-2">
            <?php 
                if($_SESSION["user"]["role"] == "auteur" || $_SESSION["user"]["role"] == "admin"){
            ?>

            <h2>Vos Articles</h2>
            <p>Pas d'article</p>

            <?php
                    }
            ?>

            <h2>Vos commentaires</h2>
            <p>Pas de commentaire</p>
        
        </div>

    </div>

</section>

<?php
// traitement du formulaire
if(isset($_FILES["fichier"])){
    $photo = sendImg($_FILES["fichier"], "avatar");
}
?>

<?php
    require "../../src/common/footer.php";
?>
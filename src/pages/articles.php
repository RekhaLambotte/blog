<?php 
    // variable pour activer le liens vers l'éditeur de texte présent sur le template
    $tinymce = true;
    $titre = "Rédiger un article";
    require "../../src/common/template.php";
    require "../../src/fonctions/dbAccess.php";
    require "../../src/fonctions/dbFonction.php";
    require "../../src/fonctions/gameDbFonctions.php";
    require "../../src/fonctions/categorieDbFonctions.php";
    require '../../src/fonctions/mesFonctions.php';
    // Gérer la variable du contenu dynamique
    $choixMenu = "redigerArticle";

    // Refuser l'accès à la page à qui n'est pas admin
    if(($_SESSION["user"]["role"] != "admin") && ($_SESSION["user"]["role"] != "auteur")):
        header("location: ../../index.php");
        exit();
    endif;
?>


<section class="gestionAdmin mb-5 p-3">
    <div class="template p-2">
        <div class="menu mt-5">
            <a href="../../src/pages/articles.php?choix=redigerArticle">Rediger un article</a>
            <a href="../../src/pages/articles.php?choix=uploaderPhoto">Uploader photo</a> 
            <a href="../../src/pages/articles.php?choix=redigerArticle&liens=memoireTampon">Afficher le tampon</a> 

        </div>
        <div class="<?=$choixMenu?>">
            <?php
                // Quand l'admin selectionne les rédiger un article
                if(isset($_GET["choix"]) && $_GET["choix"] == "redigerArticle"):
                    require "../../src/pages/redacArticlesInclude/moduleRedaction.php";  
                endif;
                // Quand l'admin selectionne l'upload de fichier
                if(isset($_GET["choix"]) && $_GET["choix"] == "uploaderPhoto"):
                    require "../../src/pages/redacArticlesInclude/moduleUploadFichier.php";  
                endif;
            ?>
        </div>
    </div>
</section>
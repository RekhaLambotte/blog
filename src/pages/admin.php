<?php 
    // variable pour activer le liens vers l'éditeur de texte présent sur le template
    $titre = "Espace d'administration";
    require "../../src/fonctions/dbAccess.php";
    require "../../src/common/template.php";
    require "../../src/fonctions/dbFonction.php";
    require '../../src/fonctions/mesFonctions.php';

    // Refuser l'accès à la page à qui n'est pas admin
    if($_SESSION["user"]["role"] != "admin"):
        header("location: ../../index.php");
    endif;
    // Gérer la variable du contenu dynamique
    $choixMenu = "adminContenu";
?>

<section class="gestionAdmin mb-5 p-3">
    <div class="template p-2">
        <div class="menu mt-5">
            <a href="../../src/pages/admin.php?choix=listeCategorie">Gérer les catégories</a>
            <a href="../../src/pages/admin.php?choix=listeJeux">Gérer les Jeux</a>
            <a href="../../src/pages/admin.php?choix=listeUsers">Gérer les users</a>
            <a href="../../src/pages/admin.php?choix=listeCommentaire">Gérer les commentaires</a>
            <a href="../../src/pages/admin.php?choix=listeArticle">Gérer les articles</a>  
        </div>
        <div class="<?=$choixMenu?>">
            <?php
                // Quand l'admin selectionne les catégories
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeCategorie"):
                    // J'injecte les fonctions liées à la catégorie
                    require "../fonctions/categorieDbFonctions.php";
                    // J'injecte les modules catégorie
                    require "../../src/pages/adminInclude/categorie/ListCategorie.php";
                endif;
                // Quand l'admin selectionne les jeux
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeJeux"):
                    // J'injecte les fonctions liées à la gestion des jeux
                    require "../fonctions/gameDbFonctions.php";
                    require "../../src/pages/adminInclude/listeJeux/listeJeux.php";
                endif;
                // Quand l'admin selectionne les Users
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeUsers"):
                    // J'injecte les fonctions liées à la gestion des jeux
                    require "../fonctions/usersDbFonctions.php";
                    require "../../src/pages/adminInclude/listeUsers/listeUsers.php";
                endif;
                // Quand l'admin selectionne les Commentaires
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeCommentaire"):
                    // J'injecte les fonctions liées à la gestion des jeux
                    require "../fonctions/commentairesDbFonctions.php";
                    require "../../src/pages/adminInclude/listeCommentaires/listeCommentaires.php";
                endif;
                // Quand l'admin selectionne les Commentaires
                if(isset($_GET["choix"]) && $_GET["choix"] == "listeArticle"):
                    // J'injecte les fonctions liées à la gestion des jeux
                    require "../fonctions/articlesDbFonctions.php";
                    require "../../src/pages/adminInclude/listeArticles/listeArticles.php";
                endif;
            ?>

        </div>
    </div>
</section>

<?php
require '../../src/common/footer.php';
?>
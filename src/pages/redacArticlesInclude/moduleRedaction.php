<?php
    require "../../src/pages/redacArticlesInclude/traitementTamponLiens.php";
    require "../../src/fonctions/articlesDbFonctions.php";
    
    // encpasuler la liste des jeux dans une variable
    $listeJeu = getListGame();
    // encapsule liste du hardware
    $listeHard = getHard();
    // Liste des catégories d'articles
    $listeGenre = getGenre();
    // type d'article
    $listeTypeArticle = getCategorie();
 
    // Traitement du formulaire
    if(isset($_POST["titre"]) && isset($_FILES["fichier"]) && isset($_POST["jeu"]) && isset($_POST["console"]) 
    && isset($_POST["typeArticle"]) && isset($_POST["genre"]) && isset($_POST["contenu"])){

        $star = 0;//par defaut je n'envoie pas à la une
        $titre = $_POST["titre"];
        $imgUrl = $_FILES["fichier"];//Traitement à effecturer dans la requete envoyer article
        $content = $_POST["contenu"];//tel quel
        $date = date('Y-m-d H:i:s');//Récupérer la date du jour
        $categorieId = $_POST["typeArticle"];
        $gameCaterogyId = $_POST["genre"];
        $auteurId = $_SESSION["user"]["id"];
        $gameId = $_POST["jeu"];
        $hardId = $_POST["console"];

        // Verifier si $star a été coché
        if(isset($_POST["star"]) && $_POST["star"] == true):
            $star = 1;
        endif;

        
        envoyerArticle($titre, $imgUrl, $content, $date, $categorieId, $gameCaterogyId,
                        $auteurId, $gameId, $hardId, $star);


    }

?>

<!-- Formulaire de création d'article -->

<section class="articles">

    <form action="" method="post" enctype="multipart/form-data">
    
        <p>Titre de votre article:</p>
        <input type="text" name="titre" >
        <p>Image de référence:</p>
        <input type="file" name="fichier" >
        <table>

            <tr>
                <td>Jeu concerné</td>
                <td>console</td>
                <td>Genre</td>
                <td>Type d'article</td>
                <td>A la une?</td>
            </tr>
            <tr>
                <td>
                    <select name="jeu" >
                    <!-- boucle for pour créer mes options dynamiquement -->
                    <?php
                        for($i = 0; $i < count($listeJeu); $i++){
                        ?>
                            <option value="<?= $listeJeu[$i]["nom"] ?>"><?= $listeJeu[$i]["nom"] ?></option>
                        <?php
                        }
                    ?>
                    </select>
                </td>

                <td>
                    <select name="console" >
                    <!-- boucle for pour créer mes options dynamiquement -->
                    <?php
                        for($i = 0; $i < count($listeHard); $i++){
                        ?>
                            <option value="<?= $listeHard[$i][1] ?>"><?= $listeHard[$i][1] ?></option>
                        <?php
                        }
                    ?>
                    </select>
                </td>

                <td>
                    <select name="genre" >
                    <!-- boucle for pour créer mes options dynamiquement -->
                    <?php
                        for($i = 0; $i < count($listeGenre); $i++){
                        ?>
                            <option value="<?= $listeGenre[$i][1] ?>"><?= $listeGenre[$i][1] ?></option>
                        <?php
                        }
                    ?>
                    </select>
                </td>
                <td>
                    <select name="typeArticle" >
                    <!-- boucle for pour créer mes options dynamiquement -->
                    <?php
                        for($i = 0; $i < count($listeTypeArticle); $i++){
                        ?>
                            <option value="<?= $listeTypeArticle[$i] ?>"><?= $listeTypeArticle[$i] ?></option>
                        <?php
                        }
                    ?>
                    </select>
                </td>
                <td><input type="checkbox" name="star"></td>
            </tr>
        </table>
        <p>Composer votre article</p>
        <textarea name="contenu" id="contenu" ></textarea>
        <input class="btnTampon" type="submit" value="Envoyez votre article">
    </form>
</section>


<!-- Ajout du script tinymce et activer options -->
<script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'autolink lists image imagetools media table',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
</script>
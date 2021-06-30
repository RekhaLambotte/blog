<?php

// LAST ARTICLES
// récupérer les données de la dbb 
$lastArticles = lastArticle();
//var_dump($lastArticles[0]["titre"]);

?>

    <div class="listArticle">
        <h2> Nos Derniers Articles ...</h2>
    
        <?php 
            // boucle pour afficher les derniers articles
            for($i=0 ; $i< count($lastArticles); $i++):
        ?>
            <div>
                <img src=<?=$lastArticles[$i]["imgUrl"] ?>  style="width: 100%" alt="">
                <h2 style="color: white"><a href="#"><?=$lastArticles[$i]["titre"] ?></a></h2>
            </div>

        <?php
            endfor;
        ?>
    </div>

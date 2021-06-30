
<?php

require "./src/fonctions/articlesDbFonctions.php";

$articlesOnTop = getTop();
//var_dump ($articlesOnTop);
    

?>
<section id="moreNews">
    <div class="moreNews">
        <h2 class="mb-2 ml-9 mt-3">Plus de news...</h2>
        
        <?php
        // require "./src/common/indexInclude/test.php";
        require "./src/common/indexInclude/articleOnTop.php";

        ?>
    </div>
    <div class="lastarticle">
        <?php require "./src/pages/articleIncludes/listeDerniersArticles.php"; ?>
    </div>
</section>


<style>
    #moreNews{
        display:flex;
    }
    .lastarticle{
        width: 20%;
    }
    img{
        height: 100px;
        width: 50px;
    }
</style>
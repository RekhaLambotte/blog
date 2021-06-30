<?php
//require "./src/fonctions/articlesDbFonctions.php";

$articlesOnTop = getTop();
//var_dump ($articlesOnTop);
 

?>
    

        <?php 
            // boucle pour afficher les derniers articles
            for($i=0 ; $i< count($articlesOnTop); $i++):
        ?>
            <div class="cardNews moreNews-row-item">
                <img src=<?php echo $articlesOnTop[$i]["imgUrl"] ?>  style="width: 100%" alt="">
                <h2 style="color: white"><a href="#"><?=$articlesOnTop[$i]["titre"] ?></a></h2>
            </div>

        <?php
            endfor;
        ?>
    
    
        

<?php

//Appeler les fichier dont j'ai beosin
require "./src/fonctions/dbAccess.php";
require "./src/fonctions/newsDbFonctions.php";



// appel de la fonction pour récupérer les 3 derniers article star
$listOnTop = getArticleOnTop();
for($i=0; $i<3; $i++){
    $vId[$i] = intval($listOnTop[$i]["articleId"]);
    $vTitre[$i] = $listOnTop[$i]["titre"];
    $vUrl[$i] = $listOnTop[$i]["imgUrl"];
    $vCategorie[$i] = $listOnTop[$i]["nomCategorie"];
}

?>

<section id="news">
    <h2 class="mb-2 ml-9">dernières news....</h2>
    <div class="contenuNews">
        <div class="vignette v1" style ="background: url(<?= $vUrl[0]?>) center center/cover">
            <a href="../../src/common/pageArticle.php?id=<?= $vId[0]?>" >
            <p class="newsCategorie ml-2"><?= $vCategorie[0]?></p>
            <h2 class="ml-2 mb-2 newsTitre"><?= $vTitre[0]?></h2>
            </a>
        </div>
        <div class="miniVignette"> 
            <div class="vignette v2" style ="background: url(<?= $vUrl[1]?>) center center/cover" >
                <a href="../../src/common/pageArticle.php?id=<?= $vId[1]?>" >
                <p class="newsCategorie ml-2"><?= $vCategorie[1]?></p>
                <h2 class="ml-2 mb-2 newsTitre"><?= $vTitre[1]?></h2>
                </a>
            </div>
            <div class="vignette v3" style ="background: url(<?= $vUrl[2]?>) center center/cover">
                <a href="../../src/common/pageArticle.php?id=<?= $vId[2]?>" >
                <p class="newsCategorie ml-2"><?= $vCategorie[2]?></p>
                <h2 class="ml-2 mb-2 newsTitre"><?= $vTitre[2]?></h2>
                </a>
            </div>
        </div>
    </div>
</section>
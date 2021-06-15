<?php
if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
    if(isset($_POST["typeGame"]) && !empty($_POST["typeGame"])){
        $typeGame = htmlspecialchars($_POST["typeGame"]);
        addTypeGameCategorie($typeGame);
    }

    if(isset($_GET["deleteTypeGame"]) && $_GET["deleteTypeGame"] == true ){
        $categorieGameId = htmlspecialchars($_GET["valueTypeGame"]);
        $intcategorieGameId = intval($categorieGameId);
        deleteTypeGameCategorie($intcategorieGameId);
    }

}
$listegamecategorie = getGameCategory();

?>


<table class="mlr-a mt-3 p-1" id="typeGame">
    <thead>
        <tr>
            <th colspan="2"> liste des types des jeux</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nom de la catégorie </td>
            <td>Supprimer</td>
        </tr>

        <?php
            foreach($listegamecategorie as $value): 
        ?>
            <tr> 
                <td> <?= $value["genre"]?> </td>
                <td class="ta-c tc-r"> <a href=" ../../src/pages/admin.php?choix=listeCategorie&deleteTypeGame=true&valueTypeGame=<?=$value["gameCategoryId"]?> "> <i class="far fa-plus-square">  </i> </a> </td>
            </tr>
        <?php   
            endforeach;
        ?>

        <tr>
            <td>Ajouter un type de game</td>
            <td class="ta-c tc-g"> <a href="../../src/pages/admin.php?choix=listeCategorie&createTypeGame=true/#typeGame"><i class="far fa-plus-square"> </i> </a> </td>
        </tr>
        
        <?php   
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin" ){
                if(isset($_GET["createTypeGame"]) && $_GET["createTypeGame"] == true ){
        ?>
            <form action="" method="post">
                    <tr> 
                        <td> Nom du type d'article à ajouter</td>
                        <td class="ta-c tc-g "> <input type="text " name="typeGame" placeholder="Entrez le nom du type d'article"> </td>
                        <td> <input type="submit" value="Ajouter votre type d'article"></td>
                    </tr>
            </form>

        <?php

                }
            }
        ?>

    </tbody>

</table>
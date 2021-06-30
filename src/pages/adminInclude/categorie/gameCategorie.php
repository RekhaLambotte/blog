<div>

    <?php 
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
        if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
            // GERE LES DELETE DE LA TABLE HARDWARE
            if(isset($_GET["deleteGameCat"]) && $_GET["deleteGameCat"] == true):
                $gameCat = $_GET["value"];
                deleteGameCategorie($gameCat);
            endif;
            // AJOUTER UNE CONSOLE
            if(isset($_POST["gameCat"]) && !empty($_POST["gameCat"])):
                $gameCat = $_POST["gameCat"];
                addGameCategorie($gameCat);
            endif;
    }
            // Je lance ma fonction pour récupèrer les catégories existantes
            $listeCatégorie = getGameCategorie();
        ?>  
    
        <table class="mlr-a mt-3 p-1">
            <thead>
                <tr>
                    <th  class="p-1" colspan="2" style="text-align: center">Liste des Types de jeux</th>
                </tr>
            </thead>
            <tbody>
                <tr class=>
                    <td>Nom de la catégorie</td>
                    <td>Supprimer</td>
                </tr>
                <!-- Parcourir le tableau et afficher les donnée dans un table-->
        <?php
            foreach($listeCatégorie as $value):
        ?>
                <tr>
                    <td><?=$value?></td>
                    <td class="ta-c tc-r"><a href="../../src/pages/admin?choix=listeCategorie&deleteGameCat=true&value=<?=$value?>"><i class="far fa-trash-alt"></i></a></td>
                </tr>
        <?php endforeach?> 
                <tr>
                    <td>Ajouter un genre</td>
                    <td class="ta-c tc-g"><a href="../../src/pages/admin?choix=listeCategorie&createGameCat=true"><i class="far fa-plus-square"></i></a></td>
                </tr>
        <?php
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                // AJOUTER UNE CONSOLE
                if(isset($_GET["createGameCat"]) && $_GET["createGameCat"] == true):
            ?>
                <form action="" method="POST">
                    <tr>
                        <td>Nom du genre à ajouter:</td>
                        <td class="ta-c tc-g"><input type="text" name="gameCat" placeholder="Entrez le nom du genre"></i></td>
                        <td><input type="submit" value="Ajouter genre"></td>
                    </tr>
                </form>
            <?php
            endif;
    }
        ?>
            </tbody>
        </table>
</div>
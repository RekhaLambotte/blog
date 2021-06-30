<div>
    <?php 
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
        if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
            // GERE LES DELETE DE LA TABLE HARDWARE
            if(isset($_GET["deleteType"]) && $_GET["deleteType"] == true):
                $console = $_GET["value"];
                deleteTypeCategorie($console);
            endif;
            // AJOUTER UNE CONSOLE
            if(isset($_POST["type"]) && !empty($_POST["type"])):
                $console = $_POST["type"];
                addTypeCategorie($console);
            endif;
    }
            // Je lance ma fonction pour récupèrer les catégories existantes
            $listeTypeCatégorie = getCategorie();
        ?>  
    
        <table class="mlr-a mt-3 p-1">
            <thead>
                <tr>
                    <th  class="p-1" colspan="2" style="text-align: center">Liste des types d'articles</th>
                </tr>
            </thead>
            <tbody>
                <tr class=>
                    <td>Nom de la catégorie</td>
                    <td>Supprimer</td>
                </tr>
                <!-- Parcourir le tableau et afficher les donnée dans un table-->
        <?php
            foreach($listeTypeCatégorie as $value):
        ?>
                <tr>
                    <td><?=$value?></td>
                    <td class="ta-c tc-r"><a href="../../src/pages/admin?choix=listeCategorie&deleteType=true&value=<?=$value?>"><i class="far fa-trash-alt"></i></a></td>
                </tr>
        <?php endforeach?> 
                <tr>
                    <td>Ajouter une type</td>
                    <td class="ta-c tc-g"><a href="../../src/pages/admin?choix=listeCategorie&createType=true"><i class="far fa-plus-square"></i></a></td>
                </tr>
        <?php
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                // AJOUTER UNE CONSOLE
                if(isset($_GET["createType"]) && $_GET["createType"] == true):
            ?>
                <form action="" method="POST">
                    <tr>
                        <td>Nom du type à ajouter:</td>
                        <td class="ta-c tc-g"><input type="text" name="type" placeholder="Entrez le nom du type"></i></td>
                        <td><input type="submit" value="Ajouter un type de catégorie"></td>
                    </tr>
                </form>
            <?php
            endif;
    }
        ?>
            </tbody>
        </table>
</div>
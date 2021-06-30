<div>

    <?php 
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
        if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
            // GERE LES DELETE DE LA TABLE HARDWARE
            if(isset($_GET["delete"]) && $_GET["delete"] == true):
                $console = $_GET["value"];
                deleteHardCategorie($console);
            endif;
            // AJOUTER UNE CONSOLE
            if(isset($_POST["hardware"]) && !empty($_POST["hardware"])):
                $console = $_POST["hardware"];
                addHardCategorie($console);
            endif;
    }
            // Je lance ma fonction pour récupèrer les catégories existantes
            $listeCatégorie = getHardCategorie();
        ?>  
    
        <table class="mlr-a mt-3 p-1">
            <thead>
                <tr>
                    <th  class="p-1" colspan="2" style="text-align: center">Liste des Hardware</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nom de la catégorie</td>
                    <td>Supprimer</td>
                </tr>
                <!-- Parcourir le tableau et afficher les donnée dans un table-->
        <?php
            foreach($listeCatégorie as $value):
        ?>
                <tr>
                    <td><?=$value?></td>
                    <td class="ta-c tc-r"><a href="../../src/pages/admin?choix=listeCategorie&delete=true&value=<?=$value?>"><i class="far fa-trash-alt"></i></a></td>
                </tr>
        <?php endforeach?> 
                <tr>
                    <td>Ajouter une console</td>
                    <td class="ta-c tc-g"><a href="../../src/pages/admin?choix=listeCategorie&create=true"><i class="far fa-plus-square"></i></a></td>
                </tr>
        <?php
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
                // AJOUTER UNE CONSOLE
                if(isset($_GET["create"]) && $_GET["create"] == true):
            ?>
                <form action="" method="POST">
                    <tr>
                        <td>Nom du hardware à ajouter:</td>
                        <td class="ta-c tc-g"><input type="text" name="hardware" placeholder="Entrez le nom du Hard"></i></td>
                        <td><input type="submit" value="Ajouter Hardware"></td>
                    </tr>
                </form>
            <?php
            endif;
    }
        ?>
            </tbody>
        </table>
</div>

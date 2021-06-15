<?php 

    if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
        if(isset($_POST["hardware"]) && !empty($_POST["hardware"])){
            $console = htmlspecialchars($_POST["hardware"]);
            addHardCategorie($console);
        }

        // effacer une console

        if(isset($_GET["delete"]) && $_GET["delete"] == true ){
            $hardId = htmlspecialchars($_GET["value"]);
            $intHardId = intval($hardId);
            deleteHardCategorie($intHardId);

        }
    }

    // récupere la liste des catégories 
    $listeCategorie =getHardCategorie();
    // print_r($listeCategorie);

?>

<table class="mlr-a mt-3 p-1">
    <thead>
        <tr>
            <th colspan="2"> liste des Hardwares</th>
        </tr>
    </thead>
    <tbdody>
        <tr>
            <td>Nom de la catégorie </td>
            <td>Supprimer</td>
        </tr>
        <?php
            foreach($listeCategorie as $value): 
        ?>
            <tr> 
                <td><?= $value["console"]?> </td>
                <td class="ta-c tc-r"> <a href="../../src/pages/admin.php?choix=listeCategorie&delete=true&value=<?=$value["hardId"]?>"> <i class="far fa-plus-square"> </i> </a> </td>
            </tr>

        <?php   
            endforeach;
        ?>

        <tr>
            <td>Ajouter un hardware</td>
            <td class="ta-c tc-g"> <a href="../../src/pages/admin.php?choix=listeCategorie&create=true"><i class="far fa-plus-square"> </i> </a> </td>
        </tr>

        <?php   
            if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin" ){
                if(isset($_GET["create"]) && $_GET["create"] == true ){
        ?>
            <form action="" method="post">
                    <tr> 
                        <td> Nom du hardware à ajouter</td>
                        <td class="ta-c tc-g "> <input type="text " name="hardware" placeholder="Entrez le nom du hard"> </td>
                        <td> <input type="submit" value="Ajouter hardware"></td>
                    </tr>
            </form>

        <?php

                }
            }
        ?>
    </tbdody>

</table>
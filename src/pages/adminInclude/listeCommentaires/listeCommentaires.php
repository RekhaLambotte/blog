<?php
if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
    $listeCommentaires = getListCommentaires();
    // var_dump($listeCommentaires)
    // EFFACER UN commentaire
    if(isset($_GET["choix"]) && (isset($_GET["delete"]) && ($_GET["delete"] == true)) && isset($_GET["value"])){
        // Je converti mon get Value en entier
        $user = intval($_GET["value"]);
        deleteUser($user);
    }
}
?>
<h2>Liste des commentaires </h2>

<table>
    <thead>
        <tr>
            <th> N° Commentaire</th>
            <th> article </th>
            <th> auteur </th>
            <th> pseudo </th>
            <th> date </th>
            <th> contenu </th>
        </tr>
    </thead>
    <tbody>
    <?php
    for($i=0 ; $i < count($listeCommentaires); $i++):
    ?>
        <tr>
            <td> <?= $listeCommentaires[$i]["comId"] ?> </td>
            <td> <?= $listeCommentaires[$i]["titre"] ?> </td>
            <td> <?php 
                if($listeCommentaires[$i]["auteur"]==0){
                    $comPseudo = "non inscrit";
                }else{
                    $comPseudo = $listeCommentaires[$i]["auteurLog"];
                }
                echo $comPseudo;
                 
                ?> </td>
                
            <td> <?= $listeCommentaires[$i]["comPseudo"] ?> </td>
            <td> <?= $listeCommentaires[$i]["comDate"] ?> </td>
            <td> <?= $listeCommentaires[$i]["contenu"] ?> </td>
            <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeCommentaire&delete=true&value=<?=$listeCommentaires[$i]["comId"]?>"><i class="far fa-trash-alt"></i></a></td>
            
        </tr>
    <?php
    endfor
    ?>
    </tbody>
    
</table>

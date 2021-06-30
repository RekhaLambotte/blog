<?php
$listeArticles = getListArticle();
?>

<h2> Liste des Articles</h2>

<table>
    <thead>
        <tr>
            <th> N° de l'article</th>
            <th> Titre </th>
        </tr>
    </thead>
    <tbody>
    <?php
    for($i=0 ; $i < count($listeArticles); $i++):
    ?>
        <tr>
            <td> <?= $listeArticles[$i]["articleId"] ?> </td>
            <td> <?= $listeArticles[$i]["titre"] ?> </td>    
        </tr>
    <?php
    endfor;
    ?>
    </tbody>
    
</table>
<?php
if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
$listeUsers = getListUsers();
//var_dump ($listeUsers);
// EFFACER UN USER
    if(isset($_GET["choix"]) && (isset($_GET["delete"]) && ($_GET["delete"] == true)) && isset($_GET["value"])){
        // Je converti mon get Value en entier
        $user = intval($_GET["value"]);
        deleteUser($user);
    }
}
?>
<h2>Liste des users</h2>


<table>
    <thead>
        <tr>
            <th> Image Avatar</th>
            <th> Login</th>
            <th> Nom</th>
            <th> Prénom</th>
            <th> Email</th>
        </tr>
    </thead>
    <tbody>
        <?php
            for ($i=0; $i<count($listeUsers); $i++):
        ?>
            <tr>
                <td> <img src="<?= $listeUsers[$i]["avatar"] ?>" class="img-avatar" alt=""> </td>
                <td> <?= $listeUsers[$i]["login"] ?> </td>
                <td> <?= $listeUsers[$i]["nom"] ?> </td>
                <td> <?= $listeUsers[$i]["prenom"] ?> </td>
                <td> <?= $listeUsers[$i]["email"] ?> </td>
                <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeUsers&delete=true&value=<?=$listeUsers[$i]["userId"]?>"><i class="far fa-trash-alt"></i></a></td>
            </tr>
        <?php
            endfor;
        ?>
    </tbody>
</table>
    


<style>
    .img-avatar{
    max-height: 50px;
}
</style>
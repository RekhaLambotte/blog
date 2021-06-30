<?php
    $titre = "enregistrez-vous";
    require "../../src/common/template.php";
    $mdpNok = false;
    require "../../src/fonctions/dbAccess.php";
    require "../../src/fonctions/dbFonction.php";
    require '../../src/fonctions/mesFonctions.php';
    $titre = "Connectez-vous";

    // Si mon user est connecté, je le renvoie sur la page d'acceuil
    estConnecté();

    // Si le formulaire est envoyé, je lance la fonction login pour connecter mon user
    if(isset($_POST["login"]) && isset($_POST["password"])):
        $login = htmlspecialchars($_POST["login"]);
        $password = htmlspecialchars($_POST["password"]);

        login($login, $password);
     
    else:
?>

<section class="register">
    <form action="" method="post" class="login">
        <table>
            <?php
            if(isset($_GET["erreur"])):
            ?>
            <h2><?= $_GET["erreur"] ?></h2>
            <?php endif; ?>
                <thead>
                    <tr>
                        <th colspan="2">Connectez-vous</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Login</td>
                        <td><input type="text" name="login" required placeholder="Entrez votre login"></td>
                    </tr>
                    <tr>
                        <td>Mot de passe:</td>
                        <td><input type="password" name="password" required placeholder="Entrez votre mot de passe"></td>
                    </tr>
                    <tr>
                       <td><input type="submit" value="Se connecter"></tr></td>
                </tbody>
        </table>
    </form>
</section>

<?php 
    endif; 
    require "../../src/common/footer.php";
?>
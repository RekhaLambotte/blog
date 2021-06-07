<?php
    $titre = "Enregistrez-vous";
    require "../../src/common/template.php";
    require "../../src/fonctions/mesFonctions.php";
    require "../../src/fonctions/dbFonctions.php";

    // si mon user est connécté , je le renvois sur la page d'acceuil grace a ma fonction 
    estConnecte();

    // définir la variable qui marquera si le mdp est correcte ou pas
    (isset($_SESSION["mdpNok"]) && $_SESSION["mdpNok"] == true) ? $mdpNok = $_SESSION["mdpNok"] : $mdpNok = false;
?>

<?php 
    // vérifier si tous les champs sont encodé
    if(isset($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"])  ) {



         // Si l'avatar du user est vide, j'utiliserai l'avatar par défaut
         $photo = "../../src/img/site/defaut_avatar.png";


         // Sanitiser les données des input
         // je contruit un tableau pour récupérer les données
         $option = array(
             "nom"  => FILTER_SANITIZE_STRING,
             "prenom"  => FILTER_SANITIZE_STRING,
             "login"  => FILTER_SANITIZE_STRING,
             "email"  => FILTER_SANITIZE_EMAIL,
             "mdp"  => FILTER_SANITIZE_STRING,
             "mdp2"  => FILTER_SANITIZE_STRING
         );

         // créer une variable résulte qui va prendre les valeurs saines
         $result = filter_input_array(INPUT_POST, $option);

         $prenom = $result["prenom"];
         $nom = $result["nom"];
         $login = $result["login"];
         $email = $result["email"];
         $mdp = $result["mdp"];
         $mdp2 = $result["mdp2"];
         $role = 4;

         // vérifier si les mot de passe sont identique

         if($mdp == $mdp2){
             //hash du mot de passe . md5 est une fonction php qui hash
             $mdpHash = md5($mdp);

             // appeler la fonction du grain de sel
             $sel = grainDeSel(rand(5,20));

             // mot de passe a envoyer
             $mdrpToSend = $mdpHash.$sel;

             // faire repasser le mdpNok à l'inverse puisque les mot de passe sotn identique
             $mdpNok = false;

         }else{
             // sinon on va faire des controles

             // boolean de contrôle
             $mdpNok = true;

             //j'active une session pour indiquer que le mdr sont noOk lors du prochain chargement de la page
             $_SESSION["mdpNok"] = true;

             // Je recharge la page
             header("location: ../../src/pages/register.php");
             exit();

         }

         // Vérifier si le user ou le login n'est pas présent ma db
         $bdd = new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8","root","root");

         // vérification du login
         $requete = $dbb->prepare("SELECT COUNT(*) AS x
                                    FROM users 
                                    WHERE login = ?");
        $requete->execute(array($login));

        // vérifier si le résultat de x est différent de 0
        while($result = $requete->fetch()){
            if($result["x"] !=0){
                $_SESSION["msgLogin"] = true;
                header("location: ../../src/pages/register.php");
                exit();
            }
        }

        // Vérification du email
        $requete = $dbb->prepare("SELECT COUNT(*) AS x
                                    FROM users 
                                    WHERE email = ?");
        $requete->execute(array($login));

        // vérifier si le résultat de x est différent de 0
        while($result = $requete->fetch()){
            if($result["x"] !=0){
                $_SESSION["msgEmail"] = true;
                header("location: ../../src/pages/register.php");
                exit();
            }
        }

        // vérifeir si l'utilisateur a envoyé une photo et agir en conséquence 
        if(isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == 0){
            $photo = sendImg($_FILES["fichier"], "avatar");
        }

        // Medonnée sont correctes et saines , je peux créer mon user en respectant l'ordre des argument de la fonction createUser $avatar, $prenom, $nom, $login, $email, $mdp, $roleId, $ban
        createUser($photo, $prenom, $nom, $login, $email, $mdrpToSend, $roleId, $sel)

        // Tout s'est bien passé, l'user est invité à se connecter
?>
<h2> Votre compte est maintenant vérifier, vous pouvez vous <a href="../../src/pages/login.php"> CONNECTER</a></h2>

<?php

    } 
    // si tous les champs ne sont pas encodé ou qu'il y aeu un soucis
    else {

?>


<section class="register">
    <form action="" method="post" class="login" enctype="multipart/form-data">
        <?php

            // Si les boolean de check mail es true, afficher l'information pour inviter à se connecter 
            if(isset($_SESSION["msgEmail"]) && $_SESSION["msgEmail"] == true){
                echo " <h2> Email déjà existant, merci de vous connecter </h2>";
                $_SESSION["msgEmail"] = false
            }
            // Si les boolean de check login es true, afficher l'information pour inviter à se connecter 
            if(isset($_SESSION["msgLogin"]) && $_SESSION["msgLogin"] == true){
                echo " <h2> Email déjà existant, merci de vous connecter </h2>";
                $_SESSION["msgLogin"] = false
            }
        ?>
        <Table>
            <thead>
                <tr> 
                   <th class="">Créer votre compte</th>    
                </tr>
            </thead>

            <tbody>
                <tr> 
                    <td> Prénom : </td>
                    <td><input type="text" name="prenom" required placeholder="Prénom"></td>
                </tr>
                <tr> 
                    <td> Nom : </td>
                    <td><input type="text" name="nom" required placeholder="Nom"></td>
                </tr>
                <tr> 
                    <td> Login : </td>
                    <td><input type="text" name="login" required placeholder="Login"></td>
                </tr>
                <tr> 
                    <td> Email : </td>
                    <td><input type="email" name="email" required placeholder="Entrez votre email"></td>
                </tr>
                <tr> 
                    <td> Mot de passe : </td>
                    <td><input type="password" name="mdp" required placeholder="Entrez votre mot de passe" <?php if($mdpNok == true){?> class="danger" placeholder="Le mot de passe n'est pas identique" <?php } ?>></td>
                </tr>
                <tr> 
                    <td> Mot de passe, vérification : </td>
                    <td><input type="password" name="mdp2" required placeholder="Entrez à nouveau votre mot de passe" <?php if($mdpNok == true){?> class="danger" placeholder="Le mot de passe n'est pas identique" <?php } ?> ></td>
                </tr>
                <tr> 
                    <td> Envoyer votre fichier </td>
                    <td><input type="file" name="fichier" ></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Créer votre compte" ></td>
                </tr>
            </tbody>
        </Table>
    </form>
</section>

<?php

    }

?>


<?php 
    require "../../src/common/footer.php";
?>

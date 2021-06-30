<?php
    $titre = "enregistrez-vous";
    require "../../src/common/template.php";
    $mdpNok = false;
    require '../../src/fonctions/dbAccess.php';
    require "../../src/fonctions/dbFonction.php";
    require '../../src/fonctions/mesFonctions.php';

    // Si mon user est connecté, je le renvoie sur la page d'acceuil
    estConnecté();

    // Définition de la variable qui va border en rouge les input 
    // password si ceux envoyée par le user ne correspondent pas
    (isset($_SESSION["mdpNok"]) && $_SESSION["mdpNok"] == true) ? $mdpNok = $_SESSION["mdpNok"] : $mdpNok = false;
    ?>

<?php
    // Traitement du formulaire, je teste surtout si les input envoyé obligatoirement sont présent
    if(isset($_POST["nom"]) && !empty($_POST["nom"]) && 
        !empty($_POST["prenom"]) && !empty($_POST["login"]) 
        && !empty($_POST["email"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"])):
        // Si le user n'entre pas de photo, je crée une variable qui recoit l'image par défaut de l'avatar
         $photo = "../../src/img/site/defaut_avatar.png";

        //Filter sanitize sur mes entrées
        // Je constuit un tableau avec les données sensibles envoyées
        $options = array(
            'nom' 	    => FILTER_SANITIZE_STRING,
            'prenom' 	=> FILTER_SANITIZE_STRING,
            'login' 	=> FILTER_SANITIZE_STRING,
            'email' 	=> FILTER_VALIDATE_EMAIL,
            'mdp' 	    => FILTER_SANITIZE_STRING,
            'mdp2' 	    => FILTER_SANITIZE_STRING,);

        // Je crée une variable $result qui contiendra un tableau avec les input sanétisé
        $result = filter_input_array(INPUT_POST, $options);  

        // Je redistribue les données saines dans les variables adéquates
        $nom = $result["nom"];
        $prenom = $result["prenom"];
        $login = $result["login"];
        $email = $result["email"];
        $mdp = $result["mdp"];
        $mdp2 = $result["mdp2"];
        $role = 4;
        //$vKey = $_POST["e"];
        $verified = 0;

        //    Vérfier si mot de passe son identique
        if($mdp == $mdp2){
            // hasher mot de passe
            $mdpHash = md5($mdp);
            //générer grain de sel
            $roleId = grainDeSel(rand(5,20));
            // Variable mdp à envoyer dans la db
            $mdpToSend = $mdpHash . $roleId;
            $mdpNok = false;
        } else {
            // boolean de contrôle sur true
            $mdpNok = true;
            // Active la session
            $_SESSION["mdpNok"] = true;
            // recharge la page avec les informations de session mise à jour
            header("location: ../../src/pages/register.php");
            exit();
        }
        // Verifier si le user ou le mail n'est pas présent dans la db
        $bdd = new PDO("mysql:host=localhost;dbname=blog_gaming;charset=utf8", "root", "");
        // Verifier le login (CHECKLOGIN)
        $requete = $bdd->prepare("SELECT COUNT(*) AS x
                                    FROM users
                                    WHERE login = ?");
        $requete->execute(array($login));
        while($result = $requete->fetch()){
            if($result["x"] != 0){
                $_SESSION["msgLogin"] = true;
                header("location: ../../src/pages/register.php");
                exit();
            }
        }
        // Verifier l'email (CHECKMAIL)
        $requete = $bdd->prepare("SELECT COUNT(*) AS x
                                    FROM users
                                    WHERE email = ?");
            $requete->execute(array($email));
            while($result = $requete->fetch()){
                if($result["x"] != 0){
                $_SESSION["msgEmail"] = true;
                header("location: ../../src/pages/register.php");
                exit();
            }
        }
        // Verifier si photo reçue et envoyer
        if(isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == 0){
            $photo = sendImg($_FILES["fichier"], "avatar");
        }
        // echo $photo;
        //Générer une varificationKey
        $verification = md5(time().$login);
        echo $verification;
        //Mes données sont saines, je peux les envoyer dans la db
        $insert = createUser($photo, $login, $nom, $prenom, $email, $mdpToSend, $role, $roleId, $verification, $verified);
        // ENVOYER EMAIL
        // si $insert existe alors...
        if($insert){
            $to = $email;
            $subject = "Email de vérification";
            $message = "<a href='http://192.168.64.2/src/pages/register.php?verification=$verification'> Valider la vérification</a>";
            $headers = "From: verification@test.com" ;
            $headers .= "Content-type:text/html;charset=UTF-8";
            mail($to, $subject, $message, $headers);
            header('location: ../../src/pages/login.php');
        }

?>
        <!-- Si tout c'est bien passé, informer et proposer de se connecter -->
        <img src=<?= $photo?> alt="">
        <h2 class="registerOk">Votre compte est maintenant créé, vous pouvez vous <a href="../../src/pages/login.php"> CONNECTER</a></h2>
<?php
    else:
?>
<section class="register">
    <!--Formulaire d'enregistrement -->
    <form method="post" action="" class="login" enctype="multipart/form-data">
        <?php    
        // Si les boolean de checkmail est true, afficher information pour inviter à connecter
        if(isset($_SESSION["msgEmail"]) && $_SESSION["msgEmail"] == true){
            echo "<h2>Cet email possède déjà un compte, veuillez vous connecter'.</h2>";
            $_SESSION["msgEmail"] = false;
        }
        // Si les boolean de checklogin est true, afficher information pour inviter à connecter
        if(isset($_SESSION["msgLogin"]) && $_SESSION["msgLogin"] == true){
            echo "<h2>Le login est déjà pris par un autre utilisateur, veuillez en choisir un autre.</h2>";
            $_SESSION["msgLogin"] = false;
        }
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Créez votre compte</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Prénom:</td>
                    <td><input type="text" name="prenom" required placeholder="Entrez votre Prénom"></td>
                </tr>
                <tr>
                    <td>Nom:</td>
                    <td><input type="text" name="nom" required placeholder="Entrez votre nom"></td>
                </tr>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" required placeholder="Entrez votre login"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" required placeholder="nom@email.fr"> </td>
                </tr>
                <tr>
                    <td>mot de passe:</td>
                    <td><input type="password" name="mdp" required placeholder="Mot de passe" <?php if($mdpNok == true){ ?> class="danger" placeholder="mot de passe n'est pas identique"<?php } ?> ></td>
                </tr>
                <tr>
                    <td>mot de passe:</td>
                    <td><input type="password" name="mdp2" required placeholder="Répéter mot de passe" <?php if($mdpNok == true){ ?> class="danger" placeholder="mot de passe n'est pas identique"<?php } ?>></td>
                </tr>
                <tr>
                    <td>Uploadez votre avatar:</td>
                    <td><input type="file" name="fichier"></td>
                </tr>
                <tr>
                    <td><input class="sphere-animated" type="submit" value="Créer Votre Compte"></td>
                </tr>
            </tbody>
        </table>
    </form>

</section>
<?php
    // Je termine le if de vérification des input user
    endif;
    // Je réinitialise le boolean mdoNok
    $_SESSION["mdpNok"] = false;
    require "../../src/common/footer.php";
?>
<?php
function commentForm(){
    if(isset($_SESSION["user"])){
        $autor = $_SESSION["user"]["id"];
        $name = $_SESSION["user"]["login"];
    }else{
        $autor = 0;
        $name = "Inconnu";
    }

    $articleId = $_GET["id"];
    $autorId = $autor;
    $pseudo = $name;
    $date = date("Y-m-d H:i:s"); 
    $contenu = $_POST["comment"];
    addCommentaire($articleId, $autorId, $pseudo, $date, $contenu );
    // echo "Commentaire envoyé";
?>

<div>
    <h2> Commentaire envoyé</h2>
</div>

<?php } ?>
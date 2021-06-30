<?php

function getListUsers () {
    $dbb = dbAccess();
    $requete = $dbb->query("SELECT * 
                            FROM users ");
    while($donnees = $requete->fetch()){
        $listeUsers[] = $donnees;
    }
    $requete->closeCursor();
    return $listeUsers;
}
function deleteUser($user){
    $bdd = dbAccess();
    $requete = $bdd->prepare("DELETE FROM users WHERE userId = ?");
    $requete->execute(array($user))or die(print_r($requete->errorInfo(), TRUE));;
    $requete->closeCursor();
}

?>
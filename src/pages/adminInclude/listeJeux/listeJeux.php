<h2>Liste des jeux</h2>

<div>

    <?php 
            // Je conditionne l'accès à ces requête uniquement si l'utilsateur est admin
        if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
            // SI JE VEUX AJOUTER UN JEU
            if(isset($_POST["nomJeu"]) && isset($_POST["developpeur"]) && isset($_POST["editeur"]) && isset($_POST["release"])
             && isset($_POST["cover"]) && isset($_POST["console"]) && isset($_POST["genre"])):
            
                //  Encapsule dans variable
                $jeux = $_POST["nomJeu"];
                $console = $_POST["console"];
                $genre = $_POST["genre"];
                $dev = $_POST["developpeur"];
                $edit = $_POST["editeur"];
                $release = $_POST["release"];
                $cover = $_POST["cover"];

                addGame($jeux, $console, $genre, $dev, $edit, $release, $cover);
            endif;

            // EFFACER UN JEU
            if(isset($_GET["choix"]) && (isset($_GET["delete"]) && ($_GET["delete"] == true)) && isset($_GET["value"])){
                // Je converti mon get Value en entier
                $gameId = intval($_GET["value"]);
                deleteGame($_GET["value"]);
            }

    }
            // Je lance ma fonction pour récupèrer les catégories existantes
            $listeJeux = getListGame();
            // var_dump($listeJeux);
    ?> 
    <!-- Lien pour ajouter un jeux -->
    <h3><a href="../../src/pages/admin.php?choix=listeJeux&add=true"><i class="far fa-plus-square"></i>Ajouter Jeux</a></h3>

        <!-- coder le formulaire pour ajouter des jeux si le bouton est poussé -->
        <?php
            if((isset($_GET["choix"]) && ($_GET["choix"] == "listeJeux")) && (isset($_GET["add"])  && ($_GET["add"]) == true)){
                $console = getHard();
                $genre = getGenre();
        ?>
            <form class="login addGame" action="" method="POST">
                    <p><input type="text" name="nomJeu" placeholder="Nom du jeux" required></p>
                    <p><input type="text" name="developpeur" placeholder="Développeur" required></p>
                    <p><input type="text" name="editeur" placeholder="Editeur" required></p>
                    <p><input type="date" name="release" required></p>
                    <p><input type="text" name="cover" placeholder="adresse cover" required></p>
                    <p><select name="console" required>
                        <?php
                            foreach($console as $value):
                        ?>  
                            <option value="<?=$value[0]?>"><?=$value[1]?></option>
                        <?php
                        endforeach;
                        ?>
                    </select></p>
                    <p><select name="genre" required>
                        <?php
                            foreach($genre as $value):
                        ?>  
                            <option value="<?=$value[0]?>"><?=$value[1]?></option>
                        <?php
                            endforeach;
                        ?>
                    </select>
                    <p><input type="submit" value="Enregistrer le jeu"></p>
            </form>
        <?php
            }
        ?>
    <!-- Constuire mon tableau liste des jeux -->
    <table class="mlr-a mt-3 p-1">
        <thead>
            <tr>
                <th  class="p-1" colspan="8" style="text-align: center">Liste des Jeux</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Nom du jeux</td>
                <td>Développeur</td>
                <td>Editeur</td>
                <td>Date de sortie</td>
                <td>Cover</td>
                <td>Console</td>
                <td>Genre</td>
                <td>Supprimer</td>
            </tr>
        <!-- Générer dynamiquement les lignes après requete pour récupérer les jeux de ma db -->
        <?php
            for($i =0; $i < count($listeJeux); $i++){
        ?>
            <tr>
                <td><?=$listeJeux[$i]["nom"]?></td>
                <td><?=$listeJeux[$i]["developpeur"]?></td>
                <td><?=$listeJeux[$i]["editeur"]?></td>
                <td><?=$listeJeux[$i]["dateDeSortie"]?></td>
                <td><?=$listeJeux[$i]["cover"]?></td>
                <td><?=$listeJeux[$i]["console"]?></td>
                <td><?=$listeJeux[$i]["genre"]?></td>
                <td class="ta-c tc-r"><a href="../../src/pages/admin.php?choix=listeJeux&delete=true&value=<?=$listeJeux[$i]["id"]?>"><i class="far fa-trash-alt"></i></a></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>


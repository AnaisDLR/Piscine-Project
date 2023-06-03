<?php
include("BDDconnexion.php");
/* logique: 
    login -> avoir l'ID de l'user -> afficher le nom, l'emploi et la photo des amis 
    clic sur la photo -> page principale de l'ami
        -> liste des amis de mon ami -> clic sur la photo -> demande d'ami 
*/

//on récupère l'ID de l'user 
session_start();
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"])) {
    echo "<script>alert('Connecte toi avant');document.location.replace('login.php');</script>";
    die();
}
$userID = $_SESSION["userID"];

//on récupère l'ID de l'ami 
if ($_SERVER['REQUEST_METHOD'] != 'GET')
    die("erreur IDami");

if (!(isset($_GET['id']) && !empty($_GET["id"])))
    die("erreur IDami");

$amiID = (int) strip_tags($_GET['id']);

$sql = "SELECT * FROM utilisateur WHERE ID=$amiID";
$result = mysqli_query($db_handle, $sql);
$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- Icone onglet -->
    <link rel="shortcut icon" href="img/ecein.png" type="image/x-icon">
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="vous.css">
    <style> 
    .ami-profil {
                display: flex;
                align-items: center;
            }

    .ami-profil .details {
                display: flex;
                flex-direction: column;
            }

    .image {
    cursor: pointer;
    }
    
    </style>
    <script>
        function addFriend(id, nom) {
            alert( nom + " a été(e) ajouté(e) comme ami(e)");
        }
    </script>    

</head>

<body>
    <!-- Barre navigation -->
    <nav class="navbar navbar-expand-sm bg-dark justify-content-center">
        <a class="navbar-brand"><img src="img/ecein.png" width=20% height=20%></a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="accueil.php" style="color:white">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="reseau.php" style="color:white">Réseau</a></li>
                <li class="nav-item"><a class="nav-link" href="emplois.php" style="color:white">Offres d'emploi</a></li>
                <li class="nav-item"><a class="nav-link" href="messagerie.php" style="color:white">Messagerie</a></li>
                <li class="nav-item"><a class="nav-link" href="#" style="color:white">Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="vous.html" style="color:white">Vous</a></li>
            </ul>
        </div>
    </nav>
    <!-- Contenu -->
    <div class="row" align="center">
        <div class="col-sm-1"></div>
        <div class="col-sm-10" id="section1">
            <br>
            <div class="card">
                <div class="card-header">
                    <img src=<?= $data['PDP'] ?> width=20% height=auto><br><br>
                    <?= $data['Pseudo'] ?><br>
                    <?= "<span style='color: silver'>" . $data['Statut'] . "</span>";?><br>
                    Nom complet : <?= $data['Nom'] ?><br>
                    Emploi : <?= $data['Emploi'] ?> 
                </div>
                <div class="card-body">
                    <div class="container">
                        <table class="table table-striped">
                            <thead>
                                <tr><h3>Formations</h3></tr> 
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Intitulé</th> 
                                    <th>Durée</th> 
                                    <th>Compétences acquises</th> 
                                </tr>
                            </tbody>
                            <tbody>
                                <tr> 
                                    <td>1</td>
                                    <td>Les Misérables</td>
                                    <td>Victor Hugo</td>
                                </tr>
                                <tr> 
                                    <td>2</td>
                                    <td>Hamlet</td>
                                    <td>William Shakespeare</td> 
                                </tr>
                                <tr> 
                                    <td>3</td>
                                    <td>Don Quixote</td> 
                                    <td>Miguel de Cervantes</td> 
                                </tr>
                                <tr> 
                                    <td>4</td>
                                    <td>Anna Karenina</td> 
                                    <td>Leo Tolstoy</td> 
                                </tr>
                                <tr> 
                                    <td>5</td>
                                    <td>Moby Dick</td> 
                                    <td>Herman Melville</td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="container">
                        <table class="table table-striped">
                            <thead>
                                <tr><h3>Projets</h3></tr> 
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Intitulé</th> 
                                    <th>Durée</th> 
                                    <th>Fonction</th>
                                    <th>Lien du projet</th>
                                    <th>Description</th>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr> 
                                    <td>1</td>
                                    <td>Les Misérables</td>
                                    <td>Victor Hugo</td>
                                    <td>1</td>
                                    <td>1</td>
                                </tr>
                                <tr> 
                                    <td>2</td>
                                    <td>Hamlet</td>
                                    <td>William Shakespeare</td>
                                    <td>1</td>
                                    <td>1</td> 
                                </tr>
                                <tr> 
                                    <td>3</td>
                                    <td>Don Quixote</td> 
                                    <td>Miguel de Cervantes</td>
                                    <td>1</td>
                                    <td>1</td> 
                                </tr>
                                <tr> 
                                    <td>4</td>
                                    <td>Anna Karenina</td> 
                                    <td>Leo Tolstoy</td> 
                                    <td>1</td>
                                    <td>1</td>
                                </tr>
                                <tr> 
                                    <td>5</td>
                                    <td>Moby Dick</td> 
                                    <td>1</td>
                                    <td>1</td>
                                    <td>Herman Melville</td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div> 
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-10" id="section3">
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>Réseau</h3>
                </div>
                <div class="card-body">
                <div class="container">
                        <table class="table table-striped">
                            <tbody>
                                <?php
                                $amiami = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
                                           WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
                                           OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$amiID;";
                                $resulta = mysqli_query($db_handle, $amiami);
                    
                                 // Affichage 1
                                    while ($data = mysqli_fetch_assoc($resulta)){
                                        $PDP = $data['PDP'];
                                        echo "<tr class=\"ami-profil\">";
                                        echo "<td class=\"details\" style='width:20%'> <img src='$PDP' class=\"image\" onclick=\"addFriend($data['ID'] . ", " . $data['Nom'])\" width=100% height=auto>" . "</td>";                                    echo "<td>";
                                            echo "<h5><strong>" . $data['Nom']. "</strong></h5>";
                                            echo "<p>" . $data['Emploi'] . "</p>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
        </div>

        <script>
            
        var xhttp = new XMLHttpRequest();

        //pour recevoir la réponse
        xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.response);
        }
        };

        //on envoie la demande avec une variable
        xhttp.open("GET", "suppr_post.php?id=" + post.id, true);
        xhttp.send();


        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-10" id="section3">
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>Activité</h3>
                </div>
                <div class="card-body">
                    Content
                </div>
            </div>
            <br>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <footer class="text-center text-lg-start bg-dark text-muted" id="footer">
        Copyright &copy; 2023 ECE PARIS
    </footer>
</body>

</html>

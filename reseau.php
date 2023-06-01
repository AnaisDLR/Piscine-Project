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
?>

<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réseau</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js">
    </script>
    <script type="text/javascript">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="vous.css">

    <!-- <style>
    html,
    body {
      margin: 0;
      height: 100%;
      width: 100%;
    }

/* le nom est plus près à la PDP et l'emploi est en dessous du nom */
    .ami-profil {
                display: flex;
                align-items: center;
            }

     .ami-profil img {
                width: 100px;
                height: 100px;
                margin-right: 20px;
            }

    .ami-profil .details {
                display: flex;
                flex-direction: column;
            }
  </style> -->
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
                <li class="nav-item"><a class="nav-link" href="#" style="color:white">Messagerie</a></li>
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
                    <h3>Mes amis :</h3>
                </div>
                <div class="card-body">
                    <div class="container">
                        <table class="table table-striped">
                            <tbody>
                                <?php
                                $ami = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
                                            WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
                                            OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$userID;";
                                $resulta = mysqli_query($db_handle, $ami);

                                echo "<tr>";
                                echo "<th>" . "PDP" . "</th>";
                                echo "<th>" . "Pseudo" . "</th>";
                                echo "<th>" . "Statut" . "</th>";
                                echo "<th>" . "Emploi" . "</th>";
                                echo "</tr>";
                                while ($data = mysqli_fetch_assoc($resulta)) {
                                    echo "<tr>";
                                    $PDP = $data['PDP'];
                                    echo "<td style=\"\"> <img src='$PDP' width=20% height=auto>" . "</td>";
                                    echo "<td>" . $data['Pseudo'] . "</td>";
                                    echo "<td> " . $data['Statut'] . "</td>";
                                    echo "<td> " . $data['Emploi'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <h3>Projets</h3>
                                </tr>
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
            <br>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-10" id="section2">
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>CV</h3>
                    <a href="#" class="btn btn-primary btn-block btn-lg" role="button">Générer mon CV</a>
                </div>
            </div>
            <br>
        </div>
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
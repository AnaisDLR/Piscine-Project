<?php
include("BDDconnexion.php");

//recupération et vérification des donné de l'utilisateur
session_start();
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"])) {
    echo "<script>alert('Connecte toi avant');document.location.replace('index.php');</script>";
    die();
}
$userID = $_SESSION["userID"];

$sql = "SELECT * FROM utilisateur WHERE ID=$userID";
$result = mysqli_query($db_handle, $sql);
$selfdata = mysqli_fetch_assoc($result);

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
</head>

<body>
    <!-- Barre navigation -->
    <nav class="navbar navbar-expand-sm bg-dark justify-content-center">
        <!-- .bg-primary, .bg-success, .bg-info, .bg-warning, .bg-danger, .bg-secondary, .bg-dark and .bg-light -->
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
                <li class="nav-item"><a class="nav-link" href="vous.php" style="color:white">Vous</a></li>
            </ul>
        </div>
        <div style="border: 1px black;">
            <span style="color: #8A8C8F;">
                <?= $selfdata["Pseudo"] ?>
            </span>
            <li class="nav-item"><a class="nav-link" href="index.php"
                    style="color:white; padding: 0rem 1rem; font-size: 0.8em;">Déconnexion</a></li>
        </div>
    </nav>
    <!-- Contenu -->
    <div class="row" align="center">
        <div class="col-sm-1"></div>
        <div class="col-sm-10" id="section1">
            <br>
            <div class="card">
                <div class="card-header">
                    <img src="https://www.striol.com/wp-content/uploads/2020/07/pfp.jpg" width=20% height=20%><br>
                    Profile

                    <a href="#" class="btn btn-primary" role="button">Mes amis</a>
                    <br>
                </div>
                <div class="card-header">
                    <a href="#" class="btn btn-primary" role="button">Modifier ma photo</a>
                    <a href="#" class="btn btn-primary" role="button">Modifier mon image de fond</a>
                    <a href="#" class="btn btn-primary" role="button">Modifier mes formations</a>
                    <a href="#" class="btn btn-primary" role="button">Modifier mes projets</a>
                    <a href="#" class="btn btn-primary" role="button">Modifier mes posts</a>
                </div>
                <div class="card-body">
                    <div class="container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <h3>Formations</h3>
                                </tr>
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
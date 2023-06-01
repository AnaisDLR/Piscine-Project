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
    <title>Emplois</title>
    <!-- Icone onglet -->
    <link rel="shortcut icon" href="img/ecein.png" type="image/x-icon">
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="emplois.css">
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

    <div class="row" align="center">
        <div class="col-sm-1" id="section2"></div>
        <div class="col-sm-10" id="section2">
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>Nos offres d'emploi</h3><br>
                    <div id="card-body" style="padding:.3125rem">

                        <div class="card-group">

                            <!-- Tableau des joueurs à afficher ici -->
                            <?php
                            include("BDDconnexion.php");
                            $sql = "SELECT * FROM emploi";
                            $result = mysqli_query($db_handle, $sql);
                            $number = 0;
                            while ($data = mysqli_fetch_assoc($result)) {

                                $number += 1;
                                if ($number == 1)
                                    echo "<div class='row'>";

                                if ($data['photo'] == "")
                                    $data['photo'] = "img/default_emploi.jpg";
                                echo "<div class='card col-sm-4' id='annonce'>";
                                echo "<img class='card-img-top' id='emp' src='" . $data['photo'] . "'><br>";

                                echo "<div class='card-body'>";
                                echo "<h5 class='card-text'>" . $data['nom'] . "</h5>";
                                echo "<p class='card-text'> lieu : " . $data['lieu'] . "</p>";
                                echo "<p class='card-text'>" . $data['type'] . " - " . $data['duree'] . "</p>";
                                echo "<p class='card-text'>" . $data['remuneration'] . "€ brut /mois</p>";
                                echo "<p class='card-text'><small class='text-muted'> Annonce de recrutement de l'entreprise " . $data['entreprise'] . "</small></p>";

                                echo "<a href='#' class='btn btn-primary'>Découvrir</a>";
                                echo "</div>";
                                echo "</div>";
                                if ($number == 3) {
                                    $number = 0;
                                    echo "</div>";
                                }
                            }
                            if ($number != 3) {
                                while ($number != 3) { //complète le vide par des cases blanches
                                    $number += 1;
                                    echo "<div class='card col-sm-4' id='annonce'>";
                                    echo "<p id='white'>----------------------------------------------------------------------</p>";
                                    echo "</div>";
                                }
                                echo "</div>";
                            }

                            ?>
                        </div>
                    </div>

                </div>
            </div>
            <br>
        </div>
    </div>
    </div>

    <footer class="text-center text-lg-start bg-dark text-muted" id="footer">
        Copyright &copy; 2023 ECE PARIS
    </footer>
</body>

<?php
// On ferme la connexion à la base de données
mysqli_close($db_handle);
?>

</html>
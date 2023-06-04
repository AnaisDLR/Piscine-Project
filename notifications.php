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
    <title>Notifications</title>
    <!-- Icone onglet -->
    <link rel="shortcut icon" href="img/ecein.png" type="image/x-icon">
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="notifications.css">
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
                <li class="nav-item"><a class="nav-link" href="notifications.php" style="color:white">Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="vous.php" style="color:white">Vous</a></li>
            </ul>
        </div>
        <div style="border: 1px black;">
            <span style="color: #8A8C8F;">
                <?= $selfdata["Pseudo"] ?>
            </span>
            <a class="nav-link" href="index.php" style="color:white; padding: 0rem 1rem; font-size: 0.8em;">Déconnexion</a>
        </div>
    </nav>

    <div class="row">
        <div class="col-sm-1" id="section2"></div>
        <div class="col-sm-10" id="section2">
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>Notifications</h3><br>
                    <div id="card-body" style="padding:.3125rem">

                        <div class="card-group">

                            <!-- Tableau des joueurs à afficher ici -->
                            <?php
                            include("BDDconnexion.php");
                            $sql = "SELECT autor.Pseudo, event.* 
                            FROM utilisateur, participation, event, utilisateur as autor 
                            WHERE utilisateur.ID=ID_user 
                            AND ID_event=event.ID 
                            AND event.auteur=autor.ID 
                            AND utilisateur.ID=$userID
                            UNION SELECT autor.Pseudo, event.* 
                            FROM event, utilisateur as autor 
                            WHERE event.auteur=autor.ID 
                            AND (autor.Nom='ECE' OR autor.Nom='Omnes Education');";

                            
                            $result = mysqli_query($db_handle, $sql);

                            while ($data = mysqli_fetch_assoc($result)) {
                                $val2 = $data['auteur'];
                                $sql2 = "SELECT COUNT(ID_user1) as val FROM ami 
                                WHERE (ID_user1=$userID AND ID_user2=$val2)
                                OR    (ID_user1=$val2 AND ID_user2=$userID );";
                                $result2 = mysqli_query($db_handle, $sql2);
                                $data2 = mysqli_fetch_assoc($result2);
                                
                                
                                echo "<div class='row size'>";
                                
                                if ($data['photo'] == "")
                                    $data['photo'] = "img/event.png";
                                echo "<div class='card col-sm-4'>";
                                echo "<img class='card-img-top' id='img' src='" . $data['photo'] . "'><br>";
                                echo "<a href='#' class='btn btn-primary'>Je participe</a>";
                                echo "</div>";

                                echo "<div class='card col-sm-8'>";
                                echo "<div class='card-body'>";
                                if ($data['Pseudo'] == 'ECE')                  echo "<h6 class='card-text' style='color: rgb(60, 0, 255);'>Nouvelle évènement de l'école disponible</h6>";
                                else if ($data['Pseudo'] == 'Omnes Education') echo "<h6 class='card-text' style='color: rgb(211, 0, 255);'>Nouvelle évènement d'un partenaire de l'école disponible</h6>";
                                else {                                          
                                    if ($data2['val'] == 1) echo "<h6 class='card-text' style='color: rgb(255, 0, 64);'>Nouvelle évènement d'un ami disponible</h6>";
                                    else                    echo "<h6 class='card-text' style='color: rgb(255, 0, 162);'>Nouvelle évènement de l'ami d'un ami disponible</h6>";
                                }
                                echo "<p class='card-text'><small class='text-muted'>" . $data['Pseudo'] . " vous invite a un évènement !</small></p><br>";
                                echo "<p class='card-text'>" . $data['texte'] . "</p>";
                                echo "<br><br><p>&#9201;</p><p style='text-decoration: underline;'>Date : </p>
                                <p style='text-decoration: underline;'class='card-text far fa-calendar'>" . $data['date'] . "</p><br>";
                                echo "<p>&#128205;</p><p style='text-decoration: underline;' class='card-text'>" . $data['lieu'] . "</p><br><br>";
                                
                                echo "</div>";
                                echo "</div>";
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
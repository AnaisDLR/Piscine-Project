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

$sql = "SELECT * FROM utilisateur WHERE ID=$userID";
$result = mysqli_query($db_handle, $sql);
$selfdata = mysqli_fetch_assoc($result);
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
  <link rel="shortcut icon" href="img/ecein.png" type="image/x-icon">
  <script type="text/javascript">
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="vous.css">

  <style>
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
    
    .ami-profil .details {
      display: flex;
      flex-direction: column;
    }
  </style>
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
      <a class="nav-link" href="index.php" style="color:white; padding: 0rem 1rem; font-size: 0.8em;">Déconnexion</a>
    </div>
  </nav>
  <!-- Contenu -->
  <div class="row" align="center">
    <div class="col-sm-2"></div>
    <div class="col-sm-8" id="section1">
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

                // Affichage 1 
                while ($data = mysqli_fetch_assoc($resulta)){
                  echo "<tr class=\"ami-profil\">";
                  $PDP = $data['PDP'];
                  $IDami = $data['ID'];
                  echo "<td style='width: max-content'>" . "<a href=\"profile.php?id=$IDami\">" . "<img src='$PDP' width=100% height=auto>" . "</a>" . "</td>";
                  //echo "<td style='width: max-content'> <img src='$PDP' height='80' width='100'>". "</td>"; 
                  echo "<td>";
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
        <div class="col-sm-2"></div>
    </div>
    <footer class="text-center text-lg-start bg-dark text-muted" id="footer">
        Copyright &copy; 2023 ECE PARIS
    </footer>
</body>

</html>
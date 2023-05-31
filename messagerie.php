<?php
include("BDDconnexion.php");

/*session_start();
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"]) || $_SESSION["useradmin"] != 1) {
  echo "<script>document.location.replace('index.php');</script>";
  die();
} else {
  $userID = $_SESSION["userID"];
}*/
$userID = 3;



?>



<!DOCTYPE html>
<html>

<head>
  <title>Messagerie</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Icone onglet -->
  <link rel="shortcut icon" href="img/ecein.png" type="image/x-icon">
  <!-- Boostrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="accueil.css">

  <style>
    html,
    body {
      margin: 0;
      height: 100%;
      width: 100%;
    }

    td {
      padding: .3125rem;
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
        <li class="nav-item"><a class="nav-link" href="accueil.html" style="color:white">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="#" style="color:white">Réseau</a></li>
        <li class="nav-item"><a class="nav-link" href="#" style="color:white">Offres d'emploi</a></li>
        <li class="nav-item"><a class="nav-link" href="#" style="color:white">Messagerie</a></li>
        <li class="nav-item"><a class="nav-link" href="#" style="color:white">Notifications</a></li>
        <li class="nav-item"><a class="nav-link" href="vous.html" style="color:white">Vous</a></li>
      </ul>
    </div>
  </nav>
  <div style="height:4%"></div>
  <div class="row" align="center" style="margin:0; height: 85%;">
    <div class="col-sm-3" style=" height:100%;">
      <div class="card" style=" height:100%;">
        <h2 class="card-header">Discussions</h2>
        <div id="card-body" style="padding:.3125rem; height:100%; overflow-x: hidden; overflow-y: auto;">
          <!-- Tableau des discussion à afficher ici -->
          <?php
          $sql = "SELECT * FROM utilisateur WHERE ID!=$userID";
          $result = mysqli_query($db_handle, $sql);

          echo "<table border=\"1\" style='width:100%'>";
          while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr id='" . $data['ID'] . "'>";
            echo "<td style='width: 60px'>" . "<img src='" . $data['PDP'] . "' height='45' width='60'>" . "</td>";
            echo "<td>" . $data['Nom'] . "</td>";
            echo "</tr>";
          }
          echo "</table>";
          ?>
        </div>
      </div>
    </div>
    <div class="col-sm-9" style=" height:100%;">
      <div class="card" style=" height:100%; overflow-x: hidden; overflow-y: scroll;">
        <img src="img/profile-picture-default.png" width="800" height="600">
      </div>
    </div>
</body>

<?php
// On ferme la connexion à la base de données
mysqli_close($db_handle);
?>

</html>
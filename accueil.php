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
  <title>Accueil</title>
  <!-- Icone onglet -->
  <link rel="shortcut icon" href="img/ecein.png" type="image/x-icon">
  <!-- Boostrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="accueil.css">
</head>

<body style="background-image:url(<?= $selfdata['Banniere'] ?>); background-size: cover;">
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
  <!-- Contenu -->
  <div class="row" align="center">
    <div class="col-sm-4" id="section1">
      <br>
      <div class="card">
        <div class="card-header">
          <img src=<?= $selfdata['PDP'] ?> width=20% height=auto><br>
          <?= $selfdata['Nom'] ?>
        </div>
        <div class="card-body">
          <div class="container">
            <a href="#" class="btn btn-primary btn-block" role="button">Commencer un nouveau post</a>
          </div>
        </div>
      </div>
      <br>
    </div>
    <div class="col-sm-4" id="section2">
      <br>
      <div class="card">
        <div class="card-header">
          <h3>Qu'est-ce que l'ECE ?</h3><br>
          L’ECE est une école d’ingénieurs privée formant chaque année des milliers d’étudiants français et
          étrangers dans une pluralité de secteurs scientifiques, techniques et technologiques.<br>
          Elle est accréditée par la CTI, la Commission des titres d’ingénieur et répond aux plus hautes
          exigences de formation d’ingénieurs.
        </div>
        <div class="card-body">
          Publications réseaux
        </div>
        <div class="card-footer">

        </div>
      </div>
      <br>
    </div>
    <div class="col-sm-4" id="section3">
      <br>
      <div class="card">
        <div class="card-header">
          <h4>Evènements de la semaine</h4>
        </div>
        <div class="card-body">Content</div>
        <div class="card-footer">
          <h6>Contactez-nous : </h6>
          Telephone : <a href="tel:+33.01.53.64.05.24">(+33) 01 53 64 05 24</a><br>
          Mail : <a href="mailto:admissions-paris@ece.fr">admissions-paris@ece.fr</a><br>
          Localisation :<br>
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.3661096239907!2d2.2859909769205826!3d48.85122870120983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b4f58251b%3A0x167f5a60fb94aa76!2sECE%20-%20Ecole%20d&#39;ing%C3%A9nieurs%20-%20Engineering%20school.!5e0!3m2!1sfr!2sfr!4v1685455110873!5m2!1sfr!2sfr"
            width=100% height=100% style="border:0; display: block; min-height:200px" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <br>
    </div>
  </div>
  <!-- Pied de page -->
  <footer class="text-center text-lg-start bg-dark text-muted" id="footer">
    Copyright &copy; 2023 ECE PARIS
  </footer>
</body>

<?php
// On ferme la connexion à la base de données
mysqli_close($db_handle);
?>

</html>
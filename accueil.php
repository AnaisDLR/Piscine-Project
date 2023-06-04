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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $correct = 1;
  if (!isset($_POST["texte"])) {
    echo "Erreur Texte<br>";
    $correct = 0;
  } else if (empty($_POST["texte"]) && !(isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0)) {
    echo "Sélectionner un texte ou une image\n";
    $correct = 0;
  }
  if (!isset($_POST["publique"]) || empty($_POST["publique"])) {
    echo "Erreur publique<br>";
    $correct = 0;
  }

  if ($correct) {
    $texte = strip_tags($_POST["texte"]);
    $publique = (int) strip_tags($_POST["publique"]);

    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
      // extension autoriser
      $allowed = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg"
      ];

      $filename = $_FILES["photo"]["name"];
      $filetype = $_FILES["photo"]["type"];
      $filesize = $_FILES["photo"]["size"];
      $tmp_name = $_FILES["photo"]["tmp_name"];

      $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

      if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
        die("Erreur: format de fichier incorrect");
      }


      // on génère un nom unique
      $newname = md5(uniqid());
      $newfilename = __DIR__ . "/img/$newname.$extension";

      if (!move_uploaded_file($tmp_name, $newfilename)) {
        die("Erreur: téléchargement échoué");
      }

      chmod($newfilename, 0644);

      $photo = "img/$newname.$extension";
      $sql = "INSERT INTO post (texte, photo, publique, auteur) VALUES ('$texte', '$photo', $publique, $userID);";
    } else {
      $sql = "INSERT INTO post (texte, publique, auteur) VALUES ('$texte', $publique, $userID);";
    }

    $result = mysqli_query($db_handle, $sql);

    //on recharge la page pour bloquer la double soumission du formulaire
    echo "<script>document.location.replace('accueil.php');</script>";
  }
}
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
  <script src="accueil.js"></script>
</head>

<body onload="init(<?= $userID ?>)" style="background-image:url(<?= $selfdata['Banniere'] ?>); background-size: cover;">
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
          <div id="newpostform" class="container">
            <button type="button" class="btn btn-primary btn-block" onclick="newpost()">Commencer un
              nouveau post</button>
          </div>
        </div>
      </div>
      <br>
      <div class="card">
      <div class="card-body">
      <div class="card-footer">
          <h6>Contactez-nous : </h6>
          Telephone : <a href="tel:+33.01.53.64.05.24">(+33) 01 53 64 05 24</a><br>
          Mail : <a href="mailto:admissions-paris@ece.fr">admissions-paris@ece.fr</a><br>
          Localisation :<br>
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.3661096239907!2d2.2859909769205826!3d48.85122870120983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b4f58251b%3A0x167f5a60fb94aa76!2sECE%20-%20Ecole%20d&#39;ing%C3%A9nieurs%20-%20Engineering%20school.!5e0!3m2!1sfr!2sfr!4v1685455110873!5m2!1sfr!2sfr"
            width=100% height=100% style="border:0; display: block; min-height:200px" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div></div></div>
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
          <?php
          $sql = "SELECT autor.Pseudo, post.* FROM post, utilisateur as autor 
            WHERE post.auteur=autor.ID AND autor.ID=$userID UNION
            SELECT autor.Pseudo, post.* FROM post, utilisateur as autor 
            WHERE post.auteur=autor.ID AND publique=2 UNION
            SELECT autor.Pseudo, post.* FROM post, utilisateur as autor, ami
            WHERE post.auteur=autor.ID AND ((autor.ID=ID_user1 AND ID_user2=$userID) OR (ID_user1=$userID AND autor.ID=ID_user2))
            ORDER BY date DESC";
          $result = mysqli_query($db_handle, $sql);

          while ($data = mysqli_fetch_assoc($result)) {
            echo "<div id='" . $data['ID'] . "' class='post'>";
            echo "";
            echo "<span>" . $data["Pseudo"] . "</span>";
            echo "<br>";
            echo "<img src='" . $data['photo'] . "' style='max-width: 100%;'>";
            if ($data["photo"])
              echo "<br>";
            echo "<span>" . $data["texte"] . "</span>";
            echo "</div>"
            ;
          }
          ?>
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
        <div class="card-body">

                            <!-- Tableau des joueurs à afficher ici -->
                            <?php
                            include("BDDconnexion.php");
                            $sql = "SELECT autor.Pseudo, event.* 
                            FROM event, utilisateur as autor 
                            WHERE event.auteur=autor.ID 
                            AND (autor.Nom='ECE' OR autor.Nom='Omnes Education');";

                            
                            $result = mysqli_query($db_handle, $sql);

                            while ($data = mysqli_fetch_assoc($result)) {
                                
                                echo "<div class='row size mt-0 '>";
                                
                                if ($data['photo'] == "")
                                    $data['photo'] = "img/event.png";
                                echo "<div class='card col-sm-12'>";
                                echo "<img class='card-img-top' id='imgg' src='" . $data['photo'] . "'>";

                                echo "<div class='card-body'>";
                                if ($data['Pseudo'] == 'ECE')                  echo "<h6 class='card-text' style='color: rgb(60, 0, 255);'>Nouvelle évènement de l'école disponible</h6>";
                                else if ($data['Pseudo'] == 'Omnes Education') echo "<h6 class='card-text' style='color: rgb(211, 0, 255);'>Nouvelle évènement d'un partenaire de l'école disponible</h6>";

                                echo "<p class='card-text'><small class='text-muted'>" . $data['Pseudo'] . " vous invite a un évènement !</small></p>";
                                echo "<p class='card-text'>" . $data['texte'] . "</p>";
                                echo "<p style='text-decoration: underline;'>&#9201; Date : " . $data['date'] . "</p>";
                                echo "<p style='text-decoration: underline;' class='card-text'>&#128205;" . $data['lieu'] . "</p>";
                                
                                echo "<a href='#' class='btn btn-primary'>Je participe</a>";
                                echo "</div></div></div>";
                            }

                            ?>

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
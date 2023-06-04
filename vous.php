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


/// Code pour poster un post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($_POST['none'] == 'mon_post') {

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
      echo "<script>document.location.replace('vous.php');</script>";
    }

  } else if ($_POST['none'] == 'mon_event') {

    $correct = 1;
    if (!isset($_POST["texte"]) || empty($_POST["texte"])) {
      echo "Erreur texte<br>";
      $correct = 0;
    }
    if (!isset($_POST["date"]) || empty($_POST["date"])) {
      echo "Erreur date<br>";
      $correct = 0;
    }
    if (!isset($_POST["lieu"]) || empty($_POST["lieu"])) {
      echo "Erreur lieu<br>";
      $correct = 0;
    }

    if ($correct) { //pas d'erreur ?
      $texte = strip_tags($_POST["texte"]); //cybersécurité
      $date = strip_tags($_POST["date"]);
      $lieu = strip_tags($_POST["lieu"]);

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
        $sql = "INSERT INTO event (texte, nom, photo, date, lieu, auteur) VALUES ('$texte', 'none', '$photo', '$date', '$lieu', $userID);";
      } else {
        $sql = "INSERT INTO event (texte, nom, date, lieu, auteur) VALUES ('$texte', 'none', '$date', '$lieu', $userID);";
      }
      $result = mysqli_query($db_handle, $sql);
      $lastID = mysqli_insert_id($db_handle);

      $tableau = [];

      $ami = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
              WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
              OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$userID;";

      $result = mysqli_query($db_handle, $ami);

      while ($data = mysqli_fetch_assoc($result)) {
        $tableau[] = $data['ID'];
        $val = $data['ID'];
        $ami2 = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
        WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
        OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$val;";

        $result2 = mysqli_query($db_handle, $ami2);

        while ($data2 = mysqli_fetch_assoc($result2)) {
          $tableau[] = $data2['ID'];
        }
      }
      $tableau = array_unique($tableau);

      for ($i = 0; $i < count($tableau); $i++) {
        $val = $tableau[$i];
        if ($val != $userID) {
          $sql = "INSERT INTO participation (ID_user,ID_event) VALUES ('$val','$lastID')";
          $result = mysqli_query($db_handle, $sql);
        }
      }

      //on recharge la page pour bloquer la double soumission du formulaire
      echo "<script>document.location.replace('vous.php');</script>";
    }
  }
}



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


  <script src="vous.js"></script>
  <style>
    input {
      width: 100%;
    }
  </style>
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
    <div class="col-sm-1"></div>
    <div class="col-sm-10" id="section1">
      <br>
      <div class="card">
        <div class="card-header">
          <img src=<?= $selfdata['PDP'] ?> width=20% height=auto><br>
          <h1>
            <?= $selfdata['Nom'] ?>
          </h1>

          <br>
        </div>
        <div class="card-header">
          <button type="button" class="btn btn-primary" onclick="modifier_photo()">Modifier ma photo</button>
          <button type="button" class="btn btn-primary" onclick="modifier_banniere()">Modifier mon image de
            fond</button>
          <button type="button" class="btn btn-primary" onclick="modifier_formations(<?= $userID ?>)">Modifier mes
            formations</button>
          <button type="button" class="btn btn-primary" onclick="modifier_projets(<?= $userID ?>)">Modifier mes
            projets</button>
          <button type="button" class="btn btn-primary" onclick="modifier_post()">Modifier mes posts</button>

          <div id="modif_photo" style="display: none; margin:1em;" align="left">
            <form action="modif_photo.php" method="post" enctype="multipart/form-data">
              <label for="photo" style="margin-right: 1em; font-size: 1.5em;">Nouvelle photo de profil :</label>
              <input type="file" name="photo" style="width:auto;" accept="image/png, image/jpeg">
              <input type="hidden" name="userID" value="<?= $userID ?>">
              <input type="hidden" name="PDP" value="1">
              <input type="submit" value="Modifier" class="btn btn-primary btn-block"
                style="width:auto; display:initial; float:right;">
            </form>
          </div>
          <div id="modif_banniere" style="display: none; margin:1em;" align="left">
            <form action="modif_photo.php" method="post" enctype="multipart/form-data">
              <label for="photo" style="margin-right: 1em; font-size: 1.5em;">Nouvelle image de fond :</label>
              <input type="file" name="photo" style="width:auto;" accept="image/png, image/jpeg">
              <input type="hidden" name="userID" value="<?= $userID ?>">
              <input type="hidden" name="PDP" value="0">
              <input type="submit" value="Modifier" class="btn btn-primary btn-block"
                style="width:auto; display:initial; float:right;">
            </form>
          </div>
        </div>

        <div class="card-body">
          <div id="formations" class="container">

          </div>
        </div>
        <div class="card-footer">
          <div id="projets" class="container">

          </div>
        </div>

        <script>loadXMLDoc(<?= $userID ?>)</script>

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
          <div id="newpostform" class="container">
            <a href="#" class="btn btn-primary btn-lg" role="button" onclick="newpost()">Nouveau post</a>
          </div>
          <div id="neweventform" class="container">
            <a href="#" class="btn btn-primary btn-lg" role="button" onclick="newevent()">Créer un Evènement</a>
          </div>
        </div>
        <div id="listepost" class="card-body">
          <?php
          $sql = "SELECT post.* FROM post, utilisateur as autor 
            WHERE post.auteur=autor.ID AND autor.ID=$userID ORDER BY date DESC";
          $result = mysqli_query($db_handle, $sql);
          echo "<table style='width:100%;'><tbody>";

          while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr id='" . $data['ID'] . "' style='border: 1px solid lightgray;'>";
            echo "<td style='width:20%;'><img src='" . $data['photo'] . "' style='width: 100%;'></td>";
            echo "<td style='padding: 0.3em;'>";
            echo "";
            echo "<span>" . ($data["texte"] ? $data["texte"] : ">aucun texte") . "</span>";
            echo "<br><br>";
            echo "<span>" . $data["date"] . "</span>";
            echo "<br>>";
            echo "<span>Visible par : ";
            switch ($data["publique"]) {
              case 1:
                echo "amis seulements";
                break;
              case 2:
                echo "tout le monde";
                break;
              default:
                echo $data["publique"];
            }
            echo "</span>";
            echo "<span style='float:right;'>" . $data["like"] . " &#128077</span>";
            echo "</td></tr>";
          }
          echo "</tbody></table>";
          ?>
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
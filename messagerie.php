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




include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $correct = 1;
  if (!isset($_POST["nom"]) || empty($_POST["nom"])) {
    echo "Erreur nom<br>";
    $correct = 0;
  }
  if (!isset($_POST["membre"]) || empty($_POST["membre"][0])) {
    echo "Erreur membre<br>";
    $correct = 0;
  }

  if ($correct) {
    $nom = strip_tags($_POST["nom"]);
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
      $sql = "INSERT INTO conversation (nom, photo) VALUES ('$nom', '$photo');";
    } else {
      $sql = "INSERT INTO conversation (nom) VALUES ('$nom');";
    }

    $result = mysqli_query($db_handle, $sql);

    $convID = mysqli_insert_id($db_handle);
    $membres = array_unique($_POST["membre"]);
    $membres[] = $userID;
    foreach ($membres as $membre) {
      $sql = "INSERT INTO discuter (ID_user, ID_conv) VALUES ($membre, $convID);";
      $result = mysqli_query($db_handle, $sql);
    }


    //on recharge la page pour bloquer la double soumission du formulaire
    echo "<script>document.location.replace('admin.php');</script>";
  }
}

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

  <script src="messagerie.js"></script>

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

    .conv_act {
      background-color: #cacaca;
    }

    .message {
      margin: .3125rem;
      padding: .3125rem;
      width: max-content;
      text-align: left;
      background-color: #bbb;
      border: 1px solid black;
      border-radius: 5px;
      max-width: 80%;
    }

    .message>.nom {
      font-weight: bold;
      text-decoration: underline;
      font-size: 1.3em;
      color: #256a6a;
    }

    .message>.corp {
      font-size: 1.2em;
      color: black;
    }
  </style>
</head>

<body onload="init(<?= $userID ?>)"
  style="display:flex; flex-direction: column; background-image:url(<?= $selfdata['Banniere'] ?>); background-size: cover;">
  <!-- Barre navigation -->
  <nav class="navbar navbar-expand-sm bg-dark justify-content-center; height:3.9em">
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
  <div style="height:4%"></div>
  <div class="row" align="center" style="margin:0; height: calc(100% - 3.9em - 1.5em - 6%);">
    <div class="col-sm-3" style=" height:100%;">
      <div class="card" style=" height:100%;">
        <div class="card-header" style="text-align: left; display: flex; flex-wrap: wrap-reverse;">
          <span style="font-size: 2em; flex: 1">Discussions</span>
          <button type="button" class="btn btn-primary" style="font-size: 1.2em; width: 2em; height: 2em; padding: 0px;"
            onclick="changeConv(-1)">+</button>
        </div>
        <div id="card-body" style="padding:.3125rem; height:100%; overflow-x: hidden; overflow-y: auto;">
          <!-- Tableau des discussion à afficher ici -->
          <?php
          $sql = "SELECT * FROM discuter, conversation WHERE ID_user=$userID AND ID_conv=ID";
          $result = mysqli_query($db_handle, $sql);

          echo "<table border=\"1\" style='width:100%'>";
          while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr id='" . $data['ID'] . "' onclick='changeConv(this.id)'>";
            echo "<td style='width: 60px'>" . "<img src='" . $data['photo'] . "' height='45' width='60'>" . "</td>";
            echo "<td>" . $data['nom'] . "</td>";
            echo "</tr>";
          }
          echo "</table>";
          ?>
        </div>
      </div>
    </div>
    <div class="col-sm-9" style=" height:100%;">
      <div class="card" style=" height:100%;">
        <div id="conv_header" class="card-header" style="text-align: left">

        </div>
        <div id="conv_body" class="card-body" style=" height:100%; overflow-x: hidden; overflow-y: auto;">

        </div>
        <div id="conv_footer" class="card-footer" style="text-align:left; ">
          <form id="formessage" action="" method="post" enctype="multipart/form-data">
            <div style="display: flex;">
              <button type="button" style="height: 30px; width: 30px"
                onclick="document.getElementsByName('photo')[0].style.display=document.getElementsByName('photo')[0].style.display=='none' ? 'block' : 'none' ">+</button>
              <input type="file" name="photo" accept="image/png, image/jpeg" style="display: none; ">

              <input type=" text" name="texte" placeholder="Message" style="width: 100%;">
              <input type="submit" class="btn btn-primary" style="padding: 0rem .375rem" value="Envoyer">
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <div style="height:2%"></div>
  <!-- Pied de page -->
  <footer class="text-center text-lg-start bg-dark text-muted; height:1.5em" id="footer">
    Copyright &copy; 2023 ECE PARIS
  </footer>
</body>

<?php
// On ferme la connexion à la base de données
mysqli_close($db_handle);
?>

</html>
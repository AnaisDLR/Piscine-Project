<?php
include("BDDconnexion.php");

//recupération et vérification des donné de l'utilisateur
session_start();
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"]) || $_SESSION["userAdmin"] != 1) {
  echo "<script>alert('Connecte toi avant');document.location.replace('login.php');</script>";
  die();
}
$userID = $_SESSION["userID"];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $correct = 1;
  if (!isset($_POST["Pseudo"]) || empty($_POST["Pseudo"])) {
    echo "Erreur Pseudo<br>";
    $correct = 0;
  }
  if (!isset($_POST["Nom"]) || empty($_POST["Nom"])) {
    echo "Erreur Nom<br>";
    $correct = 0;
  }
  if (!isset($_POST["Email"]) || empty($_POST["Email"])) {
    echo "Erreur Email<br>";
    $correct = 0;
  }
  if (!isset($_POST["Admin"])) {
    echo "Erreur Admin<br>";
    $correct = 0;
  }
  if (!isset($_POST["MDP"]) || empty($_POST["MDP"])) {
    echo "Erreur MDP<br>";
    $correct = 0;
  }

  if ($correct) {
    $pseudo = strip_tags($_POST["Pseudo"]);
    $nom = strip_tags($_POST["Nom"]);
    $email = strip_tags($_POST["Email"]);
    $admin = strip_tags($_POST["Admin"]);
    $mdp = strip_tags($_POST["MDP"]);

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

      $PDP = "img/$newname.$extension";
    } else {
      $PDP = "img/profile-picture-default.png";
    }

    if (isset($_FILES["banniere"]) && $_FILES["banniere"]["error"] === 0) {
      // extension autoriser
      $allowed = [
        "png" => "image/png",
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg"
      ];

      $filename = $_FILES["banniere"]["name"];
      $filetype = $_FILES["banniere"]["type"];
      $filesize = $_FILES["banniere"]["size"];
      $tmp_name = $_FILES["banniere"]["tmp_name"];

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

      $ban = "img/$newname.$extension";
    } else {
      $ban = "img/banniere-picture-default.png";
    }
    $sql = "INSERT INTO utilisateur (Pseudo, Nom, Email, MDP, Admin, PDP, Banniere)
        VALUES ('$pseudo', '$nom', '$email', '$mdp', $admin, '$PDP', '$ban');";
    $result = mysqli_query($db_handle, $sql);

    //on recharge la page pour bloquer la double soumission du formulaire
    echo "<script>document.location.replace('admin.php');</script>";
  }
}
?>



<!DOCTYPE html>
<html>

<head>
  <title>Admin</title>
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

    input[type=text],
    input[type=email],
    input[type=password] {
      height: 100%;
      width: 100%;
    }
  </style>
  <script type="text/javascript">
    function suppr_util(button) {
      util = button.parentElement.parentElement;
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          util.remove();
          alert("Utilisateur supprimer");
        }
      };

      xhttp.open("GET", "suppr_util.php?id=" + util.id, true);
      xhttp.send();
    }
  </script>
</head>

<body>
  <div class="navbar navbar-expand-sm bg-dark" style="height: 12%">
    <a class="navbar-brand"><img src="img/ecein.png" width=20% height=20%></a>
    <h1 style="color:white">Administration / gestion des utilisateurs</h1>
  </div>
  <div class="row" align="center" style="margin:0; height: 88%;">
    <div class="col-sm-4" style=" height:max-content;">
      <br>
      <div class="card">
        <h2 class="card-header">Nouvel auteur</h2>
        <div id="card-body" style="padding:.3125rem">
          <form action="" method="post" enctype="multipart/form-data">
            <table border="1" width=100%>
              <tr>
                <td>Pseudo* :</td>
                <td><input type="text" name="Pseudo" required></td>
              </tr>
              <tr>
                <td>Nom* :</td>
                <td><input type="text" name="Nom" required></td>
              </tr>
              <tr>
                <td>Email* :</td>
                <td><input type="email" name="Email" required></td>
              </tr>
              <tr>
                <td>MDP* :</td>
                <td><input type="password" name="MDP" required></td>
              </tr>
              <tr>
                <td>type* :</td>
                <td><input type="radio" name="Admin" value="0" checked required>Auteur<br>
                  <input type="radio" name="Admin" value="1" required>Admin
                </td>
              </tr>
              <tr>
                <td>Photo :</td>
                <td><input type="file" name="photo" accept="image/png, image/jpeg"></td>
              </tr>
              <tr>
                <td>Bannière :</td>
                <td><input type="file" name="banniere" accept="image/png, image/jpeg"></td>
              </tr>

            </table>
            <br>
            <input type="submit" value="Créer" class="btn btn-primary btn-block" style="">
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-8" style=" height:100%; overflow-x: hidden; overflow-y: scroll;">
      <br>
      <div class="card">
        <h2 class="card-header">Utilisateurs</h2>
        <div id="card-body" style="padding:.3125rem">
          <!-- Tableau des joueurs à afficher ici -->
          <?php
          $sql = "SELECT * FROM utilisateur WHERE ID!=$userID";
          $result = mysqli_query($db_handle, $sql);
          echo "<table border=\"1\" style='width:100%'>";
          echo "<thead style='position: sticky;top: 0px;background: #343a40 !important;color: white;text-align: center;'>";
          echo "<tr>";
          echo "<th>" . "PDP" . "</th>";
          echo "<th>" . "Pseudo" . "</th>";
          echo "<th>" . "Nom" . "</th>";
          echo "<th>" . "MDP" . "</th>";
          echo "<th>" . "Email" . "</th>";
          echo "<th>" . "Inactivité" . "</th>";
          echo "<th>" . "" . "</th>";
          echo "</tr>";
          echo "</thead>";

          echo "<tbody>";
          while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr id='" . $data['ID'] . "'>";
            echo "<td style='width: 80px'>" . "<img src='" . $data['PDP'] . "' height='60' width='80'>" . "</td>";
            if ($data["Admin"])
              echo "<td><span style='text-decoration: underline; font-weight: bold'>" . $data['Pseudo'] . "</span><br>(Admin)</td>";
            else
              echo "<td>" . $data['Pseudo'] . "</td>";
            echo "<td>" . $data['Nom'] . "</td>";
            echo "<td>" . $data['MDP'] . "</td>";
            echo "<td>" . $data['Email'] . "</td>";

            //affiche le bouton supprimer si inactif depuis 5ans ou plus
            $date1 = date_create($data["Last_log"]);
            $date2 = date_create(date("Y-m-d H:i:s", time()));
            $diff = date_diff($date1, $date2);
            echo "<td>";
            if ($diff->format("%y") == 0) {
              echo "en ligne il y a moins d'une année";
            } else {
              if ($diff->format("%y") >= 5)
                echo "<span style='color:red'>hors ligne depuis : " . $diff->format("%y ans") . "</span><br>";
              else
                echo "hors ligne depuis : " . $diff->format("%y ans") . "<br>";
            }
            echo "</td><td><button type='button' onclick='suppr_util(this)'>Supprimer</button>";
            echo "</td></tr>";
          }
          echo "</tbody>";
          echo "</table>";
          ?>
        </div>
      </div>
    </div>
  </div>
</body>

<?php
// On ferme la connexion à la base de données
mysqli_close($db_handle);
?>

</html>
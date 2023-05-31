<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // a
  $Pseudo = isset($_POST["Pseudo"]) ? strip_tags($_POST["Pseudo"]) : "";
  $Nom = isset($_POST["Nom"]) ? strip_tags($_POST["Nom"]) : "";
  $Email = isset($_POST["Email"]) ? strip_tags($_POST["Email"]) : "";
  $MDP = isset($_POST["password"]) ? strip_tags($_POST["password"]) : "";


  if ($Pseudo != '' and $Nom != '' and $Email != '' and $MDP != '') {

    include("BDDconnexion.php");

    $sql = "";

    //Si la BDD existe
    if ($db_found) {
      //code MySQL. $sql est basé sur le choix de l’utilisateur

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

      $sql = "INSERT INTO utilisateur (Pseudo, Nom, Email, MDP, PDP, Banniere)
            VALUES ('$Pseudo', '$Nom', '$Email', '$MDP', '$PDP', '$ban');";
      $result = mysqli_query($db_handle, $sql);

      echo "<script>document.location.replace('accueil.html');</script>";
    } else {
      echo "<br>Database not found";
    }

    //fermer la connexion
    mysqli_close($db_handle);

  } else {
    echo "<br><p>Veuillez saisir tous les champs pour vous inscrire.</p>";
  }
}
?>

<!--------------------------------------------[ HTML ]--------------------------------------------->
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
  <link rel="stylesheet" type="text/css" href="register.css">

  <meta name="viewport" content="initial-scale=1, user-scalable=no, width=device-width">
  <title>index.php</title>
</head>

<body>
  <form method="post" enctype="multipart/form-data">

    <?php
    $login = "";
    if (isset($_POST["login"])) {
      $login = $_POST['login'];
    }
    ?>

    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="row">

      <div class="col-sm-6 p-0">
        <img src="img/connection.jpg" style="width: 100%; height: 100%">
      </div>

      <div class="col-sm-6 p-0">
        <div class="container p-5">
          <h3 class="font-weight-bold">Inscription</h3><br>

          <div class="form-group">
            <label for="login">Pseudo</label>
            <input type="text" name="Pseudo" class="form-control" placeholder="Entrer Pseudo" value="<?= $login ?>"
              required><br>
          </div>

          <div class="form-group">
            <label for="login">Nom</label>
            <input type="text" name="Nom" class="form-control" placeholder="Entrer Nom" value="<?= $login ?>"
              required><br>
          </div>

          <div class="form-group">
            <label for="login">Adresse Email</label>
            <input type="text" name="Email" class="form-control" placeholder="Entrer Email" value="<?= $login ?>"
              required><br>
          </div>

          <div class="form-group">
            <label for="password">Mot de Passe</label>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required><br>
          </div>

          <div class="form-group">
            <label for="photo">Photo </label>
            <input type="file" name="photo" accept="image/png, image/jpeg"><br>
          </div>

          <div class="form-group">
            <label for="banniere">Bannière </label>
            <input type="file" name="banniere" accept="image/png, image/jpeg"><br>
          </div>

          <div class="form-group">
            <a href="login.php">J'ai déjà un compte</a><br>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">S'inscrire</button>
          </div>
        </div>

      </div>
    </div>
  </form>
</body>

</html>
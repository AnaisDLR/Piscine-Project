<?php

session_start();


if (isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["password"])) {

  include("BDDconnexion.php");

  $login = $_POST['login'];
  $password = $_POST['password'];
  $userfound = 0;

  $requete = "SELECT * FROM utilisateur;";
  $retours = mysqli_query($db_handle, $requete);

  while($user = mysqli_fetch_array($retours, MYSQLI_ASSOC)) {

    if ($user["Email"] == $login && $user["MDP"] == $password) {
      //succes
      $userfound++;

      $userID = $user["ID"];
      $userNom = $user["Nom"];

      $_SESSION["userEmail"] = $login;
      $_SESSION["userID"] = $user["ID"];
      $_SESSION["userNom"]  = $user["Nom"];
      $_SESSION["userAdmin"] = $user["Admin"];


      $requete = "UPDATE utilisateur SET Last_log = CURRENT_TIMESTAMP WHERE ID=$userID;";
      $result = mysqli_query($db_handle, $requete);


      if ($user["Admin"] == 1) {                    //Si Admin
        echo "<script>document.location.replace('admin.php');</script>";
      } else {
        echo "<script>document.location.replace('accueil.html');</script>";
      }
    }
  }

} else if (isset($_SESSION["userEmail"]) || !empty($_SESSION["userEmail"])) {   //supprime si pas trouvé
  unset($_SESSION['userEmail']);
  unset($_SESSION["userID"]);
  unset($_SESSION["userNom"]);
  unset($_SESSION["userAdmin"]);
}
?>

<!--------------------------------------------[ HTML ]--------------------------------------------->
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
  <link rel="stylesheet" type="text/css" href="login.css"> 

  <meta name="viewport" content="initial-scale=1, user-scalable=no, width=device-width">
  <title>index.php</title>
</head>

<body>
  <form method="post">

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
        <h3 class="font-weight-bold">Connection</h3><br><br>

        <div class="form-group">
          <label for="login">Adresse Email</label>
          <input type="text" name="login" class="form-control" placeholder="Entrer Email" value="<?= $login ?>" required><br>
        </div>

        <div class="form-group">
          <label for="password">Mot de Passe</label>
          <input type="password" name="password" class="form-control" placeholder="Mot de passe" required><br>
        </div>

        <?php
          if (isset($userfound)) {
          if (!$userfound) {                      //login ou mot de passe est incorrecte
            echo "<span class='text-danger font-weight-bold'>Login ou mot de passe incorrecte.</span>";
            echo "<br><br>";
          }
          }
        ?>

        <div class="form-group">
          <a href="register.php">Créer un compte</a><br>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
      </div>

    </div>
    </div>
  </form>
</body>

</html>
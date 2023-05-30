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
        echo "t'es Admin";
      } else {
        echo "t'es pas Admin";
        //<script>document.location.replace('addpdf.php');</script>
        //<script>document.location.replace('readpdf.php');</script>
      }
    }
  }
  if (!$userfound) {                                //login ou mot de passe est incorrecte
    echo "<span style='color: red;'>login ou mot de passe est incorrecte</span>";
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
  <h1>Connexion</h1>
  <form method="post">

    <?php
    $login = "";
    if (isset($_POST["login"])) {
      $login = $_POST['login'];
    }
    ?>


    <label for="login">Adresse Email : </label>
    <input type="text" name="login" placeholder="email" value="<?= $login ?>" required><br>

    <label for="password">Mot de Passe : </label>
    <input type="password" name="password" placeholder="password" required><br>

    <a href="register.php">Créer un compte</a><br>

    <button type="submit">Se connecter</button>
  </form>
</body>

</html>
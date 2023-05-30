<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

// a
$Pseudo = isset($_POST["Pseudo"])   ? $_POST["Pseudo"] : "";
$Nom    = isset($_POST["Nom"])      ? $_POST["Nom"] : "";
$Email  = isset($_POST["Email"])    ? $_POST["Email"] : "";
$MDP    = isset($_POST["password"]) ? $_POST["password"] : "";


if ($Pseudo != '' and $Nom != '' and $Email != '' and $MDP != '') {

	//identifier votre BDD
	$database = "ECE_In";

	//identifier votre serveur (localhost), utlisateur (root), mot de passe ("")
	$db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

	$sql = "";
	
	//Si la BDD existe
	if ($db_found) {
		//code MySQL. $sql est basé sur le choix de l’utilisateur
		$sql = "INSERT INTO utilisateur (Pseudo, Nom, Email, MDP) VALUES ('$Pseudo', '$Nom', '$Email', '$MDP');";
    $result = mysqli_query($db_handle, $sql);

    echo "<script>document.location.replace('accueil.html');</script>";
  }
  else {
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
        <h3 class="font-weight-bold">Inscription</h3><br>

        <div class="form-group">
          <label for="login">Pseudo</label>
          <input type="text" name="Pseudo" class="form-control" placeholder="Entrer Pseudo" value="<?= $login ?>" required><br>
        </div>

        <div class="form-group">
          <label for="login">Nom</label>
          <input type="text" name="Nom" class="form-control" placeholder="Entrer Nom" value="<?= $login ?>" required><br>
        </div>

        <div class="form-group">
          <label for="login">Adresse Email</label>
          <input type="text" name="Email" class="form-control" placeholder="Entrer Email" value="<?= $login ?>" required><br>
        </div>

        <div class="form-group">
          <label for="password">Mot de Passe</label>
          <input type="password" name="password" class="form-control" placeholder="Mot de passe" required><br>
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


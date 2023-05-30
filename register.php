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

        $sql = "SELECT * FROM societedhonneur";
        $result = mysqli_query($db_handle, $sql);

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
  <h1>Inscription</h1>
  <form method="post">

    <label for="Pseudo">Pseudo : </label>
    <input type="text" name="Pseudo" placeholder="Pseudo" required><br>

    <label for="Nom">Nom : </label>
    <input type="text" name="Nom" placeholder="Nom" required><br>

    <label for="Email">Adresse Email : </label>
    <input type="text" name="Email" placeholder="Email" required><br>

    <label for="password">Mot de Passe : </label>
    <input type="password" name="password" placeholder="password" required><br>

    <a href="login.php">J'ai déjà un compte</a><br>

    <button type="submit">S'inscrire</button>
  </form>
</body>

</html>
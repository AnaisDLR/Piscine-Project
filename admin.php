<?php
include("BDDconnexion.php");

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
    $pseudo = $_POST["Pseudo"];
    $nom = $_POST["Nom"];
    $email = $_POST["Email"];
    $admin = $_POST["Admin"];
    $mdp = $_POST["MDP"];

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
    $sql = "INSERT INTO utilisateur (Pseudo, Nom, Email, MDP, Admin, PDP)
        VALUES ('$pseudo', '$nom', '$email', '$mdp', $admin, '$PDP');";
    $result = mysqli_query($db_handle, $sql);

    //on recharge la page pour bloquer la double soumission du formulaire
    echo "<script>document.location.replace('admin.php');</script>";
  }
}
?>



<!DOCTYPE html>
<html>

<head>
  <title>Page admin</title>
  <meta charset="utf-8">
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
  <div id="container">
    <h1>Admin</h1>
    <h2>Nouvel auteur</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <table border="1">
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

      </table>
      <input type="submit" value="Créer">
    </form>



    <h2>Utilisateurs</h2>
    <div id="content-container">
      <!-- Tableau des joueurs à afficher ici -->
      <?php
      $sql = "SELECT * FROM utilisateur WHERE admin=0";
      $result = mysqli_query($db_handle, $sql);
      echo "<table border=\"1\">";
      echo "<tr>";
      echo "<th>" . "PDP" . "</th>";
      echo "<th>" . "Pseudo" . "</th>";
      echo "<th>" . "Nom" . "</th>";
      echo "<th>" . "MDP" . "</th>";
      echo "<th>" . "Email" . "</th>";
      echo "<th>" . "" . "</th>";
      echo "</tr>";

      while ($data = mysqli_fetch_assoc($result)) {
        echo "<tr id='" . $data['ID'] . "'>";
        echo "<td>" . "<img src='" . $data['PDP'] . "' height='60' width='80'>" . "</td>";
        echo "<td>" . $data['Pseudo'] . "</td>";
        echo "<td>" . $data['Nom'] . "</td>";
        echo "<td>" . $data['MDP'] . "</td>";
        echo "<td>" . $data['Email'] . "</td>";
        echo "<td><button type='button' onclick='suppr_util(this)'>Supprimer</td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </div>
  </div>
</body>

<?php
// On ferme la connexion à la base de données
mysqli_close($db_handle);
?>

</html>
<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $correct = 1;
  if (!isset($_POST["userID"]) || empty($_POST["userID"])) {
    echo "erreur userID<br>";
    $correct = 0;
  }
  if (!isset($_POST["PDP"])) {
    echo "erreur type photo<br>";
    $correct = 0;
  }

  if ($correct) {
    $userID = strip_tags($_POST["userID"]);
    $PDP = strip_tags($_POST["PDP"]);
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

      if ($PDP)
        $sql = "UPDATE utilisateur SET PDP = '$photo' WHERE ID=$userID";
      else
        $sql = "UPDATE utilisateur SET Banniere = '$photo' WHERE ID=$userID";
      $result = mysqli_query($db_handle, $sql);
    }

    //on recharge la page pour bloquer la double soumission du formulaire
    echo "<script>document.location.replace('vous.php');</script>";
  }
}
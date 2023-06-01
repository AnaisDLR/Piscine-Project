<?php

include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $correct = 1;
  //si texte n'est pas defini ou si texte ET photo son vide
  if (!isset($_POST["texte"])) {
    echo "Erreur texte\n";
    $correct = 0;
  } else if (empty($_POST["texte"]) && !(isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0)) {
    echo "Sélectionner un texte ou une image\n";
    $correct = 0;
  }
  if (!isset($_POST["conv"]) || empty($_POST["conv"]) || $_POST["conv"] > 0) {
    echo "Sélectionner une conversation\n";
    $correct = 0;
  }
  if (!isset($_POST["userID"]) || empty($_POST["userID"])) {
    echo "Erreur userID\n";
    $correct = 0;
  }

  if ($correct) {
    $texte = strip_tags($_POST["texte"]);
    $conv = (int) strip_tags($_POST["conv"]);
    $userID = (int) strip_tags($_POST["userID"]);

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
      $sql = "INSERT INTO message (texte, photo, discussion, auteur) VALUES ('$texte', '$photo', $conv, $userID);";
    } else {
      $sql = "INSERT INTO message (texte, discussion, auteur) VALUES ('$texte', $conv, $userID);";
    }

    $result = mysqli_query($db_handle, $sql);
  }
}

mysqli_close($db_handle);
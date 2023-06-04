<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['id']) && !empty($_GET["id"])) {
    $id = (int) strip_tags($_GET['id']);

    session_start();
    if (isset($_SESSION["userID"]) && !empty($_SESSION["userID"])) {
      $userID = $_SESSION["userID"];

      $sql = "INSERT INTO post (texte, publique, auteur, comment) VALUES ('à republié ce post', 1, $userID, $id);";
      $result = mysqli_query($db_handle, $sql);
    }

  }
}

mysqli_close($db_handle);
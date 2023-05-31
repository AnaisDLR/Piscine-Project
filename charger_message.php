<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['idconv']) && !empty($_GET["idconv"]) && isset($_GET['id']) && !empty($_GET["id"])) {
    $idconv = (int) strip_tags($_GET['idconv']);
    $id = (int) strip_tags($_GET['id']);


    $sql = "SELECT message.ID as ID, Pseudo, photo, texte FROM message, utilisateur WHERE discussion=$idconv AND auteur=utilisateur.ID";
    $result = mysqli_query($db_handle, $sql);

    while ($data = mysqli_fetch_assoc($result)) {
      if ($data['ID'] == $id) {
        echo "<div id='" . $data['ID'] . "' style='display: flex; justify-content: right;'>";
        echo "<div class='message' style='background-color: #256a6a78;'>";
      } else {
        echo "<div id='" . $data['ID'] . "' style='display: flex; justify-content: left;'>";
        echo "<div class='message' style='background-color: #bbb;'>";
      }
      echo "<span class='nom'>" . $data["Pseudo"] . "</span>";
      echo "<br>";
      echo "<img src='" . $data['photo'] . "' >";
      if ($data["photo"])
        echo "<br>";
      echo "<span class='corp'>" . $data["texte"] . "</span>";
      echo "</div></div>";
    }

  }
}

mysqli_close($db_handle);
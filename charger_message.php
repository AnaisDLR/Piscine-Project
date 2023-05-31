<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['idd']) && !empty($_GET["idd"])) {
    $idd = (int) strip_tags($_GET['idd']);


    $sql = "SELECT message.ID as ID, Nom, photo, texte FROM message, utilisateur WHERE discussion=$idd AND auteur=utilisateur.ID";
    $result = mysqli_query($db_handle, $sql);

    while ($data = mysqli_fetch_assoc($result)) {
      echo "<div id='" . $data['ID'] . "'>";
      echo $data["Nom"];
      echo " :  ";
      echo $data["texte"];
      echo "</div>";
    }

  }
}

mysqli_close($db_handle);
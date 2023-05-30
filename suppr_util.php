<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['id']) && !empty($_GET["id"])) {
    $id = (int) strip_tags($_GET['id']);

    $sql = "DELETE FROM utilisateur WHERE ID=$id";
    $result = mysqli_query($db_handle, $sql);
  }
}
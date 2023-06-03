<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['id']) && !empty($_GET["id"])) {
    $id = (int) strip_tags($_GET['id']);

    $sql = "SELECT * FROM post WHERE ID=$id";
    $result = mysqli_query($db_handle, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data["photo"])
      unlink($data["photo"]);

    $sql = "DELETE FROM post WHERE ID=$id";
    $result = mysqli_query($db_handle, $sql);
  }
}

mysqli_close($db_handle);
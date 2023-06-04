<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['id']) && !empty($_GET["id"])) {
    $id = (int) strip_tags($_GET['id']);


    $sql = "UPDATE post SET post.like=post.like+1 WHERE ID=$id;";
    $result = mysqli_query($db_handle, $sql);

  }
}

mysqli_close($db_handle);
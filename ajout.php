<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //on récupère l'ID de l'user 
    session_start();
    if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"])) {
        echo "<script>alert('Connecte toi avant');document.location.replace('login.php');</script>";
        die();
    }
    $userID = $_SESSION["userID"];

    //on récupère l'ID de l'ami 
    if ($_SERVER['REQUEST_METHOD'] != 'GET')
        die("erreur IDami");

    if (!(isset($_GET['id']) && !empty($_GET["id"])))
        die("erreur IDami");

    $amiID = (int) strip_tags($_GET['id']);

    if (isset($_GET['id']) && !empty($_GET["id"])) {
    
        $sql = "INSERT INTO `ami`(`ID_user1`, `ID_user2`) VALUES ('$userID','$amiID')";
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

  }
}

mysqli_close($db_handle);
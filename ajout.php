<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //on récupère l'ID de l'user 
    session_start();
    if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"])) {
        echo "<script>alert('Connecte toi avant');document.location.replace('index.php');</script>";
        die();
    }
    $userID = $_SESSION["userID"];

    //on récupère l'ID de l'ami 
    if (!(isset($_GET['id']) && !empty($_GET["id"])))
        echo "erreur IDami";
    else {

        $amiID = (int) strip_tags($_GET['id']);

        $sql = "SELECT COUNT(ID_user1) as val FROM ami 
            WHERE (ID_user1=$userID AND ID_user2=$amiID)
            OR    (ID_user1=$amiID AND ID_user2=$userID );";
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        if ($_GET["id"] == $userID)
            echo "vous ne pouvez pas vous demander en ami";
        else if ($data['val'])
            echo "vous etes deja amis";
        else {
            $sql = "INSERT INTO `ami`(`ID_user1`, `ID_user2`) VALUES ('$userID','$amiID')";
            $result = mysqli_query($db_handle, $sql);
        }
    }
}

mysqli_close($db_handle);
<?php
include("BDDconnexion.php");
/* logique: 
    login -> avoir l'ID de l'user -> afficher le nom, l'emploi et la photo des amis 
    clic sur la photo -> page principale de l'ami
     -> liste des amis de mon ami -> clic sur la photo -> demande d'ami 
*/

//il faut remplacer par: login et avoir l'ID de l'utilisateur 
 session_start();
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"]) || $_SESSION["userAdmin"] != 1) {
  echo "<script>alert('Connecte toi avant');document.location.replace('login.php');</script>";
  die();
}
$userID = $_SESSION["userID"];  
?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js">
    </script>   
    <script type="text/javascript">
    </script>
</head>
<body>

<?php
if($db_found){
    
    $ami = "SELECT * FROM utilisateur as util1, ami, utilisateur as util2 
            WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
            OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$userID;";
    $resulta = mysqli_query($db_handle, $ami);

    //Affichage 1
    echo "<h1>Mon réseau 1</h1><br>";
    echo "<table border=\"1\">";
    echo "<tr>";
    echo "<th>" . "PDP" . "</th>";
    echo "<th>" . "Nom" . "</th>";
    echo "<th>" . "Emploi" . "</th>";
    echo "</tr>";

    while ($data = mysqli_fetch_assoc($resulta)) {
        echo "<tr>";
        $PDP = $data['PDP'];
        echo "<td> <img src='$PDP' height='80' width='100'>" . "</td>";
        echo "<td>:" . $data['Nom'] . "</td>";
        echo "<td> " . $data['Emploi'] . "</td>";
    }
    echo "</table>";

    $info = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
        WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
        OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$userID;";
    $resultat = mysqli_query($db_handle, $info);
}
?>
<!-- il faut la page de l'ami -->
<a href="vous.html"> 
  <img src='$PDP' >
</a>

<?php
//Affichage 2 

    echo "<div class=\"container\">";
    echo "<table class=\"table table-striped\">";
    echo "<tbody>";
    echo "<tr>";
    echo "<th>" . "PDP" . "</th>";
    echo "<th>" . "Nom" . "</th>";
    echo "<th>" . "Emploi" . "</th>";
    echo "</tr>";
    echo "</tbody>";


    while ($data = mysqli_fetch_assoc($resultat)) {
        echo "<tr>";
        $PDP = $data['PDP'];
        echo " <td> <img src='$PDP' height='80' width='100'>" . "</td>";
        echo "<td> " . $data['Nom'] . "</td>";
        echo "<td> " . $data['Emploi'] . "</td>";
    }
    echo "</table>";
    echo "</div>";
?>


</body>
</html>

   
<?php
 //si le BDD n'existe pas
 else {
    echo "Database not found";
  }
  mysqli_close($db_handle);
  
?>


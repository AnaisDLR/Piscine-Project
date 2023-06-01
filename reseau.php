<?php
include("BDDconnexion.php");
/* logique: 
    login -> avoir l'ID de l'user -> afficher le nom, l'emploi et la photo des amis 
    clic sur la photo -> page principale de l'ami
     -> liste des amis de mon ami -> clic sur la photo -> demande d'ami 
*/

//on récupère l'ID de l'user 
session_start();
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"])) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
    html,
    body {
      margin: 0;
      height: 100%;
      width: 100%;
    }

/* le nom est plus près à la PDP et l'emploi est en dessous du nom */
    .ami-profil {
                display: flex;
                align-items: center;
            }

     .ami-profil img {
                width: 100px;
                height: 100px;
                margin-right: 20px;
            }

    .ami-profil .details {
                display: flex;
                flex-direction: column;
            }
  </style>
</head>

<body>

    <?php
    if ($db_found) {

        $ami = "SELECT * FROM utilisateur as util1, ami, utilisateur as util2 
            WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
            OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$userID;";
        $resulta = mysqli_query($db_handle, $ami);

        // Affichage 1 
        echo "<h1>Mes amis</h1><br>";
        
        echo "<div class=\"container\">";
        echo "<table class=\"table table-striped\">";
        // echo "<tbody>";
        // echo "<tr>";
        // echo "<th>" . "PDP" . "</th>";
        // echo "<th>" . "Nom" . "</th>";
        // echo "<th>" . "Emploi" . "</th>";
        // echo "</tr>";
        // echo "</tbody>";

        
        while ($data = mysqli_fetch_assoc($resulta)) {
            //echo "<tr>";
            // echo " <td> <img src='$PDP' height='80' width='100'>" . "</td>";
            // echo "<td><strong> " . $data['Nom'] . "</strong></td>";
            // echo "<td> " . $data['Emploi'] . "</td>";
            echo "<tr class=\"ami-profil\">";
            $PDP = $data['PDP'];
            echo "<td style='width: max-content'> <img src='$PDP' height='80' width='100'>". "</td>"; 
            //clic sur cette photo -> sa page principale 
            echo "<td>";
                echo "<h5><strong>" . $data['Nom']. "</strong></h5>";
                echo "<p>" . $data['Emploi'] . "</p>";
            echo "</td>";
            echo "</tr>";
            }
        echo "</table>";
            echo "</div>";


        $info = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
        WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
        OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=$userID;";
        $resultat = mysqli_query($db_handle, $info);

        ?>

        <!-- il faut la page principale de l'ami -->
        <a href="vous.html">
            <img src="<?php echo $PDP; ?>" alt="PDP">
        </a>

        <?php

        //Affichage d'amis de mon ami 
        echo "<div class=\"container\">";
        echo "<table class=\"table table-striped\">";
        

        while ($data = mysqli_fetch_assoc($resultat)) {
            echo "<tr class=\"ami-profil\">";
            $PDP = $data['PDP'];
            echo "<td style='width: max-content'> <img src='$PDP' height='80' width='100'>". "</td>";
            echo "<td>";
                echo "<h5><strong>" . $data['Nom']. "</strong></h5>";
                echo "<p>" . $data['Emploi'] . "</p>";
            echo "</td>";
            echo "</tr>";
            // echo " <td> <img src='$PDP' height='80' width='100'>" . "</td>";
            // echo "<td><h3><strong>" . $data['Nom'] $data['Emploi'] . "</h3></strong>";
            // echo "<td> " . $data['Emploi'] . "</td>";
        }
        echo "</table>";
        echo "</div>";


        //si le BDD n'existe pas
    } else {
        echo "Database not found";
    }
    mysqli_close($db_handle);

    ?>

</body>

</html>
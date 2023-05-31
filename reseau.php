<?php
include("BDDconnexion.php");
/* logique: 
    login -> avoir l'ID de l'user -> afficher le nom, l'emploi et la photo des amis 
    clic sur la photo -> page principale de l'ami
     -> liste des amis de mon ami -> clic sur la photo -> demande d'ami 
*/

//il faut remplacer par: login et avoir l'ID de l'utilisateur 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correct = 1;
    /* if (!isset($_POST["ID_user1"]) || empty($_POST["ID_user1"])) { 
      echo "Erreur ID_user1<br>";
      $correct = 0;
    }
    */
    
}

if($correct){
    $pseudo = $_POST["Pseudo"];
    $nom = $_POST["Nom"];
    $emploi = $_POST["emploi"];
    $ami = "SELECT * FROM utilisateur as util1, ami, utilisateur as util2 
            WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
            OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=1;"

$info = "SELECT util2.* FROM utilisateur as util1, ami, utilisateur as util2 
        WHERE ((util1.ID=ami.ID_user1 AND util2.ID=ami.ID_user2) 
        OR (util1.ID=ami.ID_user2 AND util2.ID=ami.ID_user1)) AND util1.ID=1;"
}
//liste des amis: photo des amis + nom + emploi => util2.PDP , util2.Nom, util2.emploi 
/*imaginons qu'on affiche les amis de toto (son ID = 1) */

?>


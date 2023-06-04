<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['userID']) && !empty($_GET["userID"])) {
    $userID = (int) strip_tags($_GET['userID']);
    ?>


    <form action='' method='post' enctype='multipart/form-data'>
      <table width=100%>
        <tr>
          <td>Texte :</td>
          <td><input type='text' name='texte' required></td>
        </tr>
        <tr>
          <td>Date :</td>
          <td><input type='date' name='date' required></td>
        </tr>
        <tr>
          <td>Lieu :</td>
          <td><input type='text' name='lieu' required></td>
        </tr>
        <tr>
          <td>Photo :</td>
          <td><input type='file' name='photo' accept='image/png, image/jpeg'></td>
        </tr>
        <tr>
          <td><input type='hidden' name='none' value='mon_event'></td>
        </tr>
      </table>
      <br>
      <input type='submit' value='Poster' class='btn btn-primary btn-block'>
    </form>


    <?php
  }
}

mysqli_close($db_handle);
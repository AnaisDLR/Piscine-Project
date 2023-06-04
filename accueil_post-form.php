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
          <td><input type='text' name='texte'></td>
        </tr>
        <tr>
          <td>Photo :</td>
          <td><input type='file' name='photo' accept='image/png, image/jpeg'></td>
        </tr>
        <tr>
          <td>Visibilité :</td>
          <td>
            <select name="publique" onchange="" required>
              <option value="2" selected="selected">Tous le Monde</option>
              <option value="1">Amis seulement</option>
            </select>
          </td>
        </tr>
      </table>
      <br>
      <input type='submit' value='Poster' class='btn btn-primary btn-block'>
    </form>


    <?php
  }
}

mysqli_close($db_handle);
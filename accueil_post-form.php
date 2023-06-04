<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['id'])) {
    $id = (int) strip_tags($_GET['id']);
    ?>


    <form action='' method='post' enctype='multipart/form-data'>
      <table width=100%>
        <tr>
          <td>Texte :</td>
          <td><input type='text' name='texte'></td>
        </tr>
        <?php
        if (!$id) {
          ?>
          <tr>
            <td>Photo :</td>
            <td><input type='file' name='photo' accept='image/png, image/jpeg'></td>
          </tr>
          <?php
        }
        ?>
        <tr>
          <td>Visibilité :</td>
          <td>
            <select name="publique" onchange="" required>
              <option value="2" selected="selected">Tous le Monde</option>
              <option value="1">Amis seulement</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><input type='hidden' name='comment' value='<?= $id ?>'></td>
          <td><input type='hidden' name='none' value='mon_post'></td>
        </tr>
      </table>
      <br>
      <input type='submit' value='Poster' class='btn btn-primary btn-block'>
    </form>


    <?php
  }
}

mysqli_close($db_handle);
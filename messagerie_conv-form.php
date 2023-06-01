<?php
include("BDDconnexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['userID']) && !empty($_GET["userID"])) {
    $userID = (int) strip_tags($_GET['userID']);
    ?>


    <form action='' method='post' enctype='multipart/form-data'>
      <table width=100%>
        <tr>
          <td>Nom* :</td>
          <td><input type='text' name='nom' required></td>
        </tr>
        <tr>
          <td>Photo :</td>
          <td><input type='file' name='photo' accept='image/png, image/jpeg'></td>
        </tr>
        <tr>
          <td>Membre(s) :
            <button type="button" onclick="addmembre()">+</button>
          </td>
          <td id="selectmembre">
            <div>
              <select name="membre[]" onchange="" required>
                <option value="" selected="selected" disabled hidden>Utilisateur</option>

                <?php
                $sql = "SELECT * FROM utilisateur WHERE ID!=$userID AND Admin=0;";
                $result = mysqli_query($db_handle, $sql);

                while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                  ?>
                  <option value="<?= $data["ID"] ?>">
                    <?= $data["Pseudo"] ?>
                  </option>
                  <?php
                }
                ?>

              </select>
            </div>
          </td>
        </tr>
      </table>
      <br>
      <input type='submit' value='Créer' class='btn btn-primary btn-block'>
    </form>



    <?php
  }
}

mysqli_close($db_handle);
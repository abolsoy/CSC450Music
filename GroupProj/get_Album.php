<html>
<?php
require_once('../../mysqli_config.php');
$query = "SELECT * FROM Album_Contributors WHERE artist_ID = $_POST["artist_ID"]";

$resultAlb = mysqli_query($dbc,$query);


?>
<option>Select Album </option>

  <?php
    while($rowAlb = mysqli_fetch_array($resultAlb)){

      ?>

      <option value="<?php echo $rowAlb['album_ID'];?>"><?php echo $rowAlb["album_Name"]; ?></option>


       <?php

    }

   ?>
</html>

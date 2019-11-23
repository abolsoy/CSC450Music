<?php
  require_once("../../mysqli_config.php");

  $art = $_GET['art'];
  $albumQuery = 'SELECT * FROM Album_Contributors WHERE artist_ID = $art';

  $albResTest = mysqli_query($dbc,$albumQuery);

  $rowTest = mysqli_fetch_array($albResTest);

  echo $rowTest[0];

  if ($art != ''){

  $albResults = mysqli_query($dbc,$albumQuery);

  echo "<select>";
  while ($row2 =mysqli_fetch_array($albResults)){
    echo "<option>"; echo $row2["album_Name"]; echo "</option>";
  }
  echo "</select>";
  }

?>

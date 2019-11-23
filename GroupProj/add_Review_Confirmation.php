<?php
  if(!empty($_GET['reviewer_FName'])) {
    require_once('../../mysqli_config.php');
  mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Album Added</title>
      <meta charset ="utf-8">
  </head>
  <body>
    <h2>The album "<?php echo "$album_name";?>" was successfully added</h2>
    <h3><a href="insert_Album_Info.php">Add another album</a><h3>
      <h3><a href="index.html">Back to Home</a></h3>
    </body>
</html>

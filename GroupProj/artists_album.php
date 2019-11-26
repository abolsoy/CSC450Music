<?php
  require_once('../../mysqli_config.php'); //Connect to the database
  $query = "SELECT artist_Name, artist_ID FROM Artist ORDER BY artist_Name";
  $result = mysqli_query($dbc, $query);
//Fetch all rows of result as an associative array
  if($result)
    mysqli_fetch_all($result, MYSQLI_ASSOC);
    else {
      echo "<h2>We are unable to process this request right now.</h2>";
      echo "<h3>Please try again later.</h3>";
      exit;
}
mysqli_close($dbc);
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <title>455 Music</title>
 	<meta charset ="utf-8">
 </head>
 <body>
 	<h2>Look Up Vendors</h2>

 	<form action = "artist_data.php" method="get">
 		<!-- Use a PHP loop to generate a select list of vendors in the DB -->
 		Select the vendor you are searching for:
 		<select name="artist_ID">
 		<?php foreach ($result as $artist) {
 			//store the row array variables as scalar variables to simplify syntax
 			$id = $artist['artist_ID'];
 			$name = $artist['artist_Name'];
 			//create an html option tag using \ to escape the " characters required for the html attribute
 			echo "<option value=\"$id\">$name</option>";
 		} ?>
 		</select>
 		<input type="submit" value="Find Albums:">
 	</form>
 </body>
 </html>

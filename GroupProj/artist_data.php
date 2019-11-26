<?php
	//Check to determine if this page was called with a vend_id set and so assume it is from find_vendor.php
	if(!empty($_GET['artist_ID'])) {
		$artist_ID = $_GET['artist_ID'];
		require_once('../../mysqli_config.php'); //adjust the relative path as necessary to find your config file
		//Retrieve specific vendor data using prepared statements:
		$query = "SELECT art.artist_ID, alb.album_ID, art.artist_Name, albCon.album_Name, alb.release_Date,alb.record_Label
              from Artist as art NATURAL join Album_Contributors as albCon join Album as alb on (alb.album_ID = albCon.album_ID)
              where art.artist_ID = ?";

		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "i", $artist_ID); //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if($result){ //it ran successfully
      $artist_INFO = mysqli_fetch_all($result,MYSQLI_ASSOC);
			$num = mysqli_num_rows($artist_INFO);
		}
		else {
			echo "That artist was not found";
			mysqli_close($dbc);
			exit;
		}
	} // end isset
	else {
		echo "You have reached this page in error";
		exit;
	}
	//Vendor found, output results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LG Co</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>Artist Data:</h2>
	<table>
	<tr>
		<th>Album Name</th>
		<th>Release Date</th>
		<th>Record Label</th>
	</tr>
	<?php foreach ($artist_INFO as $alb) {
		echo "<tr>";
		echo "<td>".$alb['album_Name']."</td>";
		echo "<td>".$alb['release_Date']."</td>";
		echo "<td>".$alb['record_Label']."</td>";
		echo "</tr>";
	}
	?>
</table>

	<br>
	<h3><a href="artists_album.php">View another artist</a></h3>
	<h3><a href="index.html">Back to Home</a></h3>
</body>
</html>

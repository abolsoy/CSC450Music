
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Music 455</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>Most Frequently Reviewed Albums</h2>

	<table>
		<tr>
			<th>Album Name</th>
			<th>Artist Name</th>
			<th>Number of Reviews</th>
			<?php
				require_once('../../mysqli_config.php'); //Connect to the database


				$query = "SELECT album_Name, artist_Name, COUNT(album_ID) rCount
									FROM Album_Rating ar JOIN Album_Contributors ac USING (album_ID) JOIN Artist a USING (artist_ID)
									GROUP BY album_ID, album_Name, artist_Name
									ORDER BY rCount DESC
									LIMIT 20";

				$stmt = mysqli_prepare($dbc, $query); //
				mysqli_stmt_execute($stmt); //
				$result = mysqli_stmt_get_result($stmt); //



				if($result){
					$Allalbs = mysqli_fetch_all($result, MYSQLI_ASSOC);
					foreach ($Allalbs as $alb) {
						echo "<tr>";
						echo "<td>".$alb['album_Name']."</td>";
						echo "<td>".$alb['artist_Name']."</td>";
						echo "<td>".$alb['rCount']."</td>";
						echo "</tr>";
					}
				}
				else {
					echo "<h2>We are unable to process this request right now.</h2>";
					echo "<h3>Please try again later.</h3>";
					mysql_close($dbc);
					exit;
				}
			?>
	</table>
 	<h4><a href="index.html">Back to Home</a></h4>
</body>
</html>

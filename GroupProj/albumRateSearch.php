<?php
	if(!empty($_GET['album']))
		$album = $_GET['album'];

	else
		$album = NULL;

	$wild_cardSQL = '%';
	$param = $wild_cardSQL . $album . $wild_cardSQL;

	require_once('../../mysqli_config.php');
	$query = 'SELECT c.album_Name, a.artist_Name, ar.album_Score, r.reviewer_FName, r.reviewer_LName
	FROM Album_Contributors c JOIN Artist a USING(artist_ID) JOIN Album_Rating ar USING(album_ID)
	JOIN Reviewer r USING(reviewer_ID)
	WHERE c.album_Name LIKE ?';
	$stmt = mysqli_prepare($dbc, $query); //
	mysqli_stmt_bind_param($stmt, "s", $param);
	mysqli_stmt_execute($stmt); //
	$result = mysqli_stmt_get_result($stmt); //
	//$result = mysqli_query($dbc, $query);
	//Fetch all rows of result as an associative array
	if($result)
		mysqli_fetch_all($result, MYSQLI_ASSOC); //get the result as an associative, 2-dimensional array
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
    <!--Alex Bolsoy-->
    <title>Album Ratings</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>Ratings For An Album</h2>

	<table>
		<tr>
			<th>Album Name</th>
			<th>Artist Name</th>
			<th>Rating</th>
			<th>Reviewer First Name</th>
			<th>Reviewer Last Name</th>
		</tr>
		<?php foreach ($result as $vendor) {
			echo "<tr>";
			echo "<td>".$vendor['album_Name']."</td>";
			echo "<td>".$vendor['artist_Name']."</td>";
			echo "<td>".$vendor['album_Score']."</td>";
			echo "<td>".$vendor['reviewer_FName']."</td>";
			echo "<td>".$vendor['reviewer_LName']."</td>";
			echo "</tr>";
		}
		?>
	</table>
	<h4><a href="albumRateSearch.html">Lookup another album's ratings</a></h4>
 	<h4><a href="index.html">Back to Home</a></h4>
</body>
</html>

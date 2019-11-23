<?php
	require_once('../../mysqli_config.php'); //Connect to the database
	$query1 = "SELECT artist_ID, artist_Name FROM Artist ORDER BY artist_Name";
	$query2 = "SELECT genre_ID, genre_Name FROM Genre ORDER BY genre_Name";
	$result1 = mysqli_query($dbc, $query1);
	$result2 = mysqli_query($dbc, $query2);
	//Fetch all rows of result as an associative array
	if($result1)
		mysqli_fetch_all($result1, MYSQLI_ASSOC);
	else {
		echo "<h2>We are unable to process this request right now.</h2>";
		echo "<h3>Please try again later.</h3>";
		exit;
	}
	if($result2)
		mysqli_fetch_all($result1, MYSQLI_ASSOC);
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
    <title>Insert an Album</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>Insert New Album:</h2>

	<form action = "album_Confirmation.php" method="get">
		<!-- Use a PHP loop to generate a select list of vendors in the DB -->
		Select the artist you are searching for:
		<select name="artist_ID">
    <option value="" selected disabled hidden>Select an artist...</option>
		<?php foreach ($result1 as $artist) {
			//store the row array variables as scalar variables to simplify syntax
			$artist_id = $artist['artist_ID'];
			$artist_name = $artist['artist_Name'];
			//create an html option tag using \ to escape the " characters required for the html attribute
			echo "<option value=\"$artist_id\">$artist_name</option>";
		} ?>
    </select>
		<br>
		<br>
    Select a genre or other:
    <select name="genre_ID">
    <option value="" selected disabled hidden>Select a genre...</option>
		<?php foreach ($result2 as $genre) {
			//store the row array variables as scalar variables to simplify syntax
			$genre_id = $genre['genre_ID'];
			$genre_name = $genre['genre_Name'];
			//create an html option tag using \ to escape the " characters required for the html attribute
			echo "<option value=\"$genre_id\">$genre_name</option>";
		} ?>
    </select>
		<br>
		<br>
		Enter a recording label:
		<input type="text" name="rec_Label">
		<br>
		<br>
    Enter a release date:
    <input type="date" name="rel_Date">
		<br>
		<br>
		Enter an album name:
		<input type="text" name="album_Name">
		<br>
		<br>
    <input type="submit" value="Add Album">
	</form>
</body>
</html>

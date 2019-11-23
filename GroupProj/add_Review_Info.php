<?php
	require_once('../../mysqli_config.php'); //Connect to the database
	$query1 = "SELECT r.reviewer_ID, r.reviewer_FName, r.reviewer_LName FROM Reviewer AS r ORDER BY r.reviewer_FName";
	$result1 = mysqli_query($dbc, $query1);
	//Fetch all rows of result as an associative array
	if($result1)
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

	<form action = "add_Review_Confirmation.php" method="get">
		<!-- Use a PHP loop to generate a select list of vendors in the DB -->
    <p1>Type in your email: (If you have not created an account, do that first by clicking <a href= 'createReviewer.html'>here</a>.)</p1>
    <input type="email" value=""></option>
		<br>
		<br>
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

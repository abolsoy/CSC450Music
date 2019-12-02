<?php
	if(!empty($_GET['last'])) 
		$last_name = $_GET['last'];
	else
		$last_name = NULL;
	if(!empty($_GET['first']))
		$first_name = $_GET['first'];
	else
		$first_name = NULL;
	if(!empty($_GET['album']))
		$album_name = $_GET['album'];
	else
		$album_name = NULL;
	require_once('../../mysqli_config.php'); //Connect to the database  - r.reviewer_FName <> ? AND r.reviewer_LName <> ? AND c.album_Name = ? AND 
	$query = 'SELECT a.reviewer_ID, r.reviewer_FName, r.reviewer_LName, a.album_Score, c.album_Name FROM Reviewer r join 
	Album_Rating a using (reviewer_ID) 
	join Album_Contributors c using (album_ID) WHERE (c.album_Name = ? AND
	a.album_Score = (SELECT a2.album_Score FROM Reviewer r2 join Album_Rating a2 using (reviewer_ID) join Album_Contributors c2 using (album_ID) WHERE 
	(r2.reviewer_FName = ? AND r2.reviewer_LName = ? AND c2.album_Name = ?)))';
	$stmt = mysqli_prepare($dbc, $query); //
	mysqli_stmt_bind_param($stmt, "ssss", $album_name, $first_name, $last_name, $album_name); // , $first_name, $last_name, $album_name
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
    <title>Same Score Results</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2>Reviewers That Gave the Same Score</h2>

	<table>
		<tr>
			<th>Reviewer First Name</th>
			<th>Reviewer Last Name</th>
			<th>Album Name</th>
			<th>Album Score</th>
		</tr>	
		<?php foreach ($result as $vendor) {
			echo "<tr>";
			echo "<td>".$vendor['reviewer_FName']."</td>";
			echo "<td>".$vendor['reviewer_LName']."</td>";
			echo "<td>".$vendor['album_Name']."</td>";
			echo "<td>".$vendor['album_Score']."</td>";
			echo "</tr>";
		}
		?>
	</table>
	<h4><a href="sameAlbumScore.html">Lookup another repeat score</a></h4>
 	<h4><a href="index.html">Back to Home</a></h4>
</body>    
</html>
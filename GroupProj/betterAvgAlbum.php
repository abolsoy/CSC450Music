<?php
	if(!empty($_GET['rate'])) 
		$rate = $_GET['rate'];
	else
		$rate = NULL;
	require_once('../../mysqli_config.php');  
	$query = 'SELECT AvgScore, album_Name
	FROM (SELECT album_ID, ROUND(AVG(album_Score),2) AS AvgScore, COUNT(*) AS NumScore
	FROM Album_Rating GROUP BY album_ID) as t JOIN Album_Contributors USING (album_ID)
	WHERE AvgScore >= ?';
	$stmt = mysqli_prepare($dbc, $query); //
	mysqli_stmt_bind_param($stmt, "s", $rate); 
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
    <title>Album Search</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2>Albums With Average Rating</h2>

	<table>
		<tr>
			<th>Album Name</th>
			<th>Average Rating</th>
		</tr>	
		<?php foreach ($result as $vendor) {
			echo "<tr>";
			echo "<td>".$vendor['album_Name']."</td>";
			echo "<td>".$vendor['AvgScore']."</td>";
			echo "</tr>";
		}
		?>
	</table>
	<h4><a href="betterAvgAlbum.html">Lookup another album average rating</a></h4>
 	<h4><a href="index.html">Back to Home</a></h4>
</body>    
</html>
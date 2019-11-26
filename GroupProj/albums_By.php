<?php
if(!empty($_GET['artist_Name'])) {
  $searched_Artist = $_GET['artist_Name'];
  $wild_cardSQL = '%';

  $param = $wild_cardSQL . $searched_Artist . $wild_cardSQL;
  echo $param;

  require_once('../../mysqli_config.php'); //adjust the relative path as necessary to find your config file
  //Retrieve specific vendor data using prepared statements:
  $query = "SELECT Artist.artist_Name, count(Artist.artist_ID) as albCount
            from Album_Contributors NATURAL JOIN Artist
            WHERE Artist.artist_Name LIKE ?
            GROUP BY Artist.artist_Name;";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "s", $param);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  echo "There are " . mysqli_num_rows($result). 'matches for this search:';

  // For simplicity, this example assumes customer first and last name pairs are unique
  if(mysqli_num_rows($result)>=1){ //Customer found
    $customer = mysqli_fetch_assoc($result); //Fetches the row as an associative array with DB attributes as keys
    // $cust_id = $customer['CUST_CODE'];
    $stmt2 = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt2, "s", $param); //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    if($result2){ //it ran successfully
      $all_Artists = mysqli_fetch_all($result2, MYSQLI_ASSOC); //fetch all rows as an associative array
      $num_rows = mysqli_num_rows($result2);
    }
    else {
      echo "<h2>That artist has no albums</h2>";
      mysqli_close($dbc);
      exit;
    }
  } // end if($result)
  else {
    echo "<h2>That artist was not found</h2>";
    echo "<h3><a href='albums_By.html'>Look for another artist</a></h3>";
    mysqli_close($dbc);
    exit;
  }
}
else {
  echo "You have reached this page in error";
  exit;
}
//Invoices found, output results
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <title>LG Co</title>
 	<meta charset ="utf-8">
 	<!-- Add some spacing to each table cell -->
 	<style> td, th {padding: 1em;} </style>
 </head>
 <body>

 	<h3><?php echo $num_rows;?> in result</h3>
 	<table>
 		<tr>
 			<th>Artist #</th>
 			<th>Albums in Our System</th>
 		</tr>
 		<?php foreach($all_Artists as $review) {
 			echo "<tr>";
 			echo "<td>".$review['artist_Name']."</td>";  // . is the contatenation operator used for output streaming
 			echo "<td>".$review['albCount']."</td>";
 			echo "</tr>";
 		} ?>
 	</table>
 	<h3><a href="albums_By.html">Look for another artist</a></h3>
 	<h3><a href="index.html">Back to Home</a></h3>
 </body>
 </html>

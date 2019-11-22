<?php
if(!empty($_GET['last'])) {
  $last_name = $_GET['last'];
  if(!empty($_GET['first']))
    $first_name = $_GET['first'];
  else
    $first_name = NULL;
  require_once('../../mysqli_config.php'); //adjust the relative path as necessary to find your config file
  //Retrieve specific vendor data using prepared statements:
  $query = "SELECT r.reviewer_ID, alb.album_ID, alb.artist_ID, r.reviewer_FName, r.reviewer_LName, rate.album_Score, alb.release_Date, Artist.artist_Name, Album_Contributors.album_Name
            from Reviewer as r NATURAL JOIN Album_Rating as rate join Album as alb on (rate.album_ID = alb.album_ID) join Album_Contributors on (Album_Contributors.artist_ID = alb.artist_ID)
            join Artist on (Album_Contributors.artist_ID = Artist.artist_ID) WHERE r.reviewer_FName = ? and r.reviewer_LName = ?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "ss", $first_name, $last_name);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  echo "the number of obs is " . mysqli_num_rows($result);
  // For simplicity, this example assumes customer first and last name pairs are unique
  if(mysqli_num_rows($result)>=1){ //Customer found
    echo "this user has reviews";
    $customer = mysqli_fetch_assoc($result); //Fetches the row as an associative array with DB attributes as keys
    // $cust_id = $customer['CUST_CODE'];
    $query2 = "SELECT r.reviewer_ID, alb.album_ID, alb.artist_ID, r.reviewer_FName, r.reviewer_LName, rate.album_Score, alb.release_Date, Artist.artist_Name, Album_Contributors.album_Name
              from Reviewer as r NATURAL JOIN Album_Rating as rate join Album as alb on (rate.album_ID = alb.album_ID) join Album_Contributors on (Album_Contributors.artist_ID = alb.artist_ID)
              join Artist on (Album_Contributors.artist_ID = Artist.artist_ID) WHERE r.reviewer_FName = ? and r.reviewer_LName = ?";
    $stmt2 = mysqli_prepare($dbc, $query2);
    mysqli_stmt_bind_param($stmt2, "ss", $first_name,$last_name); //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if($result2){ //it ran successfully
      $all_Reviews = mysqli_fetch_all($result2, MYSQLI_ASSOC); //fetch all rows as an associative array
      $num_rows = mysqli_num_rows($result2);
    }
    else {
      echo "<h2>That customer has no invoices</h2>";
      mysqli_close($dbc);
      exit;
    }
  } // end if($result)
  else {
    echo "<h2>That customer was not found</h2>";
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
 	<h2>Invoices for Customer <?php echo "$first_name $last_name";?></h2>
 	<h3><?php echo $num_rows;?> in result</h3>
 	<table>
 		<tr>
 			<th>Invoice #</th>
 			<th>Date</th>
 			<th>Total</th>
 			<th>Employee</th>
 		</tr>
 		<?php foreach($all_Reviews as $review) {
 			echo "<tr>";
 			echo "<td>".$review['artist_Name']."</td>";  // . is the contatenation operator used for output streaming
 			echo "<td>".$review['album_Name']."</td>";
 			echo "<td>$".$review['album_Score']."</td>";
 			echo "</tr>";
 		} ?>
 	</table>
 	<h3><a href="find_customer.html">Lookup another customer's invoices</a></h3>
 	<h3><a href="index.html">Back to Home</a></h3>
 </body>
 </html>

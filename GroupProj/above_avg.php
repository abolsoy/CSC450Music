<?php
if(!empty($_GET['last'])&& !empty($_GET['first'])) {
  $last_name = $_GET['last'];
  $first_name = $_GET['first'];
  require_once('../../mysqli_config.php'); //adjust the relative path as necessary to find your config file
  //Retrieve specific vendor data using prepared statements:
  $query = "SELECT r.reviewer_ID, alb.album_ID, alb.artist_ID, r.reviewer_FName, r.reviewer_LName, rate.album_Score, alb.release_Date, art.artist_Name, contrib.album_Name
            from Reviewer as r NATURAL JOIN Album_Rating as rate join Album as alb on (rate.album_ID = alb.album_ID) join Album_Contributors contrib on (contrib.artist_ID = alb.artist_ID) join Artist art on (contrib.artist_ID = art.artist_ID)
            WHERE r.reviewer_FName = ? and r.reviewer_LName = ?
            GROUP BY r.reviewer_ID, alb.album_ID,alb.artist_ID,contrib.album_Name
            HAVING rate.album_Score >
            (SELECT AVG(UserAvg.album_Score)
            from (SELECT r2.reviewer_ID, alb2.album_ID, alb2.artist_ID, r2.reviewer_FName, r2.reviewer_LName, rate2.album_Score, alb2.release_Date, art2.artist_Name, contrib2.album_Name
            from Reviewer as r2 NATURAL JOIN Album_Rating as rate2 join Album as alb2 on (rate2.album_ID = alb2.album_ID) join Album_Contributors contrib2 on (contrib2.artist_ID = alb2.artist_ID) join Artist art2 on (contrib2.artist_ID = art2.artist_ID)
            WHERE r2.reviewer_FName = ? and r2.reviewer_LName=?) as UserAvg)";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name,$first_name,$last_name);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  echo "the number of obs is " . mysqli_num_rows($result);
  // For simplicity, this example assumes customer first and last name pairs are unique
  if(mysqli_num_rows($result)>=1){ //Customer found
    echo "this user has favorites";
    $customer = mysqli_fetch_assoc($result); //Fetches the row as an associative array with DB attributes as keys
    // $cust_id = $customer['CUST_CODE'];
    $query2 = "SELECT r.reviewer_ID, alb.album_ID, alb.artist_ID, r.reviewer_FName, r.reviewer_LName, rate.album_Score, alb.release_Date, art.artist_Name, contrib.album_Name
              from Reviewer as r NATURAL JOIN Album_Rating as rate join Album as alb on (rate.album_ID = alb.album_ID) join Album_Contributors contrib on (contrib.artist_ID = alb.artist_ID) join Artist art on (contrib.artist_ID = art.artist_ID)
              WHERE r.reviewer_FName = ? and r.reviewer_LName = ?
              GROUP BY r.reviewer_ID, alb.album_ID,alb.artist_ID,contrib.album_Name
              HAVING rate.album_Score >
              (SELECT AVG(UserAvg.album_Score)
              from (SELECT r2.reviewer_ID, alb2.album_ID, alb2.artist_ID, r2.reviewer_FName, r2.reviewer_LName, rate2.album_Score, alb2.release_Date, art2.artist_Name, contrib2.album_Name
              from Reviewer as r2 NATURAL JOIN Album_Rating as rate2 join Album as alb2 on (rate2.album_ID = alb2.album_ID) join Album_Contributors contrib2 on (contrib2.artist_ID = alb2.artist_ID) join Artist art2 on (contrib2.artist_ID = art2.artist_ID)
              WHERE r2.reviewer_FName = ? and r2.reviewer_LName=?) as UserAvg)";

    $query3 = "SELECT Round(AVG(UserAvg.album_Score),2) as user_AVG
              from (SELECT r.reviewer_ID, alb.album_ID, alb.artist_ID, r.reviewer_FName, r.reviewer_LName, rate.album_Score, alb.release_Date, art.artist_Name, contrib.album_Name
              from Reviewer as r NATURAL JOIN Album_Rating as rate join Album as alb on (rate.album_ID = alb.album_ID) join Album_Contributors contrib on (contrib.artist_ID = alb.artist_ID) join Artist art on (contrib.artist_ID = art.artist_ID)
              WHERE r.reviewer_FName = ? and r.reviewer_LName=?) as UserAvg";

    $stmt2 = mysqli_prepare($dbc, $query2);
    $stmt3 = mysqli_prepare($dbc,$query3);

    mysqli_stmt_bind_param($stmt2, "ssss", $first_name,$last_name,$first_name,$last_name); //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    mysqli_stmt_bind_param($stmt3,"ss", $first_name,$last_name);
    mysqli_stmt_execute($stmt3);
    $result3= mysqli_stmt_get_result($stmt3);
    $userAvg = mysqli_fetch_array($result3);

    if($result2 && $result3){ //it ran successfully
      echo "result 2  worked";
      $all_Favorites = mysqli_fetch_all($result2, MYSQLI_ASSOC); //fetch all rows as an associative array
      $num_rows = mysqli_num_rows($result2);

    }
    else {
      echo "<h2>This customer does not have favorite albums</h2>";
      mysqli_close($dbc);
      exit;
    }
  } // end if($result)
  else {
    echo "<h2>That reviewer was not found</h2>";
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
     <title>455 Music</title>
 	<meta charset ="utf-8">
 	<!-- Add some spacing to each table cell -->
 	<style> td, th {padding: 1em;} </style>
 </head>
 <body>
 	<h2>Reviewers Favorite Albums <?php echo "$first_name $last_name";?></h2>
 	<h3><?php echo $num_rows;?> in result</h3>
  <h4>Average Review Score by <?php echo"$first_name is: $userAvg[0]"; ?></h4>
 	<table>
 		<tr>
 			<th>Album Name</th>
 			<th>Artist</th>
 			<th>Score</th>
 		</tr>
 		<?php foreach($all_Favorites as $favorites) {
 			echo "<tr>";
 			echo "<td>".$favorites['album_Name']."</td>";  // . is the contatenation operator used for output streaming
 			echo "<td>".$favorites['artist_Name']."</td>";
 			echo "<td>".$favorites['album_Score']."</td>";
 			echo "</tr>";
 		} ?>
 	</table>
 	<h3><a href="above_Avg.html">Lookup another users favorite albums</a></h3>
 	<h3><a href="index.html">Back to Home</a></h3>
 </body>
 </html>

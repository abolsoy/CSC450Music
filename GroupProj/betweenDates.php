<?php
  if(!empty($_GET['lowEnd']) && !empty($_GET['highEnd'])) {
    require_once('../../mysqli_config.php');

    $low = $_GET['lowEnd'];
    $high = $_GET['highEnd'];

    $query = "SELECT album_Name, artist_Name, release_Date
              FROM Album JOIN Artist USING (artist_ID) JOIN Album_Contributors USING(album_ID)
              WHERE release_Date BETWEEN ? AND ?";

    $stmt = mysqli_prepare($dbc, $query);
  	mysqli_stmt_bind_param($stmt, "ss", $low,$high);
  	mysqli_stmt_execute($stmt);
  	$result = mysqli_stmt_get_result($stmt);

    if($result){
      $albs = mysqli_fetch_all($result,MYSQLI_ASSOC);
      $num = mysqli_num_rows($result);
    }
    if(!$num > 0){
      echo "<h>No albums between these dates</h><br>";
      echo "<p><a href='index.html'>Go home</a></p>";
      echo "<p><a href='betweenDates.html'>Search with different dates</a></p>";
      mysqli_close($dbc);
      exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Music 455</title>
 <meta charset ="utf-8">
 <!-- Add some spacing to each table cell -->
 <style> td, th {padding: 1em;} </style>
</head>
<body>
 <h2>Albums between these dates <?php echo "$low - $high";?></h2>
 <h3><?php echo $num;?> albums</h3>
 <table>
   <tr>
     <th>Album Name</th>
     <th>Artist Name</th>
     <th>Release Date</th>
     <?php
      foreach ($albs as $alb) {
        echo "<tr>";
   			echo "<td>".$alb['artist_Name']."</td>";  // . is the contatenation operator used for output streaming
   			echo "<td>".$alb['album_Name']."</td>";
   			echo "<td>".$alb['release_Date']."</td>";
   			echo "</tr>";
      }
      ?>
   </tr>
 </table>
 <h3><a href="betweenDates.html">Search with different dates</a></h3>
 <h3><a href="index.html">Back to Home</a></h3>
</body>
</html>
<?php mysqli_close($dbc) ?>

<?php
  if(!empty($_GET['artist_ID']) && !empty($_GET['album_Name']) && !empty($_GET['rec_Label']) && !empty($_GET['rel_Date']) && !empty($_GET['genre_ID'])) {
    require_once('../../mysqli_config.php');

    $query1 = "SELECT MAX(album_ID) FROM Album";
    $result1 = mysqli_query($dbc, $query1);
    $row1 = mysqli_fetch_array($result1);

    $album_id = $row1[0] + 1;
    $artist_id = $_GET['artist_ID'];
    $genre_id = $_GET['genre_ID'];
    $rec_label = $_GET['rec_Label'];
    $rel_date = $_GET['rel_Date'];
    $album_name = $_GET['album_Name'];

    $query2 = "SELECT album_Name FROM Album_Contributors WHERE album_Name = ?";
    $stmt1 = mysqli_prepare($dbc, $query2);
    mysqli_stmt_bind_param($stmt1, "s", $album_name);
    mysqli_stmt_execute($stmt1);
    $result2 = mysqli_stmt_get_result($stmt1);
    $row2 = mysqli_fetch_array($result2);
    if($album_name = $row2[0]) {
      echo "Album already exists in the database";
      echo "<h3><a href=\"insert_Album_Info.php\">Try adding another album</a><h3>";
      exit;
    }

    $query3 = "INSERT INTO Album(album_ID, artist_ID, release_Date, record_Label) VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($dbc, $query3);
    mysqli_stmt_bind_param($stmt2, "iiss", $album_id, $artist_id, $rel_date, $rec_label);

    $query4 = "INSERT INTO Album_Type(genre_ID, album_ID) VALUES (?, ?)";
    $stmt3 = mysqli_prepare($dbc, $query4);
    mysqli_stmt_bind_param($stmt3, "ii", $genre_id, $album_id);

    $query5 = "INSERT INTO Album_Contributors(album_ID, artist_ID, album_Name) VALUES (?, ?, ?)";
    $stmt4 = mysqli_prepare($dbc, $query5);
    mysqli_stmt_bind_param($stmt4, "iis", $album_id, $artist_id, $album_name);

    if(!mysqli_stmt_execute($stmt2) || !mysqli_stmt_execute($stmt3) || !mysqli_stmt_execute($stmt4)) { //it did not run successfully
      echo "<h2>We were unable to add the customer at this time.</h2>";
      echo "$album_id<br>";
      echo "$artist_id<br>";
      echo "$genre_id<br>";
      echo "$rec_label<br>";
      echo "$rel_date<br>";
      echo $album_name;
      exit;
    }
    mysqli_close($dbc);
  }
  else {
    echo "<h2>You were missing an piece of album information</h2>";
    echo "<h3><a href=\"insert_Album_Info.php\">Try adding another album</a><h3>";
    exit;
  }
  mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Album Added</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>The album "<?php echo "$album_name";?>" was successfully added</h2>
	<h3><a href="insert_Album_Info.php">Add another album</a><h3>
	<h3><a href="index.html">Back to Home</a></h3>
</body>
</html>

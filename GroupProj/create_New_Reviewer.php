<?php
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(!empty($_GET['userEmail'])) { //must have at least a last name not = NULL
		$last = $_GET['userLName'];
		$first = $_GET['userFName'];
		$email = $_GET['userEmail'];
		$DOB = $_GET['userDOB'];
		require_once('../../mysqli_config.php'); //adjust the relative path as necessary to find your config file
		//Retrieve largest cust_id
		$query = "SELECT MAX(reviewer_ID) FROM Reviewer";
		//No prepared statements because nothing is input from user for this query
		$result=mysqli_query($dbc, $query);
		$row=mysqli_fetch_array($result); //enumerated array this time instad of assosciative
		$newID = $row[0] + 1;

		$query2 = "INSERT INTO Reviewer(reviewer_ID, reviewer_FName, reviewer_LName, reviewer_DOB, reviewer_Email) VALUES (?,?,?,?,?)";
		$stmt2 = mysqli_prepare($dbc, $query2);

		//second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
		mysqli_stmt_bind_param($stmt2, "sssss", $newID, $first, $last, $DOB, $email);

		if(!mysqli_stmt_execute($stmt2)) { //it did not run successfully
			echo "<h2>We were unable to add the customer at this time.</h2>";
      echo $newID;
      echo $userDOB;
      echo $email;
			mysqli_close($dbc);
			exit;
		}
		mysqli_close($dbc);
	}
	else {
		echo "<h2>You have reached this page in error</h2>";
		mysqli_close($dbc);
		exit;
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LG Co</title>
	<meta charset ="utf-8">
</head>
<body>
	<h2>Reviewer <?php echo "$first $last";?> was successfully added</h2>
	<h3><a href="createReviewer.html">Add another reviewer</a><h3>
	<h3><a href="index.html">Back to Home</a></h3>
</body>
</html>

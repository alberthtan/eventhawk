<?php

	require "../config/config.php";

	// If user is not logged in
	if( !isset($_SESSION["logged_in"]) || empty($_SESSION["logged_in"]) ) {
		header("Location: ../events/home.php");
	}
	else {
		// Connect to DB
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		// Generate and submit SQL query - get user info
		$sql = "SELECT username, email, first_name, states.name AS state
		FROM users
		LEFT JOIN states
			ON states.state_id = users.state_id
		WHERE username='" . $_SESSION["username"] . "';";
		$results = $mysqli->query($sql);

		if(!$results) {
			echo $mysqli->error;
			exit();
		}

		$row = $results->fetch_assoc();
		$username = $row["username"];
		$email = $row["email"];
		$password = "hidden";
		$firstname = $row["first_name"];
		$state = $row["state"];
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Profile Info</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">

	<style>
		.buttons a {
			width: 172px;

		}
	</style>
</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Profile</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<table style="width:70%">
					<tr>
					    <th>First Name</th>
					    <td>
					    	<?php echo $firstname; ?>		
					    </td>
		  			</tr>
			  		<tr>
					    <th>Email</th>
					    <td>
					    	<?php echo $email; ?>		
					    </td>
			  		</tr>
				  	<tr>
					    <th>Username</th>
					    <td>
					    	<?php echo $username; ?>		
					    </td>
				  	</tr>
				  	<tr>
					    <th>Password</th>
					    <td>
					    	<?php echo $password; ?>		
					    </td>
				  	</tr>
				  	<tr>
					    <th>State</th>
					    <td>
					    	<?php echo $state; ?>		
					    </td>
				  	</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="container buttons">
		<div class="row mb-3">
			<div class="col-12">
				<a type="button" href="calendar.php" class="btn btn-dark">View Calendar</a>
				<a type="button" href="edit_profile.php" class="btn btn-dark ml-2">Edit Account</a>
			</div>
			<div class="col-12 mt-3">
				<a type="button" href="change_password.php" class="btn btn-dark">Change Password</a>
				<a type="button" onclick="return confirm('Are you sure you want to delete your account?');" href="delete_confirmation.php" class="btn btn-warning ml-2">Delete Account</a>
			</div>
		</div>
	</div>



	</div>












</body>
</html>
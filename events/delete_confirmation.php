<?php

require "../config/config.php";

// If user is not logged in
if( !isset($_SESSION["logged_in"]) || empty($_SESSION["logged_in"]) ) {
	header("Location: ../events/home.php");
}
else {

	// Connect to db
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	// Generate and submit SQL query
	$sql = "DELETE FROM users WHERE user_id = " . $_SESSION["user_id"] . ";";
	$results = $mysqli->query($sql);

	if(!$mysqli) {
		echo $mysqli->error;
		exit();
	}

	if($mysqli->affected_rows > 0) {
		$deleted = true;
	}




	session_destroy();

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

	<title>Delete Confirmation Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">

</head>
<body>


	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="title text-center mt-4">Account Deleted</div>
			</div>
		</div>
	</div>

	<div class="container">

		<div class="row col-12 mb-3">
			<?php if(isset($deleted) && $deleted): ?>
				<div>Your account has been successfully deleted.</div>
			<?php endif; ?>
		</div>

		<div class="row">
			<div class="col-12">
				<a href="../index.php" class="btn btn-dark">Home</a>
				<a href="../login/login.php" class="btn btn-dark ml-3">Login</a>
			</div>
		</div> 

		





	</div>


	

</body>
</html>
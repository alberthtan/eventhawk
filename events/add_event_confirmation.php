<?php

require "../config/config.php";

// If the user is not logged in
if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
	header("Location: ../login/login.php");
	exit();
}

if( !isset($_GET["event_id"]) || empty($_GET["event_id"]) ) {
	$error = "An error occurred";
}
else { // all fields were filled out
	
	// Connect to db
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	// Generate and submit SQL statement
	$statement = $mysqli->prepare("INSERT INTO events(api_id, user_id) VALUES(?, ?);");
	$statement->bind_param("si", $_GET["event_id"], $_SESSION["user_id"]);
	$statement->execute();

	if(!$statement) {
		echo $mysqli->error;
		exit();
	}

	if($statement->affected_rows == 1) {
		$added = true;
	}

	$statement->close();
	$mysqli->close();
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

	<title>Event Addition Confirmation Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">

</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Event Addition Confirmation</div>
			</div>
		</div>
	</div>

	<div class="container">
		<?php if(isset($error) && !empty($error)): ?>
			<div class="row col-12 mb-3">
				<div class="text-danger"><?php echo $error; ?></div>
			</div>
		<?php else: ?>
			<?php if(isset($added) && $added): ?>
				<div class="row col-12 mb-3">
					<div>Successfully added event!</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="container">
		<div class="row col-12">
			<a type="button" href="../index.php" class="btn btn-dark">Home</a>
			<a type="button" href="calendar.php" class="btn btn-dark ml-2">Calendar</a>
		</div>
	</div>



</body>
</html>
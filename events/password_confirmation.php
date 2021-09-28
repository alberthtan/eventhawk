<?php

require "../config/config.php";

// If the user is not logged in
if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
	header("Location: ../login/login.php");
	exit();
}

// PHP check for filled forms
if( !isset($_POST["old_password"]) || empty($_POST["old_password"]) ) {
	$error = "Please fill out all required fields";
}
else { // all fields were filled out
	
	// Connect to db
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	// Check if old password matches
	$old_password = hash("sha256", $_POST["old_password"]);
	$statement_check = $mysqli->prepare("SELECT * FROM users WHERE password=? AND user_id=?;");
	$statement_check->bind_param("si", $old_password, $_SESSION["user_id"]);
	$statement_check->execute();

	if(!$statement_check) {
		echo $mysqli->error;
		exit();
	}

	$results = $statement_check->get_result();

	if($results->num_rows == 0) {
		$error = "Incorrect password.";
	}
	else {

		// Hash password
		$password = hash("sha256", $_POST["new_password"]);
		$statement = $mysqli->prepare("UPDATE users SET password=? WHERE user_id=?;");
		$statement->bind_param("si", $password, $_SESSION["user_id"]);
		$statement->execute();

		if(!$statement) {
			echo $mysqli->error;
			exit();
		}

		if($statement->affected_rows == 1) {
			$changed = true;
		}

		$statement->close();

	}

	$statement_check->close();
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

	<title>Password Change Confirmation Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">
</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="title text-center mt-4">Password Change Confirmation</div>
			</div>
		</div>
	</div>

	<div class="container">
		<?php if(isset($error) && !empty($error)): ?>
			<div class="row col-12 mb-3">
				<div class="text-danger"><?php echo $error; ?></div>
			</div>
		<?php else: ?>
			<?php if(isset($changed) && $changed): ?>
				<div class="row col-12 mb-3">
					<div class="text-success">Successfully changed password!</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="container">
		<div class="row col-12">
			<a type="button" href="../index.php" class="btn btn-success">Home</a>
			<a type="button" href="change_password.php" class="btn btn-dark ml-2">Back</a>
		</div>
	</div>



</body>
</html>
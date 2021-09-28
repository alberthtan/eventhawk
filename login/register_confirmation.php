<?php

require "../config/config.php";

// If user is already logged in
if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] ) {
	$error = "Please log out to register.";
}
else {
	// PHP check for filled forms
	if( !isset($_POST["firstname"]) || empty($_POST["firstname"]) || !isset($_POST["username"]) || empty($_POST["username"]) || !isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["password"]) || empty($_POST["password"]) || !isset($_POST["state"]) || empty($_POST["state"])) {
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

		// Check if username is taken
		$statement = $mysqli->prepare("SELECT * FROM users WHERE username=?");
		$statement->bind_param("s", $_POST["username"]);
		$statement->execute();

		if(!$statement) {
			echo $mysqli->error;
			exit();
		}

		$results = $statement->get_result();
		if($results->num_rows > 0) {
			$error = "Username is already taken";
		}
		else {
			$password = hash("sha256", $_POST["password"]);
			$sql = $mysqli->prepare("INSERT INTO users(first_name, username, email, password, state_id) 
				VALUES(?, ?, ?, ?, ?);");
			$sql->bind_param("ssssi", $_POST["firstname"], $_POST["username"], $_POST["email"], $password, $_POST["state"]);
			$sql->execute();

			if(!$sql) {
				echo $mysqli->error;
				exit();
			}

			if($sql->affected_rows == 1) {
				$added = true;
			}

		}

		$statement->close();
		$mysqli->close();
	}
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

	<title>Register Confirmation Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">
</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Register confirmation</div>
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
					<div class="text-success">Successfully registered user!</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div class="container">
		<div class="row col-12">
			<a type="button" href="login.php" class="btn btn-success">Login</a>
			<a type="button" href="register_form.php" class="btn btn-dark ml-2">Back</a>
		</div>
	</div>



</body>
</html>
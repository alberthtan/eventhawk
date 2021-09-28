<?php

require "../config/config.php";

// If user is already logged in
if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] ) {
	header("Location: ../events/home.php");
}
else {

	if( isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["password"]) ) {

		// Connect to db
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		// hash password
		$password = hash("sha256", $_POST["password"]);
		$username = $_POST["username"];

		// Generate and submit SQL statement
		$statement = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
		$statement->bind_param("ss", $username, $password);
		$statement->execute();

		if(!$statement) {
			echo $mysqli->error();
			exit();
		}

		$results = $statement->get_result();

		if($results->num_rows > 0) {
			$_SESSION["logged_in"] = true;
			$row = $results->fetch_assoc();
			$_SESSION["firstname"] = $row["first_name"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["state_id"] = $row["state_id"];

			header("Location: ../events/home.php");
		}
		else {
			$error = "Invalid username or password";
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

	<title>Login</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">


</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Login</div>
			</div>
		</div>
	</div>

	<div class="container">
		<form id="form" action="login.php" method="POST">

			<div class="form-group row mb-3">
				<label for="username-id" class="col-3">Username:</label>
				<div class="col-9">
					<input type="text" id="username-id" name="username" class="form-control">
				</div>
			</div>

			<div class="form-group row mb-3">
				<label for="password-id" class="col-3">Password:</label>
				<div class="col-9">
					<input type="password" id="password-id" name="password" class="form-control">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="../index.php" role="button" class="btn btn-light ml-2">Cancel</a>
				</div>
			</div>

		</form>

		<div class="row">
			<div class="col-sm-9 ml-sm-auto">
				<a href="register_form.php">Don't have an account?</a>
			</div>
		</div> <!-- .row -->

		<?php if(isset($error) && !empty($error)): ?>
			<div class="row">
				<div class="col-sm-9 ml-sm-auto text-danger font-italic">
					<?php echo $error ?>
				</div>
			</div>
		<?php endif; ?>



	</div>

	<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

	<script>
		
		$("#form").on("submit", function(e) {
			if($("#username-id").val().trim().length == 0 || $("#password-id").val().trim().length == 0) {
				e.preventDefault(e);
				alert("Please fill out all required fields");
			}
		});


	</script>

	

</body>
</html>
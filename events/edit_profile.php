<?php
	require "../config/config.php";

	// If the user is not logged in
	if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
		header("Location: ../login/login.php");
	}
	else {
		// Connect to db
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		// Generate and submit SQL query - get user info
		$sql = "SELECT *
		FROM users WHERE username='" . $_SESSION["username"] . "';";
		$results = $mysqli->query($sql);

		if(!$results) {
			echo $mysqli->error;
			exit();
		}

		$sql2 = "SELECT * FROM states;";
		$results2 = $mysqli->query($sql2);

		if(!$results2) {
			echo $mysqli->error;
			exit();
		}

		$row = $results->fetch_assoc();
		$username = $row["username"];
		$email = $row["email"];
		$firstname = $row["first_name"];
		$state = $row["state_id"];

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

	<title>Edit Account Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">
</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Edit Account</div>
			</div>
		</div>
	</div>

	<div class="container">
		<form id="form" action="edit_confirmation.php" method="POST">

			<div class="form-group row mb-3">
				<label for="firstname-id" class="col-3">First Name:</label>
				<div class="col-9">
					<input type="text" id="firstname-id" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
				</div>
			</div>

			<div class="form-group row mb-3">
				<label for="email-id" class="col-3">Email:</label>
				<div class="col-9">
					<input type="text" id="email-id" name="email" class="form-control" value="<?php echo $email; ?>">
				</div>
			</div>

			<div class="form-group row mb-3">
				<label for="username-id" class="col-3">Username:</label>
				<div class="col-9">
					<input type="text" id="username-id" name="username" class="form-control" value="<?php echo $username; ?>">
				</div>
			</div>

			<input type="hidden" id="username_init-id" name="username_init" class="form-control" value="<?php echo $username; ?>">

			<div class="form-group row mb-3">
				<label for="state-id" class="col-3">State:</label>
				<div class="col-9">
					<select id="state-id" name="state" class="form-control">
						<option selected disabled>-- Please select one --</option>
						<?php while($row = $results2->fetch_assoc()): ?>
							<?php if($row['state_id'] == $state): ?>
								<option value="<?php echo $row['state_id']; ?>" selected>
									<?php echo $row['code'] . " - " . $row['name']; ?>
								</option>
							<?php else: ?>
								<option value="<?php echo $row['state_id']; ?>">
									<?php echo $row['code'] . " - " . $row['name']; ?>
								</option>
							<?php endif; ?>

						<?php endwhile; ?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Update</button>
					<a href="profile.php" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div>


		
		</form>
	</div>

	<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


	<script>
		
		$("#form").on("submit", function(e) {
			if($("#username-id").val().trim().length == 0 || $("#firstname-id").val().trim().length == 0 || $("#email-id").val().trim().length == 0) {
				e.preventDefault(e);
				alert("Please fill out all required fields");
			}
		});

	</script>



</body>
</html>
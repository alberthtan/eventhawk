<?php

require "../config/config.php";

session_destroy();



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Logout Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">

</head>
<body>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Logout</div>
			</div>
		</div>
	</div>

	<div class="container">

		<div class="row col-12 mb-5">
			<div>You have successfully logged out</div>
		</div>

		<div class="row">
			<div class="col-12">
				<a href="../index.php" class="btn btn-dark">Home</a>
				<a href="login.php" class="btn btn-dark ml-3">Login</a>
			</div>
		</div> 

		





	</div>


	

</body>
</html>
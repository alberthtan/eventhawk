<?php

	require "../config/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Search Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">

	<style>
		.buttons > * {
			width: 200px;
		}

	</style>

</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="subtitle mt-4">Search Events</div>
			</div>
		</div>
	</div>

	<?php if(isset($error) && !empty($error)): ?>
		<div class="row col-12 mb-3 ml-5 pl-5">
			<div class="text-danger"><?php echo $error; ?></div>
		</div>
	<?php else: ?>

		<div class="container">
			<form id="form" action="search_results.php" method="GET">

				<div class="form-group row mb-3">
					<label for="keyword-id" class="col-3">Keyword:</label>
					<div class="col-9">
						<input type="text" id="keyword-id" name="keyword" class="form-control">
					</div>
				</div>

				<div class="form-group row mb-3">
					<label for="city-id" class="col-3">City:</label>
					<div class="col-9">
						<input type="text" id="city-id" name="city" class="form-control">
					</div>
				</div>

				<div class="form-group row mb-3">
					<label for="start-id" class="col-6">Start Date:</label>
					<label for="end-id" class="col-6">End Date:</label>
					<div class="col-6">
						<input type="date" id="start-id" name="start" class="form-control">
					</div>
					<div class="col-6">
						<input type="date" id="end-id" name="end" class="form-control">
					</div>
				</div>

				

				<div class="form-group row">
					<div class="col-sm-12 mt-2 text-center buttons">
						<button type="submit" class="btn btn-primary mr-2">Search</button>
						<a href="../index.php" role="button" class="btn btn-dark ml-2">Cancel</a>
					</div>
				</div>


			
			</form>

		</div>
	<?php endif; ?>
</body>






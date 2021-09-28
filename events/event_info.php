<?php

	require "../config/config.php";

	if(!isset($_GET["event_id"]) || empty($_GET["event_id"]) ) {
		$error = "An error occurred";
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


	<title>Event Info Page</title>

	<link rel="stylesheet" type="text/css" href="../nav.css">

	<style>
		
		#image {
			margin-top: 10px;
			width: 100%;
		}

	

		@media(min-width: 800px) {
			.buttons a {
				width: 180px;
			}
		}



	</style>
</head>

<body>

	<?php include "../nav.php" ?>

<?php if(!isset($error) && empty($error)): ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div id="title" class="title text-center mt-4"></div>
			</div>
			<hr>
			<div class="col-12">
				<div id="date" class="subtitle text-center mt-4"></div>
			</div>
			<div class="col-sm-12 col-md-6">
				<div id="image" class="text-center"></div>
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="row">
					<div class="col-12 mt-4">
						<div id="artist" class="subtitle text-center"></div>
					</div>
					<div class="col-12 mt-1">
						<div id="city" class="text-center"></div>
					</div>
					<div class="col-12 mt-1">
						<div id="venue" class="text-center"></div>
					</div>
					<div class="col-12 mt-1">
						<div id="price_range" class="text-center"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="row">

			<div class="col-12"></div>
		</div>
	</div>

		<div class="container buttons">
			<div class="row mb-3 ">
				<div class="col-12">
					<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
						<a type="button" id="addButton" href="add_event_confirmation.php?event_id=<?php echo $_GET['event_id']; ?>" class="btn btn-dark">Add to My Calendar</a>
					<?php endif; ?>
					<a type="button" id="buyButton" href="#" class="btn btn-dark ml-2">Buy Tickets</a>
					<a type="button" href="home.php" class="btn btn-dark ml-2">Events</a>
				</div>
			</div>
		</div>

		<!-- passing the event id -->
		<input id="event_id" type="hidden" value="<?php echo $_GET['event_id']; ?>">



		</div>
	<?php else: ?>
		<div class="container">
			<div class="row col-12 mb-3">
				<div class="text-danger"><?php echo $error; ?></div>
			</div>
		</div>
	<?php endif; ?>


<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
	
	// if it is passed successfully
	if(document.getElementById("event_id")) {
		let event_id = $("#event_id").val();
		console.log(event_id);

		// make API call
		$.ajax({
			method: "GET",
			url: "https://app.ticketmaster.com/discovery/v2/events",
			data: {
				apikey: "QN3SHukBibPkxp2Iq388G9H7Ur2BDBHx",
				locale: "*",
				id: event_id
			}
		})
		.done(function(results) {
			console.log(results);
			display(results);
			// Set buttons
			if(results["_embedded"]["events"][0]["url"]) {
				$("#buyButton").attr("href", results["_embedded"]["events"][0]["url"]);
			}
			else {
				$("#buyButton").on("click", function() {
					alert("This event is not available.");
				});
			}
		})
		.fail(function() {
			console.log("ERROR!");
		})


	}


	function display(results) {
		let currentEvent = results._embedded.events[0];
		$("#title").text(currentEvent["name"]);
		$("#date").text(currentEvent["dates"]["start"]["localDate"]);
		$("#artist").text(currentEvent["_embedded"]["attractions"][0]["name"]);
		$("#city").html("<strong>City:</strong> " + currentEvent["_embedded"]["venues"][0]["city"]["name"]);
		$("#venue").html("<strong>Venue:</strong> " + currentEvent["_embedded"]["venues"][0]["name"]);
		if(currentEvent["priceRanges"]) {
			$("#price_range").html("<strong>Price Range:</strong> $" + currentEvent["priceRanges"][0]["min"] + " to $" + currentEvent["priceRanges"][0]["max"]);
		}
		$("#image").append("<img id='image' src='" + currentEvent["images"][0]["url"] + "' />");
	}







</script>







</body>
</html>
<?php

	require "../config/config.php";

	// Check inputs
	$keyword = "";
	$city = "";
	$start = "";
	$end = "";

	if( isset($_GET["keyword"]) && !empty($_GET["keyword"]) ) {
		$keyword = $_GET["keyword"];
	}
	if( isset($_GET["city"]) && !empty($_GET["city"]) ) {
		$city = $_GET["city"];
	}
	if( isset($_GET["start"]) && !empty($_GET["start"]) ) {
		$start = $_GET["start"] . "T00:00:00Z";
	}
	if( isset($_GET["end"]) && !empty($_GET["end"]) ) {
		$end = $_GET["end"]  . "T00:00:00Z";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


	<title>Search Results Page</title>

	<link rel="stylesheet" type="text/css" href="../events/home_display.css">
	<link rel="stylesheet" type="text/css" href="../nav.css">





</head>
<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="mt-4 title text-center">Search Results</div>
			</div>
		</div>
		<hr>
	</div>

	<div class="container">
		<div id="events" class="row">
			
		</div>
	</div>


<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>


	$.ajax({
		method: "GET",
		url: "https://app.ticketmaster.com/discovery/v2/events",
		data: {
			apikey: "QN3SHukBibPkxp2Iq388G9H7Ur2BDBHx",
			locale: "*",
			size: 100,
			keyword: '<?php echo $keyword; ?>',
			city: '<?php echo $city; ?>',
			startDateTime: '<?php echo $start; ?>',
			endDateTime: '<?php echo $end; ?>',
			sort: "relevance,desc"
		}
	})
	.done(function(results) {
		console.log(results);
		display(results);
	})
	.fail(function() {
		console.log("ERROR!");
	})

	function display(results) {

		console.log(results.page.totalElements);
		for(let i=0; i < Math.min(results.page.totalElements, results.page.size); i++) {
			let currentEvent = results._embedded.events[i];

		 	let newDiv = document.createElement("div");
		 	newDiv.classList.add("col-sm-12");
		 	newDiv.classList.add("col-md-6");
		 	newDiv.classList.add("col-lg-4");
		 	newDiv.classList.add("mt-5");

		 	let header = document.createElement("h2");
		 	header.innerHTML = currentEvent["name"];
		 	header.classList.add("text-center");
		 	newDiv.appendChild(header);

		 	let imageDiv = document.createElement("div");
		 	imageDiv.classList.add("imageDiv");
		 	imageDiv.onclick = function() {
		 		window.location.href = "event_info.php?event_id=" + currentEvent["id"];
		 	}

		 	let image = document.createElement("img");
		 	image.src = currentEvent["images"][0]["url"];
		 	image.style.width = "100%";
		 	imageDiv.appendChild(image);

		 	newDiv.appendChild(imageDiv);

		 	let dateDiv = document.createElement("div");
		 	dateDiv.classList.add("dateDiv");
		 	dateDiv.innerHTML = currentEvent["dates"]["start"]["localDate"];
		 	imageDiv.appendChild(dateDiv);

		 	let cityDiv = document.createElement("div");
		 	cityDiv.classList.add("cityDiv");
		 	cityDiv.innerHTML = currentEvent["_embedded"]["venues"][0]["city"]['name'];
		 	imageDiv.appendChild(cityDiv);


		 	document.querySelector("#events").appendChild(newDiv);
		}
	}








</script>

</body>
</html>












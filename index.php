<?php

	require "config/config.php";


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


	<title>Home page</title>

	<link rel="stylesheet" type="text/css" href="events/home_display.css">
	<link rel="stylesheet" type="text/css" href="nav.css">

	<style>
		.description {
			font-family: vogue;
			src: url("../fonts/Savoy_Bold.tff");
			font-size: 25px;
			font-style: italic;
			margin-bottom: 10px;
		}
	</style>

	




</head>
<body>

	<nav class="nav-bar navbar-expand-md container-fluid p-2">
		<div class="row">
			<div class="col-3 justify-content-center d-flex">
				<h3 class="btn text-left vogue-text nohover">Event Hawk</h3>
			</div>
			<div class="col-6 justify-content-center d-flex">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="events/home.php">EVENTS</a>
					</li>
					
				<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
					<li class="nav-item">
						<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="events/profile.php">PROFILE</a>
					</li>
				<?php endif; ?>
				<li class="nav-item">
						<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="events/search_form.php">SEARCH</a>
					</li>
				</ul>
			</div>
			<div class="col-3 justify-content-center d-flex">
				<?php if(!isset($_SESSION["logged_in"]) || empty($_SESSION["logged_in"])): ?>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="login/login.php">LOGIN</a>
					</li>
				</ul>
				<?php else: ?>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="login/logout.php">LOGOUT</a>
					</li>
					<li class="nav-item">
						<a class="btn vogue-text nav-link ml-2 mr-2 nohover">Hello,&nbsp<?php echo $_SESSION["firstname"]; ?></a>
					</li>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</nav>
	<hr>


	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="mt-4 title text-center">Welcome to Event Hawk!</div>
			</div>
			<hr>
			<div class="col-12">
				<h1 class="mt-4 description text-center">Find the best events and personalize your calendar page...</h1>
			</div>
		</div>
	</div>
	<div class="mt-5 mb-5">

	<div class="container">
		<div id="events" class="row">
			<div class="col-12 mt-5">
				<div class="mt-3 subtitle text-center">Discover A New Event!</div>
			</div>

			<div class="col-3"></div>
			
		</div>
	</div>



<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>

	// Get random event

	// make API call
	$.ajax({
		method: "GET",
		url: "https://app.ticketmaster.com/discovery/v2/events",
		data: {
			apikey: "QN3SHukBibPkxp2Iq388G9H7Ur2BDBHx",
			locale: "*",
			size: 100,
			sort: "random"
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

		let currentEvent = results._embedded.events[randomNum(100)];

	 	let newDiv = document.createElement("div");
	 	newDiv.classList.add("col-6");
	 	newDiv.classList.add("justify-content-center")

	 	let header = document.createElement("h2");
	 	header.innerHTML = currentEvent["name"];
	 	header.classList.add("text-center");
	 	newDiv.appendChild(header);

	 	let imageDiv = document.createElement("div");
	 	imageDiv.classList.add("imageDiv");
	 	imageDiv.onclick = function() {
	 		window.location.href = "events/event_info.php?event_id=" + currentEvent["id"];
	 	}

	 	try {
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
		 }
		 catch(err) {

		 }


	 	document.querySelector("#events").appendChild(newDiv);
	}

	function randomNum(limit){
	    max = Math.floor(limit);
	    return Math.floor(Math.random() * (max + 1));
	}





</script>

</body>
</html>












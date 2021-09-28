<?php

require "../config/config.php";

// If the user is not logged in
if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
	header("Location: ../login/login.php");
	exit();
}

// Delete item if any

// Connect to DB
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($mysqli->connect_errno) {
	echo $mysqli->connect_error;
	exit();
}
$mysqli->set_charset('utf8');


if(isset($_GET["delete"]) && !empty($_GET["delete"])) {
	$delete_sql = "DELETE FROM events WHERE user_id = " . $_SESSION["user_id"] . " AND api_id = '" . $_GET["event_id"] . "';";
	$delete_results = $mysqli->query($delete_sql);
	if(!$delete_results) {
		echo $mysqli->error;
		exit();
	}
}

// SQL query for delete



// Generate and submit SQL query to get all events for user
$sql = "SELECT * FROM events WHERE user_id = " . $_SESSION["user_id"] . ";";
$results = $mysqli->query($sql);

if(!$results) {
	echo $mysqli->error;
	exit();
}

$mysqli->close();


?>


<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


	<title>Calendar Page</title>

	<link rel="stylesheet" type="text/css" href="../events/home_display.css">
	<link rel="stylesheet" type="text/css" href="../nav.css">

<style>

		.newDiv {
			position: relative;
		}

		.material-icons {
			position: absolute;
			top: 0px;
			right: 0px;
			visibility: hidden;
		}

		.material-icons:hover {
			cursor: pointer;
		}

		.newDiv:hover .material-icons {
			visibility: visible;
		}

		.newDiv:hover .dateDiv, .newDiv:hover .cityDiv {
			visibility: visible;
		}


</style>

</head>

<body>

	<?php include "../nav.php" ?>

	<div class="container">
		<div class="row mb-3">
			<div class="col-12">
				<div class="title text-center mt-4">Calendar</div>
			</div>
		</div>
		<hr>
	</div>

	<div class="container">
		<div id="events" class="row">
			
		</div>
	</div>




<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>

// Get data from PHP
let events = [
    <?php
        while ($row = $results->fetch_assoc()) {
            $event_id = $row["api_id"];
            echo "'$event_id',";
        }
    ?>
];

console.log(events);


// make API calls

for(let i=0; i < events.length; i++) {
	$.ajax({
		method: "GET",
		url: "https://app.ticketmaster.com/discovery/v2/events",
		data: {
			apikey: "QN3SHukBibPkxp2Iq388G9H7Ur2BDBHx",
			locale: "*",
			id: events[i]
		}
	})
	.done(function(results) {
		console.log(results);
		display(results);
	})
	.fail(function() {
		console.log("ERROR!");
	})
}

function display(results) {

	console.log(results.page.size);
	let currentEvent = results._embedded.events[0];

 	let newDiv = document.createElement("div");
 	newDiv.classList.add("col-sm-12");
 	newDiv.classList.add("col-md-6");
 	newDiv.classList.add("col-lg-4");
 	newDiv.classList.add("mt-5");
 	newDiv.classList.add("p-2");
 	newDiv.classList.add("newDiv");
 	newDiv.style.border = "1px solid black";

 	let header = document.createElement("h2");
 	header.innerHTML = currentEvent['name'];
 	header.classList.add("text-center");
 	newDiv.appendChild(header);

 	let imageDiv = document.createElement("div");
 	imageDiv.classList.add("imageDiv");
 	imageDiv.onclick = function() {
 		window.location.href = "event_info.php?event_id=" + currentEvent["id"];
 	}
 	newDiv.appendChild(imageDiv);

 	let image = document.createElement("img");
 	image.src = currentEvent["images"][0]["url"];
 	image.style.width = "100%";
 	imageDiv.appendChild(image);

 	let dateDiv = document.createElement("div");
 	dateDiv.classList.add("dateDiv");
 	dateDiv.innerHTML = currentEvent["dates"]["start"]["localDate"];
 	imageDiv.appendChild(dateDiv);

 	let cityDiv = document.createElement("div");
 	cityDiv.classList.add("cityDiv");
 	cityDiv.innerHTML = currentEvent["_embedded"]["venues"][0]["city"]['name'];
 	imageDiv.appendChild(cityDiv);

 	let deleteIcon = document.createElement("i");
 	deleteIcon.classList.add("material-icons");
 	deleteIcon.innerHTML = "delete";
 	deleteIcon.addEventListener("click", deleteFunction, false);
 	deleteIcon.myParam = currentEvent["id"];

 	newDiv.appendChild(deleteIcon);


 	document.querySelector("#events").appendChild(newDiv);

}


	function deleteFunction(event_id) {
		<?php 
			// Connect to DB
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}
			$mysqli->set_charset('utf8');



			$mysqli->close();




		?>

		console.log(event_id.currentTarget.myParam);
		window.location.href = "calendar.php?delete='set'&event_id=" + event_id.currentTarget.myParam;
	}


	
</script>

</body>
</html>











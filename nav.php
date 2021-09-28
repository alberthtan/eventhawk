<nav class="nav-bar navbar-expand-md container-fluid p-2">
	<div class="row">
		<div class="col-3 justify-content-center d-flex">
			<a class="btn text-left vogue-text vogue-hover" href="../index.php">Event Hawk</a>
		</div>
		<div class="col-6 justify-content-center d-flex">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="../events/home.php">EVENTS</a>
				</li>
				
			<?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
				<li class="nav-item">
					<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="../events/profile.php">PROFILE</a>
				</li>
			<?php endif; ?>
			<li class="nav-item">
					<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="../events/search_form.php">SEARCH</a>
				</li>
			</ul>
		</div>
		<div class="col-3 justify-content-center d-flex">
			<?php if(!isset($_SESSION["logged_in"]) || empty($_SESSION["logged_in"])): ?>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="../login/login.php">LOGIN</a>
				</li>
			</ul>
			<?php else: ?>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="btn vogue-text vogue-hover nav-link ml-2 mr-2" href="../login/logout.php">LOGOUT</a>
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
<?php
	$filepath = realpath(dirname(__FILE__));
	include_once $filepath."/../lib/Session.php";
	Session::init(); 
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login Register System PHP</title>
	<link rel="stylesheet" href="inc/bootstrap.min.css" />
	<script type="text/javascript" src="inc/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="inc/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
	if (isset($_GET['action']) && $_GET['action']=="logout") {
		Session::destroy();
	}
?>

<body>
	<div class="container">
		<!--main menu start-->
		<nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
			<div class="container-fluid">
				<a href="index.php" class="navbar-brand text-primary">Login Register System</a>
				<ul class="navbar-nav">
					<?php
						$id = Session::get("id");
						$userlogin = Session::get("login");
						if ($userlogin==true) {
					?>
					<li class="nav-item"> <a class="nav-link text-primary" href="index.php">Home</a></li>
					<li class="nav-item"> <a class="nav-link text-primary" href="profile.php?id=<?php echo $id; ?>">Profile</a></li>
					<li class="nav-item"> <a class="nav-link text-primary" href="?action=logout">Logout</a></li>
					<?php
						} else {
					?>
					<li class="nav-item"> <a class="nav-link text-primary" href="login.php">Login</a></li>
					<li class="nav-item"> <a class="nav-link text-primary" href="register.php">Register</a></li>
					<?php
						}
					?>
				</ul>
			</div>
		</nav>
		<!--main menu end-->
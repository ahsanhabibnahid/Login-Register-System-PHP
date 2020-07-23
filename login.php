<?php
	include 'inc/header.php';
	include 'lib/User.php';
	Session::checkLogin();
?>
<?php
$user = new User();
if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST["login"])) {
	$userLogin = $user -> userLogin($_POST);
}
?>

<div class="card mt-5">
	<div class="card-header">
				<h2>User Login</h2>
	</div>
	<div style="width:500px; margin: 0 auto;">
<?php
	if (isset($userLogin)){
		echo $userLogin;
	}
?>
		<form action="" method="POST">
			<div class="form-group">
				<label class="mt-3" for="email">Email Address</label>
				<input class="form-control" type="email" name="email" id="email"  />
			</div>
			<div class="form-group">
				<label for="Password">Password</label>
				<input class="form-control" type="password" name="password" id="password"  />
			</div>
			<button class="btn btn-success mb-5" type="submit" name="login">Login</button>
		</form>
	</div>
</div>




<?php
	include 'inc/Footer.php';
?>
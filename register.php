<?php
	include 'inc/header.php';
	include 'lib/User.php';
?>
<?php
$user = new User();
if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST["register"])) {
	$userRegister = $user -> userRegistration($_POST);
}
?>


<div class="card mt-5">
	<div class="card-header">
				<h2>User Registration</h2>
	</div>
	<div style="width:500px; margin: 0 auto;">
<?php
	if (isset($userRegister)) {
		echo $userRegister;
	}
?>
		<form action="" method="POST">
			<div class="form-group">
				<label class="mt-3" for="name">Your Name</label>
				<input class="form-control" type="text" name="name" id="name"  />
			</div>
			<div class="form-group">
				<label class="mt-3" for="username">User Name</label>
				<input class="form-control" type="text" name="username" id="username"  />
			</div>
			<div class="form-group">
				<label class="mt-3" for="email">Email Address</label>
				<input class="form-control" type="email" name="email" id="email"  />
			</div>
			<div class="form-group">
				<label for="Password">Password</label>
				<input class="form-control" type="password" name="password" id="password"  />
			</div>
			<button class="btn btn-success mb-5" type="submit" name="register">Submit</button>
		</form>

	</div>
</div>




<?php
	include 'inc/Footer.php';
?>
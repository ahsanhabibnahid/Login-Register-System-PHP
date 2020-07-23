<?php
	include 'lib/User.php';
	include 'inc/header.php';
	Session::checkSession();
?>

<?php
	if (isset($_GET["id"])) {
		$userid = (int)$_GET["id"];
		$sessId = Session::get("id");
		if ($userid != $sessId) {
			header("Location: index.php");
		}
	}
	$user = new User();
	if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST["updatepass"])) {
	$updatepass = $user -> updatePassword($userid,$_POST);
}
?>

<div class="card mt-5">
	<div class="card-header">
			<h2>Change Password <span class="float-right text-success"><a class="btn btn-primary" href="profile.php?id=<?php echo $userid; ?>">Back</a></span> </h2>
	</div>
	<div style="width:500px; margin: 0 auto;">
<?php
	if (isset($updatepass)) {
		echo $updatepass;
	}
?>

		<form action="" method="POST">
			<div class="form-group">
				<label class="mt-3" for="old_pass">Old Password</label>
				<input class="form-control" type="password" name="old_pass" id="old_pass" />
			</div>
			<div class="form-group">
				<label class="mt-3" for="password">New Password</label>
				<input class="form-control" type="password" name="password" id="password" />
			</div>

			<button class="btn btn-success mb-5" type="submit" name="updatepass">Update</button>
		</form>
		
	</div>
</div>




<?php
	include 'inc/Footer.php';
?>
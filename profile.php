<?php
	include 'lib/User.php';
	include 'inc/header.php';
	Session::checkSession();
?>

<?php
	if (isset($_GET["id"])) {
		$userid = (int)$_GET["id"];
	}
	$user = new User();
	if ($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST["update"])) {
	$updateusr = $user -> updateUserData($userid,$_POST);
}
?>

<div class="card mt-5">
	<div class="card-header">
			<h2>User Profile <span class="float-right text-success"><a class="btn btn-primary" href="index.php">Back</a></span> </h2>
	</div>
	<div style="width:500px; margin: 0 auto;">
<?php
	if (isset($updateusr)) {
		echo $updateusr;
	}
?>
<?php
	$userdata = $user->getUserById($userid);
	if ($userdata) {

?>
		<form action="" method="POST">
			<div class="form-group">
				<label class="mt-3" for="name">Your Name</label>
				<input class="form-control" type="text" name="name" id="name" value="<?php echo $userdata->name;?>" />
			</div>
			<div class="form-group">
				<label class="mt-3" for="username">User Name</label>
				<input class="form-control" type="text" name="username" id="username" value="<?php echo $userdata->username;?>" />
			</div>
			<div class="form-group">
				<label class="mt-3" for="email">Email Address</label>
				<input class="form-control" type="email" name="email" id="email" value="<?php echo $userdata->email;?>" />
			</div>
<?php
	$sessId = Session::get("id");
	if ($userid == $sessId) {	
	
?>
			<button class="btn btn-success mb-5" type="submit" name="update">Update</button>
			<a class="btn btn-info  mb-5" href="changepass.php?id=<?php echo $userid; ?>">Password Change</a>
<?php }?>
		</form>
<?php
	}
?>		
	</div>
</div>




<?php
	include 'inc/Footer.php';
?>
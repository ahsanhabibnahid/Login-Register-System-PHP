<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	Session::checkSession();
?>
<?php
	$loginmsg = Session::get("loginmsg");
	if (isset($loginmsg)) {
		echo $loginmsg;
	}
	Session::set("loginmsg", NULL);
	
?>

		<div class="card mt-5">
			<div class="card-header">
				<h2>User list <span class="float-right text-success">Welcome!<b>
				<?php
					$name = Session::get("username");
					if (isset($name)) {
						echo $name;
					}
				?>
				</b></span> </h2>
			</div>
			<div class="card-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Serial</th>
							<th scope="col">Name</th>
 							<th scope="col">Username</th>
							<th scope="col">E-mail Address</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
<?php	 
	$user = new User();
	$userdata = $user->getUserData();
	if ($userdata) {
		$i=0;
		foreach ($userdata as $sdata) {
		$i++;
?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $sdata['name'] ; ?></td>
							<td><?php echo $sdata['username'] ; ?></td>
							<td><?php echo $sdata['email'] ; ?></td>
							<td>
								<a class="btn btn-primary" href="profile.php?id=<?php echo $sdata['id'] ; ?>">View</a>
							</td>
						</tr>
<?php } } else{ ?>
	<tr><td colspan="5"><h2>No data found...</h2></td></tr>
<?php }?>
					</tbody>
				</table>
			</div>
		</div>

<?php
	include 'inc/Footer.php';
?>
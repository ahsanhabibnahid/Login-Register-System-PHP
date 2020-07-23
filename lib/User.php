<?php 
	
	include_once "lib/Session.php";
	include 'lib/Database.php';

	class User{
		private $db;
		function __construct()
		{
			$this->db = new Database();
		}
		public function userRegistration($data){
			$name     = $data["name"];
			$username = $data["username"];
			$email    = $data["email"];
			$password = $data["password"];
			$chk_email = $this->emailCheck($email);


			if ($name=="" OR $username=="" OR $email=="" OR $password=="") {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> field must not be empty</div>";
				return $msg;
			}
			if (strlen($username)<3) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Username is too short</div>";
				return $msg;
			}
			elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Username must only a-z, 0-9, _,/</div>";
			}
			if (filter_var($email,FILTER_VALIDATE_EMAIL)==false) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address not valid!</div>";
				return $msg;
			}
			if ($chk_email == true) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Email already exist!</div>";
				return $msg;
			}

			$sql = "insert into table_user (name,username,email,password) values(:name,:username,:email,:password)";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":name",$name);
			$query -> bindValue(":username",$username);
			$query -> bindValue(":email",$email);
			$query -> bindValue(":password",$password);
			$result = $query->execute();
			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success!</strong> You have been register!</div>";
				return $msg;
			}
			else{
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Sorry there have been problem inserting your details !</div>";
				return $msg;
			}
		}

		public function emailCheck($email){
			$sql = "select email from table_user where email=:email";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":email",$email);
			$query -> execute();
			if ($query->rowCount() >0 ) {
				return true;
			}
			else{
				return false;
			}
		}

		public function getLoginUser($email,$password){
			$sql = "select * from table_user where email=:email AND password=:password limit 1";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":email",$email);
			$query -> bindValue(":password",$password);
			$query -> execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result; 	
		}

		public function userLogin($data){
			$email    = $data["email"];
			$password = $data["password"];
			$chk_email = $this->emailCheck($email);

			if ($email=="" OR $password=="") {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> field must not be empty</div>";
				return $msg;
			}
			if (filter_var($email,FILTER_VALIDATE_EMAIL)==false) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address not valid!</div>";
				return $msg;
			}
			if ($chk_email == false) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Email not exist!</div>";
				return $msg;
			}
			$result = $this->getLoginUser($email,$password);
			if ($result) {
				Session::init();
				Session::set("login", true);
				Session::set("id", $result->id);
				Session::set("name", $result->name);
				Session::set("username", $result->username);
				Session::set("loginmsg", "<div class='alert alert-success'><strong>Success!</strong> You are logged in!</div>");
				header("Location:index.php");
			}
			else{
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Data not found!</div>";
				return $msg;
			}
		}

		public function getUserData(){
			$sql = "select * from table_user order by id desc";
			$query = $this->db->pdo->prepare($sql);
			$query -> execute();
			$result = $query-> fetchAll();
			return $result;
		}
		public function getUserById($id){
			$sql = "select * from table_user where id=:id limit 1";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":id",$id);
			$query -> execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		public function updateUserdata($id, $data){
			$name     = $data["name"];
			$username = $data["username"];
			$email    = $data["email"];
			
			if ($name=="" OR $username=="" OR $email=="") {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> field must not be empty</div>";
				return $msg;
			}
			
			$sql = " update table_user set
						name     = :name,
						username = :username,
						email    = :email
						where id = :id";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":name",$name);
			$query -> bindValue(":username",$username);
			$query -> bindValue(":email",$email);
			$query -> bindValue(":id",$id);
			$result = $query->execute();
			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success!</strong> User data update successfully!</div>";
				return $msg;
			}
			else{
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Sorry User data not updated!</div>";
				return $msg;
			}
		}
		private function checkPassword($id, $old_pass){
			$password = $old_pass;
			$sql = "select password from table_user where id=:id AND password=:password  ";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":id",$id);
			$query -> bindValue(":password",$password);
			$query -> execute();
			if ($query->rowCount() >0 ) {
				return true;
			}
			else{
				return false;
			}
		}

		public function updatePassword($id,$data){
			$old_pass = $data['old_pass'];
			$new_pass = $data['password'];
			$chk_pass = $this->checkPassword($id, $old_pass);
			if ($old_pass=="" OR $new_pass=="") {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Field must not be empty!</div>";
				return $msg;
			}
			
			if ($chk_pass==false) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Old password not exist!</div>";
			return $msg;
			}
			if (strlen($new_pass)<6) {
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Password is too short!</div>";
				return $msg;
			}
			$password = $new_pass;
			$sql = " update table_user set
						password     = :password
						where id = :id";
			$query = $this->db->pdo->prepare($sql);
			$query -> bindValue(":password",$password);
			$query -> bindValue(":id",$id);
			$result = $query->execute();
			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Success!</strong> Password updated successfully!</div>";
				return $msg;
			}
			else{
				$msg = "<div class='alert alert-danger'><strong>Error!</strong> Password not updated!</div>";
				return $msg;
			}
			
		}



	}

?>
<?php 

	class Database{
		private $hostdb = "localhost";
		private $userdb = "root";
		private $namedb = "login_register";
		private $passdb = "";
		public $pdo;
		function __construct(){
			if (!isset($this->pdo)) {
				try {
					$link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb,$this->userdb,$this->passdb);
					$link->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$this->pdo = $link;
				} catch (PDOException $e) {
					die("failed connection".$e->getMessage());
				}
			}
		}
	}
 
?>
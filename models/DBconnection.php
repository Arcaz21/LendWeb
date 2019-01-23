<?php 
	class DBconnection {
		protected $conn;
		function __construct() {
			// Database credentials
			$dbhost = "localhost:3306";
			$dbuser = "root";
			$dbpass = "";
			$dbname = "lendweb";
			
			$this->conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
			if(!$this->conn) {
				echo "<strong> ERROR </strong>".mysql_error($this->conn);
			}
		}
		function close(){
			mysqli_close($this->conn);
		}
	}
?>
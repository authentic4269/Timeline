<?php
	class SqlControllerClass
	{
		// db info
		private $host = 'localhost';
		private $port = '8889';
		private $dbName = 'timeline';
		private $user = 'root';
		private $password = 'root';
		
		public $connected = FALSE;
		public $message = '';
		
		private $connection = NULL;
		
		public function SqlControllerClass($host, $port, $dbName, $user, $password) {
			if(!empty($host))
				$this->host = $host;
			if(!empty($port))
				$this->port = $port;
			if(!empty($dbName))
				$this->dbName = $dbName;
			if(!empty($user))
				$this->user = $user;
			if(!empty($password))
				$this->password = $password;
			
			$this->connection = mysqli_connect("localhost", "root", "root");
			mysqli_select_db($this->connection, "timeline");
			mysqli_set_charset($this->connection, "utf8");
			
			if(!$this->connection) {
				$this->connected = FALSE;
				throw new Exception('Connection error: ' . mysqli_connect_errno());
			}
			else
			{
				$this->connected = TRUE;
				$this->message = '';
			}
		}
		
		function __destruct() {
			if($this->connection) {
				mysqli_close($this->connection);
			}
		}
		
		public function esc($v,$q=true){
			if(is_numeric($v)) {
				return $v;
			}
			elseif(get_magic_quotes_gpc()) {
				$v=stripslashes($v);
			}

			$v = mysqli_real_escape_string($this->connection, $v);

			if($q) {

				return "'".$v."'";
			}
			return $v;
		}
		
		public function query($queryString, &$id = 0) {
			$res = mysqli_query($this->connection, $queryString);
			
			if (!$res) {
				throw new Exception('Wrong query: ' . mysqli_error($this->connection));
			}
			
			$result = array();
			
			if(is_bool($res))
			{
				$result = $res;
			}
			else
			{
				while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
					array_push($result, $row);
				}
				
				mysqli_free_result($res);
			}
			
			$id = mysqli_insert_id($this->connection);
			
			return $result;
		}
	}

	$sqlController = new SqlControllerClass($HOST, $PORT, $DB_NAME, $USER, $PASSWORD);
?>
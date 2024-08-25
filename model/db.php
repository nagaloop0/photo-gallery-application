<?php

// README:: 
class db {
	static $conn = null;
	static $instance = null;

	/**
	 * check and connect to database
	 */
	protected function connect(){
		global $servername;
		global $username;
		global $password;
		global $dbname;

		if (self::$conn == null) {
			try {
				self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				// set the PDO error mode to exception
				self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}

	/**
	 * check db connection because relying on static variables
	 */
	protected function checkConnection(){
		if (self::$conn == null) {
			$this->connect();
		}
	}

	/**
	 * Singletone approach
	 */
	public static function getConnection() {

		// self create instance of this class ie. "db" class
		// new db();
		if(self::$instance == null){
			self::$instance = new self;
		}
		self::$instance->connect();
		return self::$instance;
	}

	public function pquery(string $sql = "", $params = array()) {
		if (empty($sql)) return null;

		$this->checkConnection();

		$result = self::$conn->prepare($sql);
		$result->execute($params);

		return $result;

		// $result = self::$conn->query($sql);
		// $fetch = $result->fetchAll();
		// // and somewhere later:
		// foreach ($fetch as $row) {
		// 	echo $row['username']."<br />\n";
		// }
	}

	public function fetch_row_assoc($result){
		return $result->fetch(PDO::FETCH_ASSOC);
	}

	public function lastInsertId(){
		$this->checkConnection();

		return self::$conn->lastInsertId();
	}
}


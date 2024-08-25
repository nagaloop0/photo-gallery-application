<?php

function logger($obj){
	return null;
	file_put_contents("me.log", var_export($obj, true), 8);
	file_put_contents("me.log", "\n", 8);
}

/*
* Main driver class for the application.
*/
class AppController {
	/*
* Restricted constructor to enable singleton pattern outside the class.
*/
	private function __construct() {
	}
	/*
* Inner helper function to send file content as HTML response.
*/
	public function send_html_file($file) {
		$this->send_html(file_get_contents($file));
	}

	/*
* Inner helper function to send content as HTML response.
*/
	public function send_html($html) {
		header("Content-type: text/html;charset=utf-8");
		echo $html;
	}
	/*
	* Inner handler function to read sub-directories under storage directory.
	* Each sub-directory is an album that will hold its photos.
	* Returns list of albumn names.
	*/
	public function list_albums($req) {
		$folders = glob("storage/*");
		$albums = [];
		foreach ($folders as $folder) {
			$albums[] = str_replace("storage/", "", $folder);
		}
		return $albums;
	}

	
	/*
	* Inner handler function to create album sub-directory under storage.
	*/
	public function make_new_album($req) {
		$album_name = $req["album_name"];

		if (!file_exists("storage/$album_name")) {
			mkdir("storage/$album_name", 0777, true);
		}
		return $album_name;
	}

	public function login($req) {
		if (!isset($_SESSION["username"])) {
			AppView::render("login.twig");
			exit();
		} else {
			AppView::render("home.twig");
			exit();
		}
	}

	/**
	 * Authenticate the give username and password.
	 * Password is checked using hashing method.
	 * given password vs stored hash password
	 */
	public function authenticate($req) {
		if (!isset($req["username"]) || !isset($req["password"])) {
			AppView::render("invalid.twig", array("error" => "Username/password is empty"));
			exit();
		}

		$db = db::getConnection();
		$result = $db->pquery("SELECT * FROM users WHERE username = ? LIMIT 1", array($req["username"]));
		if ($result->rowCount() == 0) {
			AppView::render("invalid.twig", ["error"=>"Permission denied"]);
			die;
		} else {	
			$hashedPassword = "";

			// get hashpassword and verify
			$row = $db->fetch_row_assoc($result);
			if($row){
				$hashedPassword = $row["password"];
				$userid = $row["id"];
			}

			/**
			 * README: Hashed using BCRYPT
			 * password_verify is inbuilt function to verify user plain password vs. stored hash password
			 */
			if(password_verify($req["password"], $hashedPassword)){
				$_SESSION["username"] = $req["username"];
				$_SESSION["userid"] = $userid;
				AppView::render("home.twig");
			}else{
				AppView::render("login.twig", ["error"=>"Incorrect denied"]);
			}
		}
	}

	public static function generateQuestionMarks($input){
		$count = count($input);
		$filledBucket = array_fill(0, $count, "?");
		return implode(",", $filledBucket);
	}

	/**
	 * Get the list of journal + images
	 * @param mixed $req
	 * 
	 * @return array
	 */
	public function list_journal($req) {
		// TODO: get images also
		// $folders = glob("storage/*");
		$journal = [];

		/**
		 * README: Below data display in this structure
		 {
			"180": {
				title:
				photos: []
			}
			}
		 */

		if(empty($_SESSION["userid"])){
			throw new Exception("Permission Denied", 403);
		} 

		$currentUserId = $_SESSION["userid"];
		$db = db::getConnection();
		$sql = "SELECT * FROM journal WHERE userid = ?";
		$params = array($currentUserId);

		// Get by journal-id
		if(!empty($req["id"])){
			$sql.= " AND id = ?";
			$params[] = $req["id"];
		}

		// search journal from title or content
		if(!empty($req["search"])){
			$sql.= " AND (title LIKE ? OR content LIKE ?)";
			$params[] = "%".$req["search"]."%";
			$params[] = "%".$req["search"]."%";
		}
		$result = $db->pquery($sql, $params);
		// echo json_encode($result->debugDumpParams());

		/**
		 * README: 
		 * Ref: https://www.ibm.com/docs/en/db2/11.5?topic=rqrs-fetching-rows-columns-from-result-sets
		 * By default fetch uses PDO::FETCH_BOTH that returns index + heading
		 * PDO::FETCH_ASSOC - Returns an array indexed by column name as returned in your result set.
		 */
		if ($result->rowCount()) {
			while ($row = $db->fetch_row_assoc($result)) { 
				$journalId = $row["id"];
				$row["photos"] = array();
				$journal[$journalId] = $row;
			}
		}

		// get the photos linked to the journal
		if($journal){
			$ids = array_keys($journal); // [100, 101, 102, 103,104]
			$photoRes = $db->pquery("SELECT * FROM photos WHERE (photo_name IS NOT NULL AND TRIM(photo_name) <> '') AND journal_id IN (" . self::generateQuestionMarks($ids) . ")", $ids);
			while ($row = $db->fetch_row_assoc($photoRes)) {
				$journalId = $row["journal_id"];
				$row["photo_name"] = "storage/".$row["photo_name"];
				$journal[$journalId]["photos"][] = $row;
			}
		}

		$journal = array_values($journal);

		return $journal;
	}

	/**
	 * Edit/Create. if ID is passed then edit else create
	 * @param array $req
	 * @param array $files
	 * 
	 */
	public function edit_journal($req, $files) {

		// $mandatoryFields = array("title", "content");
		if(empty($req["title"])){
			return array("error" => "Title is mandatory");
		}

		if(empty($_SESSION["userid"])){
			return array("error" => "Permission Denied");
		} 
		
		$currentUserId = $_SESSION["userid"];

		$db = db::getConnection();

		// editview
		$journalId = !empty($req["id"]) ? $req["id"] : false;

		logger($journalId);

		if(!$journalId){
			/**
			 * files are mandatory for Create record
			 */
			if (empty($files)) {
				return array("error" => "Image not provided");
			}

			logger(__LINE__);

			// files
			if (empty($files)) {
				return array("error" => "Photos are mandatory");
			}

			logger(__LINE__);

			// Duplicate title check
			$result = $db->pquery("SELECT 1 FROM journal WHERE LOWER(title) = ? LIMIT 1", array($req["title"]));
			$count = $result->rowCount();
			if ($count) {
				return array("error" => "Title Already exists");
			}

			logger(__LINE__);

			// TODO: multiple photos
			if (!empty($files)) {
				logger(__LINE__);

				$uploadedPhoto = $files["photo"];
				// $photoName = $req["title"] . ((string)time());

				// Get the file extension
				$fileExtension = strtolower(pathinfo($uploadedPhoto['name'], PATHINFO_EXTENSION));

				// Specify allowed image extensions
				$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

				if(!in_array($fileExtension, $allowedExtensions)) {
					return ["error" => "Error: Invalid image format. Only GIF, JPEG, SVG and PNG images are allowed."];
				}

				$photoName = $uploadedPhoto["name"];
				if (!file_exists("storage/$photoName")) {
					move_uploaded_file(
						$uploadedPhoto["tmp_name"],
						"storage/$photoName"
					);
				}
				logger(__LINE__);
			}

			logger(__LINE__);

			$db->pquery("INSERT INTO journal (title, content, userid, createdtime, modifiedtime) VALUES (?,?,?,?,?)", array($req["title"], $req["content"], $currentUserId, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));

			// README: we need this later to link for photos table 
			$createdId = $db->lastInsertId(); 
			logger(__LINE__);
			logger($createdId);

	
			$db->pquery("INSERT INTO photos (journal_id, photo_name,createdtime) VALUES (?,?,?)", array($createdId, $photoName, date("Y-m-d H:i:s")));	
			logger(__LINE__);

		}else{

			// Get the existing images

			/**
			 * When new files are uploaded then removed existing ones
			 */
			if (!empty($files)) {
				$result = $db->pquery("SELECT photo_name FROM photos WHERE journal_id = ?", array($journalId));
				$photos = [];

				while ($row = $db->fetch_row_assoc($result)) {
					$photos[] = $row["photo_name"];
				}

				// README::remove all the images from storage

				if ($photos) {
					foreach ($photos as $photo) {
						$photo = "storage/" . $photo;
						if (file_exists($photo)) {
							// Attempt to delete the file
							if (unlink($photo)) {
							}
						}
					}
				}

				// WIpe the info in DB
				$db->pquery("DELETE FROM photos WHERE journal_id = ?", array($journalId));

				// Update new photos
				$uploadedPhoto = $files["photo"];
				// $photoName = $req["title"] . ((string)time());

				$photoName = $uploadedPhoto["name"];
				if (!file_exists("storage/$photoName")) {
					move_uploaded_file(
						$uploadedPhoto["tmp_name"],
						"storage/$photoName"
					);
				}

				// TODO:: multi image

				$db->pquery("INSERT INTO photos (journal_id, photo_name,createdtime) VALUES (?,?,?)", array($journalId, $photoName, date("Y-m-d H:i:s")));
			}
			
			$db->pquery("UPDATE journal SET title = ?, content = ?, modifiedtime = ? WHERE id = ? AND userid = ?", array($req["title"], $req["content"], date("Y-m-d H:i:s"), $journalId, $currentUserId));	
		}

		$text = $journalId ? "Saved the changed" : "Created new gallery";
		logger(__LINE__);
		logger($text);

		return array("success" => $text);
	}

	public function register($req){
		// if username or password is empty redirect to registration page
		if(!isset($req["username"]) || !isset($req["password"])){
			$params = array("error"=>"Mandatory field empty");
			AppView::render("register.twig", $params);
			exit();
		}else{
			$mandatoryFields = array("password", "confirmpassword", "username");
			foreach($mandatoryFields as $field){
				if (empty($req[$field])) {
					$params = array("error"=>"Mandatory field empty");
					AppView::render("register.twig", $params);
					exit();
				}
			}

			if(static::$singleton->isUserExists($req["username"])){
				$params = array("error"=>"Duplicate User");
				AppView::render("register.twig", $params);
				exit();
			}else{
				static::$singleton::createNewUser($req["username"], $req["password"]);
				$params = array("username"=>$req["username"]);
				AppView::render("home.twig", $params);
			}
		}
	}	

	/**
	 * README: Save the user and hash the password
	 * @param $username string 
	 * @param $password string 
	 */
	public function createNewUser($username, $password){
		if(empty($username) || empty($password)) return false;
		
		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
		$db = db::getConnection();
		$db->pquery("INSERT INTO users (username, password) VALUES (?,?)", array($username, $hashedPassword));
		$userid = $db->lastInsertId();
		$_SESSION["username"] = $username;
		$_SESSION["userid"] = $userid;
	}

	public function isUserExists($username){
		if(empty($username)) return false;

		$db = db::getConnection();
		$result = $db->pquery("SELECT * FROM users WHERE username = ? LIMIT 1", array($username));

		$count = $result->rowCount();
		return $count == 1;
	}


	public function delete_journal($req){
		if(empty($req["id"])){
			http_response_code(403);
			return ["error" => "Id is not provided"];
		}

		$db = db::getConnection();
		$db->pquery("DELETE FROM journal WHERE id = ?", array($req["id"]));
		return ["success" => "Gallery Deleted"];
	}

	/**
	 * Serves APIs for frontend
	 * @param mixed $api
	 * @param mixed $req
	 * @param mixed $files
	 * 
	 * @return string
	 */
	public function serveApi($api, $req, $files) {
		$res = null;
		switch ($api) {
			case "list_journal":
				$res = static::$singleton->list_journal($req);
				break;
			case "edit_journal": // create/edit
				$res = static::$singleton->edit_journal($req, $files);
				break;
			case "delete_journal":
				$res = static::$singleton->delete_journal($req);
				break;
			default: http_response_code(404);
		}
		logger(__LINE__);
		logger($res);


		if ($res) {
			header("Content-type: application/json;charset=utf-8");
			echo json_encode($res);
		} else {
			echo "{}";
		}
	}

	/**
	 * This function requires action session
	 * These are server actions
	 * @param string $action
	 * @param array $req
	 * @param array $files
	 * 
	 * @return void
	 */
	public function serveAction($action, $req, $files = null) {
		switch ($action) {
			case "home":
				AppView::render("home.twig");
				break;
			case "invalid":
				AppView::render("invalid.twig", ["error"=>"Permission Denied"]);
				break;
			case "logout":
				session_destroy();
				header("Location: index.php");
				break;
			default:
				static::$singleton->login($req);
				break;
		}
	}


	/*
	* Inner static variable to allow one-time-initialization of the
	* instance and reuse.
	*/
	private static $singleton = null;
	/*
	* Exposed static controller function that handles processing of incoming request
	* by delegating to handler based on action parameter.
	*/
	public static function dispatch($req, $files) {
		session_start();

		/*
		* Ensure one-time-initialization
		*/
		if (static::$singleton == null) {
			static::$singleton = new AppController();
		}

		/*
		* Test for presence and initalize
		*/
		$action = isset($req["action"]) ? $req["action"] : "";
		$api = isset($req["api"]) ? $req["api"] : "";

		
		logger(__LINE__);
		logger($req);
		logger($files);

		logger(__LINE__);
		logger($_SESSION);


		/*
		* Handle API request routing and send JSON response.
			* Handle Action request routing and send HTML response.
			*/
		if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
			logger(__LINE__);

			// throw again to login or authenticate
			if ($action == "authenticate") {
				static::$singleton->authenticate($req);
			} else if ($action == "register") {
				static::$singleton->register($req);
			} else {
				static::$singleton->login($req);
			}
		} else {
			logger(__LINE__);
			logger($api);
			logger($action);

			if ($api) {
				static::$singleton->serveApi($api, $req, $files);
			}else{
				static::$singleton->serveAction($action, $req, $files);
			}
		}
	}
}

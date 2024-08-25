<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once "config.php";
require_once "model/db.php";
require_once "controller/AppController.php";
require_once "view/AppView.php";


// var_dump(password_verify('$2y$10$RRFxCIyF6AraL3kbDxnzsOTAQ/Z9UQZuTqj9QHvv6h8f248DHMPYO', 'kyoto'));
// die;
/*
* Trigger controller to handle request.
*/
AppController::dispatch($_REQUEST, $_FILES);

// AppController::generateQuestionMarks(array(1,2,2,3));

// $db = db::getConnection();
// // $result = $db->pquery("INSERT INTO users (username, password) VALUES ('admin@admin.com','kyoto')");
// $result = $db->pquery("SELECT * FROM users");
// $data = array();
// if ($result->rowCount()) {
// 	while ($row = $result->fetch()) {
// 		echo $row['username'] . "<br />\n";
// 	}
// }

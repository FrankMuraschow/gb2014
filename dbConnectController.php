<?php
function __autoload($class_name) {
	require_once $class_name . '.php';
}

if (isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
		case 'validateUser' :
			validateUser($_POST['usr'], $_POST['pw']);
			break;
		case 'createUsernameAndSalt' :
			createUsernameAndSalt();
			break;
	}
}
?>

<?php

class dbConnectController {

	private $connectionProperties;
	private $connection;
	private $log;
	private $mailer;

	public function __construct() {
		// $this -> log -> lfile("log");

		$config = new conf();
		$result = $config -> getDataBaseInformation();
		$this -> connectionProperties = $result;

		$this -> connection = new mysqli($this -> connectionProperties['dbHost'], $this -> connectionProperties['user'], $this -> connectionProperties['password'], $this -> connectionProperties['dbName']);

		if (mysqli_connect_errno() == 0) {
		} else {
			echo 'Die Datenbank konnte nicht erreicht werden. Folgender Fehler trat auf: <span class="hinweis">' . mysqli_connect_errno() . ' : ' . mysqli_connect_error() . '</span>';
		}
	}

	public function getLog() {
		return $this -> log;
	}

	public function closeConnection() {
		$this -> connection -> close();
	}

	public function getUserSalt($usr) {
		$usr = strtolower($usr);
		$query = "SELECT " . conf::USR_SALT . " FROM " . conf::DB_USR . " WHERE " . conf::USR_NAME . " = '$usr'";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function getUserByName($usr) {
		$usr = strtolower($usr);
		$query = "SELECT username, password FROM bd_users WHERE username = '$usr'";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function checkUserCredentials($usr, $pw) {
		$usr = strtolower($usr);
		$query = "SELECT * FROM " . conf::DB_USR . " WHERE " . conf::USR_NAME . " = '$usr' AND " . conf::USR_PW . " = '$pw'";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function createUsernameAndSalt($usr, $fn, $ln, $pw, $salt) {
		$query = "INSERT INTO `" . conf::DB_USR . "` (`" . conf::USR_FNAME . "`, `" . conf::USR_LNAME . "`, `" . conf::USR_NAME . "`, `" . conf::USR_PW . "`, `" . conf::USR_SALT . "`) VALUES ('$fn', '$ln', '$usr', '$pw', '$salt')";
		$result = $this -> connection -> query($query);
		return $result;
	}

}

function createUsernameAndSalt() {

	// $db = new dbConnectController();
	// $conf = new conf();
	// $users = $conf::$UNS;
	// $firstNames = $conf::$FNS;
	// $lastNames = $conf::$LNS;
	// $users = $conf::$UNS;
	// $pws = $conf::$PWS;
	// $return = ">>";
	// $arrlength = count($users);
	//
	// for ($x = 0; $x < $arrlength; $x++) {
	// $salt = generateSalt();
	// $pw = md5($salt . $pws[$x]);
	// $usr = $users[$x];
	// $fn = $firstNames[$x];
	// $ln = $lastNames[$x];
	//
	// if (!mb_detect_encoding($fn, 'UTF-8', true)) {
	// $fn = utf8_encode($fn);
	// }
	//
	// if (!mb_detect_encoding($ln, 'UTF-8', true)) {
	// $ln = utf8_encode($ln);
	// }
	//
	// $return .= $usr . "_" . $fn . "_" . $ln . "_" . $pw . "_" . $salt . "\n";
	//
	// $result = $db -> createUsernameAndSalt($usr, $fn, $ln, $pw, $salt);
	// }
	// $db -> closeConnection();
	// echo $return;
}

function validateUser($usr, $pw) {
	if (empty($usr)) { echo "USR empty";
		return;
	}
	if (empty($pw)) { echo "PW empty";
		return;
	}

	$db = new dbConnectController();
	$saltResult = $db -> getUserSalt($usr);
	$salt = "";
	while ($row = $saltResult -> fetch_assoc()) {
		$salt = $row[conf::USR_SALT];
	}

	$pw = md5($salt . $pw);
	$result = $db -> checkUserCredentials($usr, $pw);

	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			echo conf::NAV;
		}
	} else {
		echo "LOGIN FAILED";
	}

	$db -> closeConnection();
}

function generateSalt($max = 32) {
	$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
	$i = 0;
	$salt = "";
	while ($i < $max) {
		$salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
		$i++;
	}
	return $salt;
}
?>
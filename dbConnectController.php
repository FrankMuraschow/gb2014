<?php
function __autoload($class_name) {
	require_once $class_name . '.php';
}

session_start();
if (isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];

	switch($action) {
		case 'validateUser' :
			validateUser($_POST['usr'], $_POST['pw']);
			break;
		case 'validateAdmin' :
			validateAdmin($_POST['usr'], $_POST['pw']);
			break;
		case 'getAttendance' :
			getAttendance();
			break;
		case 'setAttendance' :
			setAttendance($_POST['val']);
			break;
		case 'getEmail' :
			getEmail();
			break;
		case 'setEmail' :
			setEmail($_POST['val']);
			break;
		case 'createUsernameAndSalt' :
			// createUsernameAndSalt();
			break;
		case 'logoutUser' :
			logoutUser();
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
		$query = "SELECT " . conf::USR_SALT . " FROM " . conf::TBL_USR . " WHERE " . conf::USR_NAME . " = '$usr'";
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
		$query = "SELECT * FROM " . conf::TBL_USR . " WHERE " . conf::USR_NAME . " = '$usr' AND " . conf::USR_PW . " = '$pw'";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function getUsers() {
		$usr = strtolower($usr);
		$query = "SELECT * FROM " . conf::TBL_USR ." ORDER BY  " . conf::USR_NAME . " ASC ";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function createUsernameAndSalt($usr, $fn, $ln, $pw, $salt) {
		$query = "INSERT INTO `" . conf::TBL_USR . "` (`" . conf::USR_FNAME . "`, `" . conf::USR_LNAME . "`, `" . conf::USR_NAME . "`, `" . conf::USR_PW . "`, `" . conf::USR_SALT . "`) VALUES ('$fn', '$ln', '$usr', '$pw', '$salt')";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function setAttendance($val) {
		if (!isset($_SESSION['usr']) || empty($_SESSION['usr']))
			return NULL;

		$query = "UPDATE " . conf::TBL_USR . " SET `will_participate` =  '" . $val . "' WHERE  " . conf::USR_NAME . " =  '" . $_SESSION['usr'] . "'";
		$this -> connection -> query($query);
	}

	public function getAttendance() {
		if (!isset($_SESSION['usr']))
			return NULL;

		$query = "SELECT `" . conf::USR_PART . "` FROM " . conf::TBL_USR . " WHERE  " . conf::USR_NAME . " =  '" . $_SESSION['usr'] . "'";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function setEmail($val) {
		if (!isset($_SESSION['usr']) || empty($_SESSION['usr']))
			return NULL;

		$query = "UPDATE " . conf::TBL_USR . " SET `" . conf::USR_MAIL . "` =  '" . $val . "' WHERE  " . conf::USR_NAME . " =  '" . $_SESSION['usr'] . "'";
		$this -> connection -> query($query);
	}

	public function getEmail() {
		if (!isset($_SESSION['usr']))
			return NULL;

		$query = "SELECT `" . conf::USR_MAIL . "` FROM " . conf::TBL_USR . " WHERE  " . conf::USR_NAME . " =  '" . $_SESSION['usr'] . "'";
		$result = $this -> connection -> query($query);
		return $result;
	}

}

// function createUsernameAndSalt() {
//
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
// }

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
		$_SESSION['usr'] = $usr;
		while ($row = $result -> fetch_assoc()) {
			echo conf::NAV;
		}
	} else {
		header('HTTP/1.0 500 Login failed');
		exit ;
	}

	$db -> closeConnection();
}

function validateAdmin($usr, $pw) {
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
		$_SESSION['usr'] = $usr;
		while ($row = $result -> fetch_assoc()) {
			if ($row['is_adm'] == 1) {
				$currentUsersResult = $db -> getUsers();
				echo "<table class=\"admTable\">";
				while ($row = $currentUsersResult -> fetch_assoc()) {
					echo "<tr><td>" . $row['first_name'] . " " . $row['last_name'] . "</td><td>";
					switch($row['will_participate']) {
						case -1 :
							echo "<span class=\"notChoosen\">Nicht gew&auml;hlt</span>";
							break;
						case 0 :
							echo "<span class=\"isNotAttending\">Nein</span>";
							break;
						case 1 :
							echo "<span class=\"isAttending\">Ja</span>";
							break;
						case 2 :
							echo "<span class=\"maybe\">Vielleicht</span>";
							break;
					}
					echo "</td>";
				}
				echo "</table>";
			} else {
				header('HTTP/1.0 500 Login failed');
				exit ;
			}
		}
	} else {
		header('HTTP/1.0 500 Login failed');
		exit ;
	}

	$db -> closeConnection();
}

function logoutUser() {
	session_destroy();
}

function setAttendance($val) {
	$db = new dbConnectController();
	$db -> setAttendance($val);
	$db -> closeConnection();
}

function getAttendance() {
	$db = new dbConnectController();
	$result = $db -> getAttendance();
	if ($result) {
		while ($row = $result -> fetch_assoc()) {
			echo $row['will_participate'];
		}
	}
	$db -> closeConnection();
}

function getAttendanceValue() {
	$db = new dbConnectController();
	$result = $db -> getAttendance();
	$value = -1;
	if ($result) {
		while ($row = $result -> fetch_assoc()) {
			$value = $row['will_participate'];
		}
	}
	$db -> closeConnection();
	return $value;
}

function setEmail($val) {
	$cleanMail = filter_var($val, FILTER_SANITIZE_EMAIL);
	$emailCheck = filter_var($cleanMail, FILTER_VALIDATE_EMAIL);

	if ($emailCheck) {
		$db = new dbConnectController();
		$db -> setEmail($cleanMail);
		$db -> closeConnection();
	} else {
		header('HTTP/1.0 500 Email invalid');
		exit ;
	}
}

function getEmail() {
	$db = new dbConnectController();
	$result = $db -> getEmail();
	if ($result) {
		while ($row = $result -> fetch_assoc()) {
			echo $row['email'];
		}
	}
	$db -> closeConnection();
}

function getEmailValue() {
	$db = new dbConnectController();
	$result = $db -> getEmail();
	$value = "";

	if ($result) {
		while ($row = $result -> fetch_assoc()) {
			$value = $row['email'];
		}
	}
	$db -> closeConnection();
	return $value;
}

// function generateSalt($max = 32) {
// $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
// $i = 0;
// $salt = "";
// while ($i < $max) {
// $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
// $i++;
// }
// return $salt;
// }
?>
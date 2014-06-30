<?php
function __autoload($class_name) {
	require_once $class_name . '.php';
}

session_start();
if (isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];

	switch ($action) {
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
		case 'addNewUser' :
			$fn = $_POST['firstName'];
			$ln = $_POST['lastName'];
			$un = $_POST['userName'];
			$pw = $_POST['pw'];
			addNewUser($fn, $ln, $un, $pw);
			break;
		case 'changeUser' :
			break;
	}
}

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
		$query = "SELECT username, password FROM " . conf::TBL_USR . " WHERE " . conf::USR_NAME . " = '$usr'";
		$result = $this -> connection -> query($query);
		return $result;
	}

	public function getUserByFullName($firstName, $lastName, $usr) {
		$usr = strtolower($usr);
		$query = "SELECT * FROM " . conf::TBL_USR . " WHERE (" . conf::USR_NAME . " = '$usr') OR (" . conf::USR_FNAME . " = '$firstName' AND " . conf::USR_LNAME . " = '$lastName')";
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
		$query = "SELECT * FROM " . conf::TBL_USR . " ORDER BY  " . conf::USR_FNAME . " ASC ";
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
	if (empty($usr)) {
		echo "USR empty";
		return;
	}
	if (empty($pw)) {
		echo "PW empty";
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
	$_SESSION['is_adm'] = 0;
	if (empty($usr)) {
		echo "USR empty";
		return;
	}
	if (empty($pw)) {
		echo "PW empty";
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
				$_SESSION['is_adm'] = 1;
				$currentUsersResult = $db -> getUsers();

				// outer table
				echo "<table><tr><td class=\"stats\">";

				$resultTable = "<table class=\"admTable\">";
				$notChoosen = 0;
				$isNotAttending = 0;
				$isAttending = 0;
				$maybe = 0;
				$sum = 0;
				$options = "";
				while ($row = $currentUsersResult -> fetch_assoc()) {
					$sum++;
					$resultTable .= "<tr><td>" . $row['first_name'] . " " . $row['last_name'] . "</td><td>";
					$options .= "<option value=\"" . $row['username'] . "\">" . $row['first_name'] . " " . $row['last_name'] . "</option>";

					switch ($row['will_participate']) {
						case -1 :
							$notChoosen++;
							$resultTable .= "<span class=\"notChoosen\">Nicht gew&auml;hlt</span>";
							break;
						case 0 :
							$isNotAttending++;
							$resultTable .= "<span class=\"isNotAttending\">Nein</span>";
							break;
						case 1 :
							$isAttending++;
							$resultTable .= "<span class=\"isAttending\">Ja</span>";
							break;
						case 2 :
							$maybe++;
							$resultTable .= "<span class=\"maybe\">Vielleicht</span>";
							break;
					}
					$resultTable .= "</td>";
				}
				$resultTable .= "</table>";

				echo "<fieldset><legend>Statistiken</legend>";
				echo "<table class=\"admTable\">";
				echo "<tr><td><span class=\"notChoosen\">Nicht gew&auml;hlt</span></td><td>" . $notChoosen . "</td></tr>";
				echo "<tr><td><span class=\"isNotAttending\">Nein</span></td><td>" . $isNotAttending . "</td></tr>";
				echo "<tr><td><span class=\"isAttending\">Ja</span></td><td>" . $isAttending . "</td></tr>";
				echo "<tr><td><span class=\"maybe\">Vielleicht</span></td><td>" . $maybe . "</td></tr>";
				echo "<tr><td><span class=\"notChoosen\">Gesamt</span></td><td>" . $sum . "</td></tr>";
				echo "</table>";
				echo "</fieldset>";

				echo "</td><td class=\"overview\">";
				echo "<fieldset><legend>Übersicht</legend>";
				echo $resultTable;
				echo "</fieldset>";

				echo "</td><td class=\"newUser\">";
				echo conf::UI_TBL_NEW_USER;

				//outer table
				//echo "</td><td class=\"changeUser\">";
				//echo str_replace("[OPTIONS]", $options, conf::UI_TBL_CHANGE_USER);

				//outer table
				echo "</td></tr></table>";
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

function addNewUser($fn, $ln, $un, $pw) {
	$db = new dbConnectController();
	$result = $db -> getUserByFullName($fn, $ln, $un);

	if (($result -> num_rows) > 0) {
		header('HTTP/1.0 500 User already exists');
		echo "User already exists!";
		exit ;
	} else {
		$salt = generateSalt();
		$pw = md5($salt . $pw);

		if (!mb_detect_encoding($fn, 'UTF-8', true)) {
			$fn = utf8_encode($fn);
		}

		if (!mb_detect_encoding($ln, 'UTF-8', true)) {
			$ln = utf8_encode($ln);
		}
		
		$db -> createUsernameAndSalt($un, $fn, $ln, $pw, $salt);		
	}

	$db -> closeConnection();
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
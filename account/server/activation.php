<?php
	$rootDir = dirname(__DIR__, 2);
	require_once($rootDir . '/php_tools.php');
	$sql_co = connectToDB();
	if (!$sql_co)
		die ("An error occured");
	$login = $_GET['login'];
	$c_key = $_GET['c_key'];
	$query = $sql_co->prepare("SELECT c_key, actif, login FROM users WHERE login LIKE :login");
	$query->execute(array(':login' => $login));
	$user = $query->fetch(PDO::FETCH_ASSOC);
	if ($user === FALSE || count($user) === 0)
		echo "<html>This account does not exist</html>";
	else {
		if ($user['actif'] == 1) {
			echo "<html>This account is already activated !</html>";
		} else {
			$query = $sql_co->prepare("UPDATE users SET actif = 1 WHERE login LIKE :login");
			$ret = $query->execute(array(':login' => $login));
			if ($ret === TRUE)
				echo "<html>Your account has been activated !</html>";
			else
				echo "<html>An error occured ...</html>";
		}
	}
?>
	<meta http-equiv="refresh" content="3;url=../client/login.php"/>
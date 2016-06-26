<?php
	$rootDir = dirname(__DIR__, 1);
	require_once($rootDir . '/config/database.php');
	try {
		$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	} catch (PDOexception $e) {
		echo "error" . $e->getMessage();
		die();
	}
	$login = $_GET['login'];
	$c_key = $_GET['c_key'];
	$result = $sql_co->query("SELECT c_key, actif, login FROM users WHERE login LIKE '" . $login . "'");
	if (!$result || !($user = $result->fetch(PDO::FETCH_ASSOC)))
		("This account does not exist");
	else {
		if ($user['c_key'] === 1) {
			
		}
	}
?>

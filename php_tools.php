<?php
	function connectToDB()
	{
		require_once('config/database.php');
		try {
			$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$sql_co->setAttribute(PDO::ATTR_ERRMODE, PDO_ERRMODE_EXCEPTION);
		} catch (PDOException $Exception) {
			return (NULL);
		}
		return ($sql_co);
	}

	function getMail($login)
	{
		require_once('config/database.php');
		try {
			$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		} catch (PDOexception $e) {
			return (NULL);
		}
		$query = $sql_co->prepare("SELECT mail FROM users WHERE login LIKE :login");
		$query->execute(array(':login' => $login));
		if ($user = $query->fetch(PDO::FETCH_ASSOC))
			return $user['mail'];
	}

	function isAjax ()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			(strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'))
			return (true);
		return false;
	}

	function writeErrors($errors)
	{
		if (!empty($errors) && isAjax()) {
			http_response_code(400);
			header('Content-Type: application/json');
			echo(json_encode($errors));
			die();
		}
		else if (!empty($errors)) {
			foreach ($errors as $error)
				echo($error) . '<br>';
			die();
		}
	}
?>

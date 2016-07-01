<?php
	function connectToDB()
	{
		include('config/database.php');
		try {
			$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		} catch (PDOException $Exception) {
			echo $Exception->getMessage();
			return (NULL);
		}
		$sql_co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return ($sql_co);
	}

	function isConnected($session)
	{
		if (isset($session) && isset($session['login']) && $session['login'] != "")
			return (TRUE);
		return (FALSE);
	}

	function getMail($login)
	{
		$sql_co = connectToDB();
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
			http_response_code(201);
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

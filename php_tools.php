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
		if (!($sql_co = connectToDB()))
			return ('');
		$query = $sql_co->prepare("SELECT mail FROM users WHERE login LIKE :login");
		$query->execute(array(':login' => $login));
		if ($user = $query->fetch(PDO::FETCH_ASSOC))
			return $user['mail'];
	}

	function getIMGS($user, $start, $range)
	{
		if (!($sql_co = connectToDB()))
			return (NULL);
		if (isset($user) && $user == 'root') {
			$query = $sql_co->prepare("SELECT source_img, id FROM img
										ORDER BY id DESC LIMIT " . $start . "," . $range);
			$query->execute();
		} else if (isset($user) && $user != "") {
			$query = $sql_co->prepare("SELECT source_img, id FROM img
										WHERE author like :user
										ORDER BY id DESC LIMIT " . $start . "," . $range);
			$query->execute(array(':user' => $user));
		} else
			return (NULL);
		return ($query->fetchAll(PDO::FETCH_ASSOC));
	}

	function isAjax ()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			(strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'))
			return (TRUE);
		return (FALSE);
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

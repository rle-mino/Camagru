<?php
	session_start();
	$rootDir = dirname(__DIR__, 1);
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/config/database.php');
	$errors = NULL;
	if (!isset($_POST) || $_POST['submit'] != 'GO') {
		$errors['submit'] = "An error occured";
		writeErrors($errors);
	}
	if (!isset($_POST['login']) || $_POST['login'] == '') {
		$errors['login'] = "You have to specify your login or mail";
	}
	if (!isset($_POST['passwd']) || $_POST['passwd'] == '') {
		$errors['passwd'] = "You have to specify your password";
	}
	if ($errors === NULL) {
		try {
			$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		} catch (PDOexception $e) {
			$errors['submit'] = "Impossible to access to database";
		}
	}
	if ($errors === NULL)
	{
		if (preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $_POST['login']))
		{
			$query = $sql_co->prepare("SELECT login, password, actif, mail
										FROM users
										WHERE mail LIKE :mail");
			$query->execute(array(':mail' => $_POST['login']));
		}
		else
		{
			$query = $sql_co->prepare("SELECT login, password, actif, mail
											FROM users
											WHERE login LIKE :login");
			$ret = $query->execute(array(':login' => $_POST['login']));
		}
		if ($user = $query->fetch(PDO::FETCH_ASSOC))
		{
			if ($user['password'] != hash('whirlpool', $_POST['passwd']))
				$errors['passwd'] = 'Wrong password';
			if (!$errors && $user['actif'] == 0)
				$errors['login'] = 'This account needs to be activated, a mail has been sent to ' . $user['mail'] ;
			else if (!$errors)
				$_SESSION['login'] = $user['login'];
		}
		else
			$errors['login'] = 'Unknow user';
	}
	writeErrors($errors);
	if (!$errors)
	{
		if (!isAjax()) {
			echo 'You are now connected, You will be redirected in few seconds';
			// echo '<meta http-equiv="refresh" content="3;url=../index.php"/>';
		}
	}
?>

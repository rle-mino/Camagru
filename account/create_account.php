<?php
	include_once('../php_tools.php');
	include_once('../config/database.php');
	$errors = array();
	if (!isset($_POST) || !isset($_POST['submit']) || $_POST['submit'] != 'GO') {
		$errors['submit'] = 'An error occured';
	}
	if ((!isset($_POST['login']) || $_POST['login'] == "")) {
		$errors['login'] = 'You must specify a login';
	}
	if ((!isset($_POST['passwd']) || $_POST['passwd'] == "")) {
		$errors['passwd'] = 'You must specify a password';
	}
	if ((!isset($_POST['passwd_confirm']) || $_POST['passwd_confirm'] == "")) {
		$errors['passwd_confirm'] = 'You must confirm your password';
	}
	else if ($_POST['passwd'] != $_POST['passwd_confirm']) {
		$errors['passwd_confirm'] = 'Passwords are different';
	}
	if ((!isset($_POST['mail']) || $_POST['mail'] == "")) {
		$errors['mail'] = 'You must specify a mail';
	}
	if ((!isset($_POST['mail_confirm']) || $_POST['mail_confirm'] == "")) {
		$errors['mail_confirm'] = 'You must confirm your mail';
	}
	else if ($_POST['mail'] != $_POST['mail_confirm']) {
		$errors['mail_confirm'] = 'Mails are different';
	}
	else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
		$errors['mail'] = 'Invalid mail';
	}
	if (!empty($errors) && isAjax()) {
		echo(json_encode($errors));
		header('Content-Type: application/json');
		http_response_code(400);
		die();
	}
	else if (!empty($errors)) {
		foreach ($errors as $error)
			echo($error) . '<br>';
		die();
	}
	if (empty($errors))
	{
		try {
			$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		} catch (PDOexception $e) {
			echo "error" . $e->getMessage();
			die();
		}
		$sql_co->setAttribute(PDO::ATTR_ERRMODE, PDO_ERRMODE_EXCEPTION);
		$query = "SELECT login, mail FROM camagru.users
					WHERE login LIKE " . $sql_co->quote($_POST['login']) . "
					OR mail LIKE " . $sql_co->quote($_POST['mail']);
		$list = $sql_co->query($query);
		if (($exist = $list->fetch(PDO::FETCH_ASSOC)))
		{
			if ($exist['login'])
				$errors['login'] = 'login already in use';
			else if ($exist['mail'] && $exist['mail'])
				$errors['mail'] = 'mail already in use';
			if (isAjax())
			{
				echo(json_encode($errors));
				header('Content-Type: application/json');
				http_response_code(400);
			}
			else
			{
				foreach ($errors as $error)
					echo($error) . '<br>';
			}
			die();
		}
		$c_key = md5(microtime(TRUE) * 100000);
		$query = "INSERT INTO camagru.users
							(
								login,
								password,
								mail,
								c_key
							) VALUES
							(
								" . $sql_co->quote($_POST['login']) . ",
								'" . hash('whirlpool', $_POST['passwd']) . "',
								" . $sql_co->quote($_POST['mail']).",
								'" . $c_key ."')";
		$ret = $sql_co->query($query);
		if ($ret === FALSE) {
			echo "<div>Query fail</div>";
			die();
		}
		else {
			$dest = $_POST['mail'];
			$subject = "Activate your account";
			$from = "From: activationcamagru@gmail.com";
			$message = "Welcome to Camagru !\n
			Click on the following link to activate your account on camagru :\n
			http://localhost:8080/activation.php?login=" . urlencode($_POST['login']) . "&c_key=" . urlencode($c_key);
			$err = mail($dest, $subject, $message, $form);
		}
		if (!isAjax()) {
			echo('You are now registred, you have to confirm your mail address');
		}
	}
?>

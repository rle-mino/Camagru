<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
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
	writeErrors($errors);
	if (empty($errors))
	{
		$sql_co = connectToDB();
		if (!$sql_co)
			$errors("An error occured");
		writeErrors($errors);
		$query = $sql_co->prepare("SELECT login, mail
								FROM users
								WHERE login LIKE :login OR mail LIKE :mail");
		$query->execute(array(':login' => $_POST['login'],
										':mail' => $_POST['mail']));
		if (($user = $query->fetch(PDO::FETCH_ASSOC)))
		{
			if ($user['login'] == $_POST['login'])
				$errors['login'] = 'login already in use';
			else if ($user['mail'] == $_POST['mail'])
				$errors['mail'] = 'mail already in use';
			writeErrors($errors);
		}
		$c_key = md5(microtime(TRUE) * 100000);
		$query = $sql_co->prepare("INSERT INTO users
							(
								login,
								password,
								mail,
								c_key
							) VALUES (
								:login,
								:passwd,
								:mail,
								:c_key
							)");
		$query->execute(array(':login' => $_POST['login'],
								':passwd' => hash('whirlpool', $_POST['passwd']),
								':mail' => $_POST['mail'],
								':c_key' => $c_key));
		$dest = $_POST['mail'];
		$subject = "Activate your account";
		$from = "From: activationcamagru@gmail.com";
		$message = "Welcome to Camagru !\n
		Click on the following link to activate your camagru's account :\n
		http://localhost:8080/account/activation.php?login=" . urlencode($_POST['login']) . "&c_key=" . urlencode($c_key);
		$ret = mail($dest, $subject, $message, $form);
		if (!isAjax()) {
			echo('You are now registred, you have to confirm your mail address');
		}
	}
?>

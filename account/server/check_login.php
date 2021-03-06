<?php
	session_start();
	$rootDir = '../../';
	require_once($rootDir . '/php_tools.php');
	$errors = [];
	if (!isset($_POST['submit']) || $_POST['submit'] != 'GO')
	{
		$errors['submit'] = "An error occured";
		writeErrors($errors);
	}
	if (!isset($_POST['login']) || $_POST['login'] == '') {
		$errors['login'] = "You have to specify your login or mail";
	}
	if (!isset($_POST['passwd']) || $_POST['passwd'] == '') {
		$errors['passwd'] = "You have to specify your password";
	}
	writeErrors($errors);
	$sql_co = connectToDB();
	if (!$sql_co)
		$errors['submit'] = "An error occured";
	writeErrors($errors);
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
		$query->execute(array(':login' => $_POST['login']));
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
	writeErrors($errors);
	echo '<html>You are now connected, you will be redirected in few seconds</html>';
	if (!isAjax()) {
		echo '<meta http-equiv="refresh" content="3;url=../../index.php"/>';
	}
?>

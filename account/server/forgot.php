<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');

	$errors = [];
	if (!isset($_POST['submit']) || $_POST['submit'] != "send")
	{
		$errors['submit'] = 'An error occured';
		writeErrors($errors);
	}
	if (!isset($_POST['mailorLogin']) || $_POST['mailorLogin'] == '')
	{
		$errors['mailorLogin'] = "This information is required";
		writeErrors($errors);
	}
	$c_key = md5(microtime(TRUE) * 100000);
	if (!$sql_co = connectToDB()) {
		$errors['submit'] = "An error occured";
		writeErrors($errors);
	}
	if (filter_var($_POST['mailorLogin'], FILTER_VALIDATE_EMAIL))
	{
		$query = $sql_co->prepare("SELECT mail FROM users
									WHERE mail LIKE :mail");
		$query->execute(array(':mail' => $_POST['mailorLogin']));
	}
	else
	{
		$query = $sql_co->prepare("SELECT mail FROM users
									WHERE login LIKE :login");
		$query->execute(array(':login' => $_POST['mailorLogin']));
	}
	if ($user = $query->fetch(PDO::FETCH_ASSOC))
	{
		$query = $sql_co->prepare("UPDATE users SET c_key = :c_key WHERE mail LIKE :mail");
		$query->execute(array(':c_key' => $c_key, ':mail' => $user['mail']));
	}
	else
		$errors['mailorLogin'] = "Unknow user";
	writeErrors($errors);
	$message = "To reset your password, follow this link
	http://localhost:8080/account/client/reset_password.php?mail=" . urlencode($user['mail']) . "&c_key=" . urlencode($c_key);
	$dest = $user['mail'];
	$subject = 'Reset your password';
	mail($dest, $subject, $message);
	echo 'A mail has been sent to ' . $user['mail'];
?>

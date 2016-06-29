<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');

	$errors = [];
	if ($_POST['submit'] != 'reset')
	{
		$errors['submit'] = "An error occured";
		writeErrors($errors);
	}
	if (!isset($_POST['password']) || $_POST['password'] == '')
		$errors['password'] = "You must specify a password";
	if (!isset($_POST['password_check']) || $_POST['password_check'] == '')
		$errors['password_check'] = 'You must confirm your password';
	writeErrors($errors);
	if ($_POST['password'] != $_POST['password_check'])
		$errors['password_check'] = "Passwords are different";
	writeErrors($errors);
	$sql_co = connectToDB();
	$query = $sql_co->prepare("UPDATE user SET password = :password WHERE mail LIKE :mail");
	$query->execute(array(':password' => hash('whirlpool', $_POST['password']) ,':mail' => $_GET['mail']));
	if (!isAjax())
	{
		echo "Your password has been updated";
		echo '<meta http-equiv="refresh" content="3;url=' . $rootDir . '/account/client/login.php' . '"/>';
	}
?>

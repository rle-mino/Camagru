<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	$errors = [];
	$new = [];
	if (!isset($_SESSION['login']) || $_SESSION['login'] == '')
		$errors['submit'] = "An error occured";
	// CONNECT TO DB
	$sql_co = connectToDB();
	if (!$sql_co)
		$errors['submit'] = "An error occured";
	writeErrors($errors);
	// CHECK PASSWORD
	$query = $sql_co->prepare("SELECT mail, password FROM users WHERE login LIKE :login");
	$ret = $query->execute(array(':login' => $_SESSION['login']));
	if ($user = $query->fetch(PDO::FETCH_ASSOC))
	{
		if (hash('whirlpool', $_POST['old_passwd']) != $user['password'])
			$errors['old_passwd'] = 'Wrong password';
	}
	else
		$errors['submit'] = "An error occured";
	writeErrors($errors);
	// CHECK QUERY
	if ($_POST['submit'] == "modify")
	{
			// MAIL OR PASSWD
			if ($user['mail'] != $_POST['mail'] && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
				$new['mail'] = $_POST['mail'];
			else if ($user['mail'] != $_POST['mail'] && !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
				$errors['mail'] = "New mail invalid";
			if (isset($_POST['new_passwd']) && $_POST['new_passwd'] != '' && !isAValidPassword($_POST['new_passwd']))
				$errors['new_passwd'] = "Unsecure password";
			writeErrors($errors);
			if (isset($_POST['new_passwd']) && $_POST['new_passwd'] != '' && isAValidPassword($_POST['new_passwd']))
				$new['passwd'] = hash('whirlpool', $_POST['new_passwd']);
			// UPDATE
			$ret = NULL;
			if (isset($new['mail']) && $new['mail'] != '' && isset($new['passwd']) && $new['passwd'] != '')
			{
				$query = $sql_co->prepare("UPDATE users SET mail = :mail, password = :passwd WHERE login = :login");
				$ret = $query->execute(array(':login' => $_SESSION['login'], ':passwd' => $new['passwd'], ':mail' => $new['mail']));
			}
			else if (isset($new['mail']) && $new['mail'] != '')
			{
				$query = $sql_co->prepare("UPDATE users SET mail = :mail, WHERE login = :login");
				$ret = $query->execute(array(':login' => $_SESSION['login'], ':mail' => $new['mail']));
			}
			else if (isset($new['passwd']) && $new['passwd'] != '')
			{
				$query = $sql_co->prepare("UPDATE users SET password = :passwd WHERE login = :login");
				$ret = $query->execute(array(':login' => $_SESSION['login'], ':passwd' => $new['passwd']));
			}
			// RETURN VALUES
			if ($ret)
			{
				if (isset($new['passwd']) && $new['passwd'] != '')
					$good['new_passwd'] = "Your password has been updated";
				if (isset($new['mail']) && $new['mail'] != '')
					$good['mail'] = "Your mail address has been updated, a confirmation code has been sent";
				if (isAjax())
					echo(json_encode($good));
				else
					foreach($good as $i)
						echo $i;
			}
			else
				$errors['submit'] = "Nothing to update";
	}
	else
		$errors['submit'] = "An error occured";
	writeErrors($errors);
?>

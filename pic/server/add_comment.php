<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');

	if (!isConnected($_SESSION))
		die("An error occured") ;
	if (!isset($_POST) || empty($_POST))
		die("An error occured") ;
	if (!$_POST['img_id'] || $_POST['img_id'] == '')
		die("An error occured") ;
	if (!$_POST['comment'] || $_POST['comment'] == '')
		die("An error occured") ;
	if (!($sql_co = connectToDB()))
		die("An error occured") ;
	addComment($sql_co, $_POST['img_id'], $_SESSION['login'], $_POST['comment']);
	echo getMostRecentComment($sql_co, $_POST['img_id']);
?>

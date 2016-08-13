<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');

	if (!isConnected($_SESSION))
		die("An error occured") ;
	if (!isset($_POST) || empty($_POST))
		die("An error occured") ;
	if (!$_POST['id'] || $_POST['id'] == '')
		die("An error occured");
	if (!($sql_co = connectToDB()))
		die("An error occured");
	deleteComment($sql_co, $_POST['id']);
?>
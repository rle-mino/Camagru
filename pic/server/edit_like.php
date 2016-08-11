<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	$err = "An error occured";
	if (!isConnected($_SESSION))
		die ($err);
	if (!isset($_POST['liker']) || $_POST['liker'] == "")
		die($err);
	if (!isset($_POST['img_id']) || $_POST['img_id'] == "")
		die($err);
	if (!($sql_co = connectToDB()))
		die($err);
	removeOrAddLike($sql_co, $_POST['liker'], $_POST['img_id']);
	echo(nbLike($sql_co, $_POST['img_id']));
?>
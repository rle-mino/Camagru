<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	$err = "An error occured";
	if (!isConnected($_SESSION))
		die($err);
	$sql_co = connectToDB();
	if (!$sql_co)
		die($err);
	if (!isset($_POST['imgsrc']) || $_POST['imgsrc'] == '')
		die($err);
	$query = $sql_co->prepare("INSERT INTO img (source_img, crea_date, author)
					VALUES (:imgsrc, :crea_date, :author)");
	$ret = $query->execute(array(':imgsrc' => $_POST['imgsrc'],
								':crea_date' => time(),
								':author' => $_SESSION['login']));
	if (!$ret)
		die($err);
	echo "Image saved, You can access to all of your image using your galery";
?>
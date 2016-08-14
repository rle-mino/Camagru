<?php
	session_start();
	$data = (array)json_decode(file_get_contents('php://input'));
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	$err = "An error occured";
	if (!isConnected($_SESSION))
		die($err);
	if (!isset($data['imgsrc']) || $data['imgsrc'] == '')
		die($err);
	$type = $data['imgsrc'][11] == 'j' ? 'jpeg' : 'png';
	$under = explode(',', $data['imgsrc'])[1];
	$under = imagecreatefromstring(base64_decode($under));
	$above = imagecreatefrompng($data['imgabove']);
	$ret = imagecopy($under, $above, 0, 0, 0, 0, 600, 450);
	if (!$ret)
		die($err);
	if (!(imagejpeg($under, 'source.jpg')))
		die($err);
	imagedestroy($under);
	imagedestroy($above);
	if (!($final = file_get_contents('source.jpg')))
		die($err);
	$final = base64_encode($final);
	if (!($sql_co = connectToDB()))
		die($err);
	$query = $sql_co->prepare("INSERT INTO img (source_img, author)
					VALUES (:imgsrc, :author)");
	$ret = $query->execute(array(':imgsrc' => $final,
								':author' => $_SESSION['login']));
	if (!$ret)
		die($err);
	echo "Image saved !";
?>


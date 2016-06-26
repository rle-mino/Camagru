<?php
	include_once('database.php');
	try {
		$sql_co = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$sql_co->setAttribute(PDO::ATTR_ERRMODE, PDO_ERRMODE_EXCEPTION);
		$sql_co->query("DROP TABLE img, users");
	}
	catch (PDOexception $error){
		die("FAIL: " . $error->getMessage());
	}
	$err = $sql_co->query("CREATE TABLE IF NOT EXISTS users
						(
							id INT NOT NULL AUTO_INCREMENT,
							login VARCHAR(255) NOT NULL,
							password CHAR(255) NOT NULL,
							mail VARCHAR(255) NOT NULL,
							actif INT NOT NULL DEFAULT 0,
							c_key VARCHAR(32) NOT NULL,
							PRIMARY KEY (id)
						)");
	if (!$err)
		die("FAIL: CREATE TABLE USERS");
	else
		echo("TABLE USERS CREATED !\n" . '<br>');
	$c_key = md5(microtime(TRUE) * 10000);
	$query = $sql_co->prepare("INSERT INTO users
						(
							login,
							password,
							mail,
							c_key
						) VALUES
						(
							:login,
							:passwd,
							:mail,
							:c_key
						)");
	$err = $query->execute(array(':login' => 'admin',
						':passwd' => hash('whirlpool', 'admin'),
						':mail' => 'admin@admin.com',
						':c_key' => $c_key));
	if (!$err)
		die("FAIL: CREATE ADMIN USER");
	else
		echo("ADMIN USER CREATED!\n" . '<br>');
	$err = $sql_co->query("CREATE TABLE IF NOT EXISTS img
						(
							id INT NOT NULL AUTO_INCREMENT,
							source_img MEDIUMTEXT CHARACTER SET ascii NOT NULL,
							comments VARCHAR(255) NOT NULL,
							nb_comments INT NOT NULL DEFAULT 0,
							creator VARCHAR(255) NOT NULL,
							crea_date TIMESTAMP NOT NULL,
							likes INT NOT NULL DEFAULT 0,
							PRIMARY KEY (id)
						)");
	if (!$err)
		die("FAIL: CREATE TABLE IMG");
	else
		echo("TABLE IMG CREATED !\n" . '<br>');
?>

<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/header.php');
	if (!goHeader('login', "NO CHECK", $rootDir))
		return ;
?>
	<form id="loginForm" action="<?php echo $rootDir . '/account/server/check_login.php'?>" method="post">
		<p>Login or mail</p><input  type="text" name="login" value="">
		<p>Password</p><input type="password" name="passwd" value="">
		<input type="submit" name="submit" value="GO">
	</form>
	<a href="<?php echo $rootDir . "/account/client/forgot_password.php"?>">Forgot password ?</a>
	<a href="<?php echo $rootDir . "/account/client/create_account.php";?>">Sign up !</a>
	<script src="../../ajax_tools.js"></script>
	<script src="login.js"></script>
	</body>
</html>

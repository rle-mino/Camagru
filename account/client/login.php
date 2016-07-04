<?php
	$rootDir = '../..';
	require_once($rootDir . '/header.php');
	if (!goHeader('login', "NO CHECK", $rootDir))
		return ;
	if (isset($_SESSION['login']) && $_SESSION['login'] != "")
	{
?>
		<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/index.php'?>"/>
		<div>You are already connected...</div>
<?php
	} else {
?>
	<form id="loginForm" action="<?php echo $rootDir . '/account/server/check_login.php'?>" method="post">
		<p>Login or mail</p><input  type="text" name="login" value="">
		<p>Password</p><input type="password" name="passwd" value="">
		<input type="submit" name="submit" value="GO">
	</form>
	<a href="<?php echo $rootDir . "/account/client/forgot_password.php"?>">Forgot password ?</a>
	<a href="<?php echo $rootDir . "/account/client/create_account.php";?>">Sign up !</a>
	<script defer src="../../ajax_tools.js"></script>
	<script defer src="login.js"></script>
	</body>
</html>
<?php }
?>
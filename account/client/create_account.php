<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	goHeader('register', "NO CHECK", $rootDir);
		if (!isConnected($_SESSION)) {
?>
			<form id="createAccountForm" action="<?php echo $rootDir . '/account/server/create.php'?>" method="post">
				<p>Login</p><input  type="text" name="login" value="">
				<p>Password</p><input type="password" name="passwd" value="">
				<p>Confirm password</p><input type="password" name="passwd_confirm" value="">
				<p>Mail</p><input type="text" name="mail" value="">
				<p>Confirm mail</p><input type="text" name="mail_confirm" value="">
				<input type="submit" name="submit" value="GO">
				<a class="suppForm" href="<?php echo $rootDir . '/account/client/login.php'?>"><p>Already register ?</p></a>
			</form>
			<script src="create_account.js"></script>
			<script src="<?php echo $rootDir . '/ajax_tools.js'?>"></script>
<?php
	} else {
?>
		<meta http-equiv="refresh" content="3;url=<?php echo $rootDir . '/index.php'?>"/>
		<div class="errorBeforeRedir">You are already connected...</div>
<?php
	}
?>
	</body>
	<?php require_once($rootDir . '/footer.html')?>
</html>

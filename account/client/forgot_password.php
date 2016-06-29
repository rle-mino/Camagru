<?php
	session_start();
	$rootDir = '../..';
	require_once($rootDir . '/header.php');
	goHeader('Forgot password', "NO CHECK", $rootDir);
?>
	<body>
		<form class="forgotPassword" action="<?php echo $rootDir . '/account/server/forgot.php';?>" method="post">
			<p>Mail or login</p><input type="text" name="mailorLogin" value="">
			<input type="submit" name="submit" value="send">
		</form>
		<!-- <script src="forgot_password.js"></script> -->
		<!-- <script src="<?php echo $rootDir . '/ajax_tools.js';?>"></script> -->
	</body>
</html>

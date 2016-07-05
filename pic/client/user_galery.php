<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	goHeader('My galery', "CHECK", $rootDir);
?>
	<div id="thumbnails"></div>
	<div class="loading" style="opacity=0">
		<div class="bar0"></div>
		<div class="bar1"></div>
		<div class="bar2"></div>
		<div class="bar3"></div>
		<div class="bar4"></div>
	</div>
	<script src="../../ajax_tools.js"></script>
	<script src="../../pic/client/user_galery.js"></script>
</body>
<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	if (!goHeader('Take a picture', "CHECK", $rootDir))
		return ;
?>
	<video id="video"></video>
	<button id="take">Take a picture</button>
	<canvas id="canvas" style="display:none"></canvas>
	<div id="result">
		<form id="sendImage" method="post" action="../server/save_image.php">
			<img src="http://12emesport.fr/sites/default/files/lovehard/apn_logo.png" alt="default" id="photo" width="320"/>
			<input type="text" style="display:none" name="imgsrc">
			<input type="submit" value="save" name="submit" disabled="yes">
		<form>
	</div>
	<script src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
	<script src="take.js" charset="utf-8"></script>

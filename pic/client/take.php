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
	<img src="http://12emesport.fr/sites/default/files/lovehard/apn_logo.png" alt="default" id="photo"/>
	<script src="take.js" charset="utf-8"></script>

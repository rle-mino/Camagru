<?php
	$rootDir = '../..';
	require_once($rootDir . '/php_tools.php');
	require_once($rootDir . '/header.php');
	if (!goHeader('Take a picture', "CHECK", $rootDir))
		return ;
?>
	<div id="center">
		<div id="preview">
			<div id="superposables">
				<img src="../src/palmier_mini.png" width="60px"></img>
				<img src="../src/star_mini.png" width="60px"></img>
				<img src="../src/moustache_mini.png" width="60px"></img>
			</div>
			<video id="video"></video>
			<input type="file" name="fileFromUser" id="fileFromUser" accept="image/png, image/jpeg">
			<button id="webcamSelector">Use your webcam</button>
			<button id="take">Take</button>
		</div>
		<canvas id="canvas" style="display:none"></canvas>
		<div id="result">
			<img src="../../apn_logo.png" alt="default" id="photo" width="600px"/>
			<form id="sendImage" method="post" action="../server/save_image.php">
				<input type="text" style="display:none" name="imgsrc">
				<input type="text" style="display:none" name="imgabove">
				<input type="submit" value="save" name="submit" disabled="yes">
			<form>
		</div>
	</div>
	<script defer src="<?php echo $rootDir . '/ajax_tools.js';?>"></script>
	<script defer src="take.js" charset="utf-8"></script>

	<?php require_once($rootDir . '/footer.html')?>

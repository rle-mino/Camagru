<?php
	function isAjax ()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			(strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'))
			return (true);
			return false;
	}

	function writeErrors($errors)
	{
		if (!empty($errors) && isAjax()) {
			http_response_code(400);
			header('Content-Type: application/json');
			echo(json_encode($errors));
			die();
		}
		else if (!empty($errors)) {
			foreach ($errors as $error)
				echo($error) . '<br>';
			die();
		}
	}
?>

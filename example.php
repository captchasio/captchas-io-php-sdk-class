<?php

	require_once('captchasio.class.php');

	// recaptcha
	$api = new CAPTCHASIO ('<MY_API_KEY>');
	$token = $api->recaptcha ('6Le85AAaAAAAAA6OYetdaV2nOlahkOZc03cjztcH', 'https://captchas.io/recaptcha');	
	
	print $token;

	// image 
	$api = new CAPTCHASIO ('<MY_API_KEY>');
	$answer = $api->image('example/image_captcha_file.png');
	
	print $answer;
?>

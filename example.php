<?php

	require_once('captchasio.php');

	$api = new CAPTCHASIO('<MY_API_KEY>');
	$api->buildCaptcha('6Le85AAaAAAAAA6OYetdaV2nOlahkOZc03cjztcH', 'https://captchas.io/recaptcha', 'userrecaptcha', 'v3', '1');
	
	$captcha_id = $api->solve_recaptcha();
	$token = $api->get_recaptcha($captcha_id);
		
	while ($token == 'CAPCHA_NOT_READY') {
		$token = $api->get_recaptcha($captcha_id);
	}
	
	print $token;
	
?>
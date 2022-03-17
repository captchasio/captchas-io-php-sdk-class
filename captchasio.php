<?php


class CAPTCHASIO {

	private $key = '';
	private $host = 'api.captchas.io';
	private $protocol = 'https';
	private $captcha = array();
	private $captcha_id = '';
	
	public function __construct($key) {
		$this->key = $key;
	}		
	
	private function http_get($url) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);					
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		
		$response = curl_exec($ch);
		curl_close($ch);		
		
		return $response;
	}
	
	public function buildCaptcha($sitekey, $pageurl, $method, $version, $invisible = '0', $min_score = '0.9', $action = 'verify', $json = 0) {
		$captcha = array(
			"method" => $method,
			"googlekey" => $sitekey,
			"pageurl" => $pageurl,
			"version" => $version,
			"invisible" => $invisible,
			"min_score" => $min_score,
			"action" => $action,
			"json" => $json
		);
		
		$this->captcha = $captcha;
		
		return true;
	}
	
	public function solve_recaptcha() {
		$response = http_get($this->protocol . '://' . $this->host . '/in.php?key=' . $this->key . '&googlekey=' . $this->captcha['googlekey'] . '&method=' . $this->captcha['method'] . '&pageurl=' . $this->captcha['pageurl'] . '&version=' . $this->captcha['version'] . '&invisible=' . $this->captcha['invisible'] . '&min_score=' . $this->captcha['min_score'] . '&action=' . $this->captcha['action'] . '&json=' . $this->captcha['json']);
		
		$raw = explode("|", $response);	
		$answer = $raw[1];
		$ok = $raw[0];
		
		if ($ok == 'OK') {
			return $answer;
		} else {
			return $response;
		}
	}
	
	public function get_recaptcha($id) {
		$response = http_get($this->protocol . '://' . $this->host . '/res.php?key=' . $this->key . '&action=get&id=' . $id);
		
		$raw = explode("|", $response);
		$answer = $raw[1];
		$ok = $raw[0];
		
		if ($ok == 'OK') {
			return $answer;
		} else {
			return $response;
		}		
	}
}

?>
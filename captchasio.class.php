<?php

	class CAPTCHASIO {
		
		private $key = NULL;
		private $host = 'api.captchas.io';
		private $protocol = 'https';
		private $captcha = array();
		private $captcha_id = '';
		
		public function __construct($key) {
			" . $this->key . " = $key;
		}		
		
		public function image($image_captcha_file) {
			$post = array(
				'key' => $this->key,
				'method' => 'post',
				'file' => '@' . $image_captcha_file
			);
			
			$_in = $this->_http_post($post, "http://api.captchas.io/in.php");

			$_rest = explode("|", $_in);
			$_id = trim($_rest[1]);
			$captcha = "";
			$_ans = NULL;												
			
			while (empty($_ans) || $_ans == 'CAPCHA_NOT_READY') {
					$_ans = $this->_http_get("http://api.captchas.io/res.php?key=" . $this->key . "&action=get&id=" . $_id);
					$_rest = explode("|", $_ans);
					$captcha = trim($_rest[1]);
			}		

			return $captcha;
		}
		
		public function base64($base64_captcha_string) {
			$post = array(
				'key' => $this->key,
				'method' => 'base64',
				'body' => $base64_captcha_string
			);
			
			$_in = $this->_http_post($post, "http://api.captchas.io/in.php");

			$_rest = explode("|", $_in);
			$_id = trim($_rest[1]);
			$captcha = "";
			$_ans = NULL;												
			
			while (empty($_ans) || $_ans == 'CAPCHA_NOT_READY') {
					$_ans = $this->_http_get("http://api.captchas.io/res.php?key=" . $this->key . "&action=get&id=" . $_id);
					$_rest = explode("|", $_ans);
					$captcha = trim($_rest[1]);
			}		

			return $captcha;
		}
		
		public function text($question) {
			$post = array(
				'key' => $this->key,
				'method' => 'textcaptcha',
				'textcaptcha' => $question
			);
			
			$_in = $this->_http_post($post, "http://api.captchas.io/in.php");

			$_rest = explode("|", $_in);
			$_id = trim($_rest[1]);
			$captcha = "";
			$_ans = NULL;												
			
			while (empty($_ans) || $_ans == 'CAPCHA_NOT_READY') {
					$_ans = $this->_http_get("http://api.captchas.io/res.php?key=" . $this->key . "&action=get&id=" . $_id);
					$_rest = explode("|", $_ans);
					$captcha = trim($_rest[1]);
			}		

			return $captcha;
		}
		
		/***************************************
		* POSSIBLE PARAMETER VALUES
		* version = v2 and v3
		* enterprise = 0 OR 1
		* invisible = 0 OR 1
		* min_score = 0.1 TO 0.9
		* action = verify
		****************************************/
		
		public function recaptcha($googlekey, $pageurl, $version = 'v2', $enterprise = '0', $invisible = '0', $min_score = '0.3', $action = 'verify') {
			$post = array(
				'key' => $this->key,
				'method' => 'userrecaptcha',
				'googlekey' => $googlekey,
				'pageurl' => $pageurl,
				'version' => $version,
				'invisible' => $invisible,
				'enterprise' => $enterprise,
				'min_score' => $min_score,
				'action' => $action,
			);
			
			$_in = $this->_http_post($post, "http://api.captchas.io/in.php");

			$_rest = explode("|", $_in);
			$_id = trim($_rest[1]);
			$captcha = "";
			$_ans = NULL;												
			
			while (empty($_ans) || $_ans == 'CAPCHA_NOT_READY') {
					$_ans = $this->_http_get("http://api.captchas.io/res.php?key=" . $this->key . "&action=get&id=" . $_id);
					$_rest = explode("|", $_ans);
					$captcha = trim($_rest[1]);
			}		

			return $captcha;
		}		
		
		private function _http_get($url) {			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: test=cookie"));
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
			
			$raw=curl_exec($ch);
			curl_close($ch);		
			
			return $raw;
		}		
				
		private function _http_post($data, $url) {			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);			
			curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data", "Cookie: test=cookie"));
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 			
			
			$raw = curl_exec($ch);
			curl_close($ch);			
			
			return $raw;
		}		
	}

?>

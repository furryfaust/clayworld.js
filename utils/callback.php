<?php
session_start();

$code = $_GET['code'];
$state = $_GET['state'];

if (isset($_SESSION['state'])) {
	if ($state == $_SESSION['state']) {
		$url = 'https://github.com/login/oauth/access_token/';
		$ch = curl_init($url);
		$fields = array(
				"client_id" => "179234c27aaecd4eadc8",
				"client_secret" => "clientsecret",
				"code" => $code
			);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		$response = curl_exec($ch);
		parse_str($response, $data);
		$_SESSION['token'] = $data['access_token'];
		curl_close($ch);
		unset($_SESSION['state']);
		unset($_SESSION['code']);

		$url = "https://api.github.com/user?access_token=" . $_SESSION['token'];
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		
		$_SESSION['uid'] = json_decode($response, true)['id'];
		$_SESSION['user'] = json_decode($response, true)['login'];
		curl_close($ch);
		
		header("Location: http://furryfaust.com/clayworld/lab.php");
		die(); 
	}
}
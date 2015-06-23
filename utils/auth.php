<?php
session_start();

$link = $_GET['link'];
$_SESSION['history'] = $link;

if (!isset($_SESSION['token'])) {
	function randStrGen($len) {
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
		    $randItem = array_rand($charArray);
		    $result .= "".$charArray[$randItem];
		}
		    return $result;
	}
	$_SESSION['state'] = randStrGen(50);
	if (!isset($_SESSION['history'])) {
		$_SESSION['history'] = "http://furryfaust.com/clayworld/lab.php";
	}
	header("Location: https://github.com/login/oauth/authorize?client_id=179234c27aaecd4eadc8&scope=gist&state=" 
	. $_SESSION['state']);
	die();

} else {
	header("Location: http://furryfaust.com/clayworld/lab.php");
	die();
}
<?php
session_start();

if (isset($_GET['code'])) {
	$_SESSION['code'] = $_GET['code'];
}

header("Location: http://furryfaust.com/clayworld/lab.php");
die(); 
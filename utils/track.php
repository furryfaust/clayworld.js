<?php
session_start();

if (isset($_GET['code'])) {
	if (!isset($_GET['id'])) {
		$_SESSION['code']['0'] = $_GET['code'];
	} else {
		$_SESSION['code'][$_GET['id']] = $_GET['code'];
	}
}

header("Location: http://furryfaust.com/clayworld/lab.php");
die(); 
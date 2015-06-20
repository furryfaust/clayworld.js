<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

session_start();

$title = $_GET['title'];
$code = urldecode($_GET['code']);

if (strlen($title) > 10 && strlen($title) < 101) {
	$data = '{
	  "description": "' . $title . '",
	  "public": true,
	  "files": {
	    "mold.js": {
	      "content": "' . str_replace('"', "", json_encode($code)) . '"
	    }
	  }
	}';
	$url = "https://api.github.com/gists";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    echo $response;

    if (isset($data['id'])) {
		$conn = new PDO('mysql:host=localhost;dbname=clayworld', 'root', '-');
		$sql = "insert into molds(user, title, gid, status) values (:user, :title, :gid, 0)";
		$insert = $conn->prepare($sql);
		$insert->bindParam(':user', $_SESSION['user']);
		$insert->bindParam(':title', $title);
		$insert->bindParam(':gid', $data['id']);
		$insert->execute();
	}
	
}
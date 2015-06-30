<?php
session_start();

$title = $_GET['title'];
$code = $_GET['code'];

if (strlen($title) > 10 && strlen($title) < 101 && isset($_SESSION['token'])) {
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
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: token " . $_SESSION['token']));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    echo 'Hello';

    if (isset(json_decode($response, true)['id'])) {
    	echo 'blah';
	    $id = json_decode($response, true)['id'];
	    $url = "https://api.github.com/gists/" . $id . "/commits";
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_POST, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: token " . $_SESSION['token']));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close($ch);

	    $version = json_decode($response, true)[0]['version'];

		$conn = new PDO('mysql:host=localhost;dbname=clayworld', 'root', 'dbpass');
		$sql = "insert into molds(uid, user, title, gid, version, status) values (:uid, :user, :title, :gid,
					:version, 0)";
		$insert = $conn->prepare($sql);
		$insert->bindParam(':uid', $_SESSION['uid']);
		$insert->bindParam(':user', $_SESSION['user']);
		$insert->bindParam(':title', $title);
		$insert->bindParam(':gid', $id);
		$insert->bindParam(':version', $version);
		$insert->execute();

		$sql = "select * from molds where gid=:gid";
		$query = $conn->prepare($sql);
		$query->bindParam(':gid', $id);
		$query->execute();

		echo 'sss';

		if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			echo $result['id'];
		}
	}	
}
<?php
session_start();

$title = $_GET['title'];
$code = $_GET['code'];
$id = $_GET['id'];

if (strlen($title) > 10 && strlen($title) < 101 && isset($_SESSION['token'])) {

	$conn = new PDO('mysql:host=localhost;dbname=clayworld', 'root', 'dbpass');
	$sql = "select * from molds where id=:id";
	$query = $conn->prepare($sql);
	$query->bindParam(':id', $id);
	$query->execute();

	if ($result = $query->fetch(PDO::FETCH_ASSOC)) {

		$gid = $result['gid'];
		$data = '{
			"description": "' . $title . '",
			"files": {
				"mold.js": {
				 	"content": "' . str_replace('"', "", json_encode($code)) . '"
				}
			}';

		$url = "https://api.github.com/gists/" . $gid;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: token " . $_SESSION['token']));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);

		if (isset(json_decode($response, true)['history'])) {
			$version = json_decode($response, true)['history'][0]['version'];

			$sql = "update molds set title=:title, status=0, version=:version where gid=:gid";
			$update = $conn->prepare($sql);
			$update->bindParam(':title', $title);
			$update->bindParam(':version', $version);
			$update->bindParam(':gid', $gid);
			$update->execute();
		}
	}
}
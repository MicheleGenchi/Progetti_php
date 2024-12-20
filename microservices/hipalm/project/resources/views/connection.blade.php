<?php

$dsn = $_POST["dsn"] ?? 'mysql:dbname=hipalm;host=db';
$user = $_POST['user'] ?? 'hipalm';
$password = $_POST["password"] ?? 'root';

try {
	$dbh = new PDO($dsn, $user, $password);
	$response = [
		"Connection" => "OK",
		"data" =>
			[
				"dsn" => $dsn,
				"user" => $user,
				"password" => "******"
			]

	];
	echo "<p>{";
	echo "<br>&nbsp;"."Connection => ".$response["Connection"];
	echo "<br>&emsp;"."data => { ";
	echo "<br>&emsp;&emsp;"."dsn => ".$response["data"]["dsn"];
	echo "<br>&emsp;&emsp;"."user => ".$response["data"]["user"];
	echo "<br>&emsp;&emsp;"."password => ".$response["data"]["password"];
	echo "<br>&emsp;"."}";
	echo "<br>&nbsp;}</p>";

} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
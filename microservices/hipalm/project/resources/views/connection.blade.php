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
	echo "<p>{"."</p><br/>";
	echo "&nbsp;"."Connection => ".$response["Connection"];
	echo "&emsp;"."data => { ";
	echo "&emsp;&emsp;"."dsn => ".$response["data"]["dsn"];
	echo "&emsp;&emsp;"."user => ".$response["data"]["user"];
	echo "&emsp;&emsp;"."password => ".$response["data"]["password"];
	echo "&emsp;"."}";
	echo "&nbsp;}</p>";

} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
<?php
$dsn = 'mysql:dbname=hipalm;host=db';
$user = 'hipalm';
$password = 'root';

try {
	$dbh = new PDO($dsn, $user, $password);
	return ["Connection" => "OK",
			[data =>
			["dsn" => $dsn,
			"user"=> $user,
			"password" => "******"];
			]
];
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
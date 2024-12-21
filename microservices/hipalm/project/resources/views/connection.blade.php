<?php
	$dsn = $_POST["dsn"] ?? 'mysql:dbname=hipalm;host=db';
	$user = $_POST['user'] ?? 'hipalm';
	$password = $_POST["password"] ?? 'root';

try {
	$db = new PDO($dsn, $user, $password);
	$tables = $db->query("SHOW TABLES");
	echo "<h5>";
	echo "&nbsp;"."Connection => OK";
	echo "<br>&emsp;&emsp;"."dsn &emsp;&emsp;&nbsp;&nbsp;=> $dsn";
	echo "<br>&emsp;&emsp;"."user &emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=> $user";
	echo "<br>&emsp;&emsp;"."password => $password";
	echo "</h5>";
	echo "<hr>";
	echo "<h3>Tabelle</h3>";	
	$query=$db->query("SHOW TABLES");
	$tables=$query->fetchAll(PDO::FETCH_COLUMN);
	echo "<h4>";
	foreach ($tables as $i => $value) {
		echo $i." => ".$value."<br>";
	}
	echo "</h4>";
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
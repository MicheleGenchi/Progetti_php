<?php
$dsn = 'mysql:dbname=hipalm;host=db';
$user = 'hipalm';
$password = 'root';

try
{
    $dbh = new PDO($dsn, $user, $password);
    echo 'Connection worked' . $e->getMessage();
}
catch (PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}
<?php
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "login";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

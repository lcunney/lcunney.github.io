<?php
require_once '../config.php';
try {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $message = $e->getMessage();
    throw new PDOException($e->getMessage(), (int) $e->getCode());
    
}
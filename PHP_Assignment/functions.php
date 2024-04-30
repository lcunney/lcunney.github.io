<?php
function get_products() {
try {

	require('../config.php');
	require('../DBconnect.php');
    $pdo = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); 
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error executing query: " . $e->getMessage();
    $products = [];
}
}

function addToCart($id, $name, $price) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}




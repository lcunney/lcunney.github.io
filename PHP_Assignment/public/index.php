<?php

require ('../config.php');
require ('../DBconnect.php');
require ('../functions.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My E-commerce Site</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <div class="container">
      <h1>Music Store</h1>
      <nav>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="container">

      <h2>Please login or register to access site functionality</h2>
      <p>Explore our wide range of products and find exactly what you need.</p>
    </div>
  </section>


  <section>

    <h3>All Products</h3>
    <div class="box-container">
    <?php 
    
    try {
    $query = "SELECT * FROM products";
    $statement = $connection->prepare($query);
    $statement->execute();

    $products = $statement->fetchAll(PDO::FETCH_ASSOC);


    if (!empty($products)) {
      foreach ($products as $product) {
          echo "<div class='product-tile'>";
          echo "<h3>" . $product['name'] . "</h3>";

          $image_url = '../img/' . $product['img']; 
          echo "<img src='" . $image_url . "' alt='" . $product['name'] . "' style='width:300px;'>";
          echo "<p>Price: $" . $product['price'] . "</p>";
          echo "<form action='cart.php' method='post'>";
          echo "<input type='hidden' name='action' value='add'>";
          echo "<input type='hidden' name='id' value='" . $product['id'] . "'>";
          echo "</form>";
          echo "</div>";
      }
  } else {
      echo "<p>No products found.</p>";
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
    </div>
  </section>

  <?php require '../layout/footer.php'; ?>
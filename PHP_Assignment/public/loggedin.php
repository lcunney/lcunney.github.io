<?php

require('../layout/header.php');
require ('../config.php');
require ('../DBconnect.php');
require ('../functions.php');

if (!isset($_SESSION["email"])) {
  header("Location: login.php");
  exit();
}


$user_email = $_SESSION["email"];

?>


  <section class="hero">
    <div class="container">

      <h2>Discover Amazing Products</h2>
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
          echo "<p>Price: €" . $product['price'] . "</p>";
          echo "<form action='cart.php' method='post'>";
          echo "<input type='hidden' name='action' value='add'>";
          echo "<input type='hidden' name='id' value='" . $product['id'] . "'>";
          echo "<button type='submit'>Add to Cart</button>";
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
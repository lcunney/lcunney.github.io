
<?php
session_start();
if ($_SESSION['email'] == false) {
    header("location:login.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Music Store</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header>
    <div class="container">
      <h1>Music Store</h1>
      <nav>
        <ul>
          <li><a href="account.php">Logged in as: <?php echo
            $_SESSION['email']; ?></a></li>
            <li><a href="loggedin.php">Shop</a></li>
            <li><a href="cart.php">Cart</a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </nav>
    </div>
  </header>
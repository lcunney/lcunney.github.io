<?php
session_start();
if (isset($_GET['id'])) {
  $pid = $_GET['id'];
  unset($_SESSION['cart'][$pid]);
  header("location: cart.php");
}
;?>
<?php
require '../layout/header.php';
include('../dbconnect.php');
include('../common.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add' && isset($_POST['id'])) {
    $product_id = $_POST['id'];

    $email = $_SESSION['email'];
    $added_to_cart = addToCart($connection, $email, $product_id);

    if ($added_to_cart) {
        echo "Product added to cart";
    } else {
        echo "Error adding product to cart";
    }

    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'remove' && isset($_POST['id'])) {
    $product_id = $_POST['id'];

    $email = $_SESSION['email'];
    $removed_from_cart = removeFromCart($connection, $email, $product_id);

    if ($removed_from_cart) {
        echo "Product removed from cart";
    } else {
        echo "Error removing product from cart";
    }

    exit();
} 

$email = $_SESSION['email']; 
$sql = "SELECT p.id, p.name, p.price, p.img FROM cart c INNER JOIN products p ON c.product_id = p.id WHERE c.email = :email";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'];
}
?>

<h1>Shopping Cart</h1>
<p>Total Amount: €<?php echo number_format($total_amount, 2); ?></p>
<div class="box-container">
<?php
try {
    if (!empty($cart_items)) {
        foreach ($cart_items as $item) {
            echo "<div class='product-tile'>";
            echo "<h3>" . $item['name'] . "</h3>";

            if (isset($item['img'])) {
                $image_url = '../img/' . $item['img'];
                echo "<img src='" . $image_url . "' alt='" . $item['name'] . "' style='width:300px;'>";
            } else {
                echo "<p>No image available</p>";
            }

            echo "<p>Price: €" . $item['price'] . "</p>";
            echo "<form action='cart.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $item['id'] . "'>";
            echo "<input type='hidden' name='action' value='remove'>";
            echo "<button type='submit'>Remove</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No products found in the cart.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</div>
</body>
</html>

<?php require '../layout/footer.php'; ?>

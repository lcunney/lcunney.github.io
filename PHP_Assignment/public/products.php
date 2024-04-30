<?php
require '../layout/header.php';

include('../dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add' && isset($_POST['id'])) {
    $product_id = $_POST['id'];

    $sql = "INSERT INTO cart (email, product_id) VALUES (:email, :product_id)";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    echo "Product added to cart";
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT p.name, p.price FROM cart c INNER JOIN products p ON c.product_id = p.id WHERE c.email = :email";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>

    <?php if (!empty($cart_items)): ?>
        <ul>
            <?php foreach ($cart_items as $item): ?>
                <li>
                    <?php echo $item['name']; ?> - €<?php echo $item['price']; ?>
                    <form action="removecart.php" method="post">
                        <input type="hidden" name="action" value="remove">

                        <button type="submit">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>


<?php require '../layout/footer.php';
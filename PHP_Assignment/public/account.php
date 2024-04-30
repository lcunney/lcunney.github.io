<?php require '../layout/header.php'; ?>

<?php

include('../dbconnect.php');

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password']; 
    
    $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, password = :password WHERE email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    header("Location: account.php");
    exit();
}
?>

<body>
    <h1>My Account</h1>
    <h2>My Information</h2>
    <img src="../img/avatar.jpg" width="100px" height="100px">
    <p>First Name: <?php echo $user['firstname']; ?></p>
    <p>Last Name: <?php echo $user['lastname']; ?></p>
    <p>Email: <?php echo $user['email']; ?></p>
    <br><br>
    <h2>Update Information</h2>
    <form method="post">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>"><br>
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value=""><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>


<?php require '../layout/footer.php';
<?php
require '../DBconnect.php';
function escape($data)
{
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function emailValidate($email)
{
    require_once '../DBconnect.php'; 

    try {
        $sql = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return ($result['count'] === 0);
    } catch (PDOException $error) 
    {
        echo $sql . "<br>" . $error->getMessage();
        return false; 
    }
}


function addToCart($connection, $email, $product_id)
{
    try {
        $sql = "INSERT INTO cart (email, product_id) VALUES (:email, :product_id)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return true;
    } catch (PDOException $error) {
        return false;
    }
}
function removeFromCart($connection, $email, $product_id) {
    $sql = "DELETE FROM cart WHERE email = :email AND product_id = :product_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':product_id', $product_id);
    return $stmt->execute();
}

?>

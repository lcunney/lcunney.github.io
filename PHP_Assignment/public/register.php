<?php
session_start();

require_once "../common.php";

$errors = [];

if (isset($_POST['submit'])) {
    if (empty($_POST['firstname'])) {
        $errors[] = "First name is required.";
    } else {
        $firstname = escape($_POST['firstname']);
    }

    if (empty($_POST['lastname'])) {
        $errors[] = "Last name is required.";
    } else {
        $lastname = escape($_POST['lastname']);
    }

    if (empty($_POST['email'])) {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address format.";
    } else {
        $email = escape($_POST['email']);
    }

    if (empty($_POST['password'])) {
        $errors[] = "Password is required.";
    } elseif (strlen($_POST['password']) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    } else {
        $password = escape($_POST['password']);
    }

    if (empty($errors)) {
        try {
            require_once '../DBconnect.php';
            
            $sql = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                $errors[] = "Email address is already in use.";
            } else {
                $new_user = array(
                    "firstname" => $firstname,
                    "lastname" => $lastname,
                    "email" => $email,
                    "password" => $password,
                );
                $sql = sprintf(
                    "INSERT INTO %s (%s) VALUES (%s)",
                    "users",
                    implode(", ", array_keys($new_user)),
                    ":" . implode(", :", array_keys($new_user))
                );
                $statement = $connection->prepare($sql);
                $statement->execute($new_user);

                echo $firstname . ' successfully added';
            }
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }
}
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
      <h1>My Website</h1>
      <nav>
        <ul>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        </ul>
      </nav>
    </div>
  </header>
<h2>Register</h2>
<form method="post">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" ><br>
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" ><br>
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" ><br>
    <label for="age">Password</label>
    <input type="password" name="password" id="password" minlength="6" required><br>
    <input type="submit" name="submit" value="Submit">
</form>
<?php
if (!empty($errors)) {
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
}
?>
<?php include "../layout/footer.php"; ?>

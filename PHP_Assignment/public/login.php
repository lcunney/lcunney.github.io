<?php
session_start();
require_once('../common.php');
require_once('../DBconnect.php');

$errors = [];

if(isset($_POST['login'])) {
    if(empty($_POST["email"]) || empty($_POST["password"])) {
        $errors[] = 'All fields are required.';
    } else {
        $email = escape($_POST["email"]);
        $password = escape($_POST["password"]);

        $query = "SELECT * FROM users WHERE email = :email AND password = :password";
        $statement = $connection->prepare($query);
        $statement->execute(array(
            'email' => $email,
            'password' => $password
        ));

        $count = $statement->rowCount();
        if($count > 0) {
            $_SESSION["email"] = $email;
            header("location: loggedin.php");
            exit();
        } else {
            $errors[] = 'Email or password incorrect.';
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

<div class="container">
    <form action="" method="post" name="LoginForm" class="form-group">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php
        if(!empty($errors)) {
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>'.$error.'</li>';
            }
            echo '</ul>';
        }
        ?>
        <br><br>
        <label for="email">Email</label>
        <input name="email" type="email" id="email" class="form-control" ><br><br>
        <label for="password">Password</label>
        <input name="password" type="password" id="password" class="form-control" ><br><br>

        <button name="login" value="login" class="button" type="submit">Sign in</button>
        <br><br>
        <button><a href="register.php">Register an account</a></button>
    </form>
</div>
</body>
</html>

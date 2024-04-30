CREATE DATABASE IF NOT EXISTS store;

-- Use the store database
USE store;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Create the products table
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    img VARCHAR (100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

INSERT INTO products (products_id, name, img, price)
(1, Guitar, guitar.jpg, 320.00)
(2, Bass, bass.jpg, 260.00)
(3, Keyboard, keyboard.jpg, 560.00)
(4, Banjo, banjo.jpg, 500.00)

-- Create the cart table
CREATE TABLE IF NOT EXISTS cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (email) REFERENCES users(email),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

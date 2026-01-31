<?php

<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['MYSQL_HOST'];
$username   = $_ENV['MYSQL_USER'];
$password   = $_ENV['MYSQL_PASSWORD'];
$dbname     = $_ENV['MYSQL_DB'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$image = trim($_POST['image']);
$price = floatval($_POST['price']);
$tag = trim($_POST['tag']);

if (empty($name) || empty($description) || empty($image) || $price <= 0 || empty($tag)) {
  echo "Please fill out all fields correctly.";
  exit;
}

$stmt = $conn->prepare("INSERT INTO menu (name, description, image, price, tag) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $name, $description, $image, $price, $tag);

if ($stmt->execute()) {
  echo "Item added successfully! <a href='AddNew.html'>Add another</a>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
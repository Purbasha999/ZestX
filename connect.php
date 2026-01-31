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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $image = $_POST["image"];
    $price = $_POST["price"];
    $tag = $_POST["tag"];

    $sql = "INSERT INTO items (name, description, image, price, tag) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssd", $name, $description, $image, $price, $tag);
    
    if ($stmt->execute()) {
        echo "Item added successfully!";
    } else {
        echo "Error adding item: " . $conn->error;
    }
    
    $stmt->close();
}

$conn->close();
?>

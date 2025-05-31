<?php
require 'db.php';

$food_id = $_POST['food_id'];
$quantity = $_POST['quantity'];

// Get price
$stmt = $conn->prepare("SELECT price FROM foods WHERE id = ?");
$stmt->bind_param("i", $food_id);
$stmt->execute();
$stmt->bind_result($price);
$stmt->fetch();
$stmt->close();

$total = $price * $quantity;
$dayOfWeek = date('l'); // e.g., 'Monday', 'Tuesday'

// Insert sale with day_of_week
$stmt = $conn->prepare("INSERT INTO sales (food_id, quantity, total, day_of_week) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iids", $food_id, $quantity, $total, $dayOfWeek);
$stmt->execute();
$stmt->close();

$conn->close();
header("Location: index.php");
exit();
?>

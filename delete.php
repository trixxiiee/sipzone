<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("No ID specified.");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: dashboard.php");
exit();
?>

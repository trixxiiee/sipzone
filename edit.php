<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Sale ID missing.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];

    // Get new price and total
    $stmt = $conn->prepare("SELECT price FROM foods WHERE id = ?");
    $stmt->bind_param("i", $food_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();

    $total = $price * $quantity;

    $stmt = $conn->prepare("UPDATE sales SET food_id = ?, quantity = ?, total = ? WHERE id = ?");
    $stmt->bind_param("iidi", $food_id, $quantity, $total, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}

// Get sale info
$stmt = $conn->prepare("SELECT food_id, quantity FROM sales WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($food_id, $quantity);
$stmt->fetch();
$stmt->close();

// Get list of foods
$foods = $conn->query("SELECT id, name FROM foods");
?>

<h2>Edit Sale</h2>
<form method="POST">
    <label>Product:</label>
    <select name="food_id" required>
        <?php
        while ($row = $foods->fetch_assoc()) {
            $selected = $row['id'] == $food_id ? "selected" : "";
            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Quantity:</label>
    <input type="number" name="quantity" value="<?= $quantity ?>" required><br><br>

    <button type="submit">Update</button>
    <a href="dashboard.php">Cancel</a>
</form>

<?php $conn->close(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Sales Input</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Food Sales Tracker</h1>

    <form action="insert.php" method="POST">
        <label for="food">Select Food:</label>
        <select name="food_id" required>
            <?php
            include 'db.php';
            $result = $conn->query("SELECT * FROM foods");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']} - $ {$row['price']}</option>";
            }
            ?>
        </select>

        <label for="quantity">Quantity Sold:</label>
        <input type="number" name="quantity" required>

        <button type="submit">Record Sale</button>
    </form>

    <hr>
    <h2>Sales Dashboard</h2>
    <iframe src="dashboard.php" width="100%" height="400px" style="border:none;"></iframe>
</body>
</html>

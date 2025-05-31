<?php
require 'db.php';

$selected_day = isset($_GET['day']) ? $_GET['day'] : date('l');

// Dropdown
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
echo "<form method='GET' style='margin-bottom: 20px;'>
        <label for='day'><strong>Select a day:</strong></label>
        <select name='day' id='day' onchange='this.form.submit()'>";
foreach ($days as $day) {
    $selected = $selected_day == $day ? 'selected' : '';
    echo "<option value='$day' $selected>$day</option>";
}
echo "  </select>
    </form>";

echo "<h2>Sales Records for $selected_day</h2>";

$sql = "
    SELECT s.id, f.name AS food_name, s.quantity, s.total
    FROM sales s
    JOIN foods f ON s.food_id = f.id
    WHERE s.day_of_week = ?
    ORDER BY s.sale_time DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selected_day);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>Food</th><th>Quantity</th><th>Total</th><th>Actions</th></tr>";

$total_all = 0;
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $food = htmlspecialchars($row['food_name']);
    $qty = $row['quantity'];
    $total = number_format($row['total'], 2);
    $total_all += $row['total'];

    echo "<tr>
        <td>$food</td>
        <td>$qty</td>
        <td>$total</td>
        <td>
            <a href='edit.php?id=$id'>Edit</a> |
            <a href='delete.php?id=$id' onclick=\"return confirm('Are you sure you want to delete this sale?');\">Delete</a>
        </td>
    </tr>";
}

echo "<tr style='font-weight: bold; background: #f2f2f2;'>
        <td colspan='2'>TOTAL REVENUE FOR $selected_day</td>
        <td colspan='2'>" . number_format($total_all, 2) . "</td>
      </tr>";
echo "</table>";


$stmt->close();
$conn->close();
?>

<form action="archive.php" method="POST" onsubmit="return confirm('Are you sure you want to archive today\'s sales?');">
    <button type="submit">📦 Archive Today's Sales</button>
</form>


<?php
require 'db.php';

// Days of the week for dropdown
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Get selected day or default to today
$selected_day = isset($_GET['day']) ? $_GET['day'] : date('l');

// Fetch foods to map food_id to food name
$foods = [];
$resultFoods = $conn->query("SELECT id, name FROM foods");
while ($row = $resultFoods->fetch_assoc()) {
    $foods[$row['id']] = htmlspecialchars($row['name']);
}

// Prepare and execute query to get archived sales for the selected day
$sql = "SELECT food_id, quantity, total, sale_time, archived_at
        FROM sales_archive
        WHERE day_of_week = ?
        ORDER BY sale_time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selected_day);
$stmt->execute();
$result = $stmt->get_result();

?>

<style>
  /* Dropdown container */
  #archiveDropdown {
    margin: 20px 0;
  }
  /* Button styling */
  #toggleArchiveBtn {
    padding: 8px 16px;
    font-size: 16px;
    cursor: pointer;
  }
  /* Content inside dropdown */
  #archiveContent {
    margin-top: 10px;
    display: none;
  }
</style>

<div id="archiveDropdown">
  <button id="toggleArchiveBtn">Show Archived Sales</button>

  <div id="archiveContent">
    <h2>Archived Sales for <?php echo htmlspecialchars($selected_day); ?></h2>

    <!-- Day selection form -->
    <form method="GET" style="margin-bottom: 20px;">
      <label for="day">Select day:</label>
      <select name="day" id="day" onchange="this.form.submit()">
        <?php foreach ($days as $day): 
          $sel = ($day === $selected_day) ? 'selected' : '';
        ?>
          <option value="<?php echo $day; ?>" <?php echo $sel; ?>><?php echo $day; ?></option>
        <?php endforeach; ?>
      </select>
    </form>

    <!-- Archive table -->
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%;">
      <tr><th>Food</th><th>Quantity</th><th>Total</th><th>Sale Time</th><th>Archived At</th></tr>
      <?php
      $totalRevenue = 0;
      while ($row = $result->fetch_assoc()):
          $foodName = $foods[$row['food_id']] ?? 'Unknown';
          $quantity = $row['quantity'];
          $total = number_format($row['total'], 2);
          $saleTime = $row['sale_time'];
          $archivedAt = $row['archived_at'];
          $totalRevenue += $row['total'];
      ?>
      <tr>
        <td><?php echo $foodName; ?></td>
        <td><?php echo $quantity; ?></td>
        <td><?php echo $total; ?></td>
        <td><?php echo $saleTime; ?></td>
        <td><?php echo $archivedAt; ?></td>
      </tr>
      <?php endwhile; ?>
      <tr style="font-weight:bold; background:#f2f2f2;">
        <td colspan="2">TOTAL REVENUE FOR <?php echo htmlspecialchars($selected_day); ?></td>
        <td><?php echo number_format($totalRevenue, 2); ?></td>
        <td colspan="2"></td>
      </tr>
    </table>
  </div>
</div>

<script>
// Toggle the dropdown content
document.getElementById('toggleArchiveBtn').addEventListener('click', function() {
  const content = document.getElementById('archiveContent');
  if (content.style.display === 'none' || content.style.display === '') {
    content.style.display = 'block';
    this.textContent = 'Hide Archived Sales';
  } else {
    content.style.display = 'none';
    this.textContent = 'Show Archived Sales';
  }
});
</script>

<?php
$stmt->close();
$conn->close();
?>

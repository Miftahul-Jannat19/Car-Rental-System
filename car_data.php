<?php
$conn = new mysqli("localhost", "root", "", "carrus");
if ($conn->connect_error) {
  echo "<option disabled>DB Error</option>";
  exit;
}

$sql = "SELECT id, registrationNumber, model FROM cars WHERE is_rented = 0";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
  echo "<option value='{$row['id']}'>{$row['registrationNumber']} - {$row['model']}</option>";
}
$conn->close();
?>

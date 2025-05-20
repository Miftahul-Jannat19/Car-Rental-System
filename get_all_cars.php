<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "carrus");

$result = $conn->query("SELECT id, registrationNumber, model FROM cars");
$cars = [];

while ($row = $result->fetch_assoc()) {
  $model = strtolower(str_replace(' ', '', $row['model']));
  $row['image'] = "images/cars/{$model}.jpg";
  $cars[] = $row;
}
echo json_encode($cars);
?>

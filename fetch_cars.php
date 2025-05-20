<?php
header('Content-Type: application/json');

// DB connection
$conn = new mysqli("localhost", "root", "", "carrus");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT * FROM cars WHERE is_rented = 0";
$result = $conn->query($sql);

$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

echo json_encode($cars);

$conn->close();
?>

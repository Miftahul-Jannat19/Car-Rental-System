<?php
$host = 'localhost';
$db   = 'carrus';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'DB connection failed']));
}

$result = $conn->query("SELECT license_number, license_class, registered_at FROM drivers ORDER BY registered_at DESC");

$drivers = [];
while ($row = $result->fetch_assoc()) {
    $drivers[] = $row;
}

echo json_encode(['success' => true, 'drivers' => $drivers]);

$conn->close();
?>

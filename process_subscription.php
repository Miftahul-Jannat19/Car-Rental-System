<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userId'])) {
  echo json_encode(['success' => false, 'message' => 'User not logged in']);
  exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(['success' => false, 'message' => 'Database connection failed']);
  exit;
}

$userId = $_SESSION['userId'];
$carId = $_POST['carId'];
$startDate = $_POST['startDate'];
$duration = $_POST['duration'];
$address = $_POST['address'];
$driver = $_POST['driver'];
$price = $_POST['price'];
$transaction = $_POST['transaction'];

$stmt = $conn->prepare("INSERT INTO subscriptions (user_id, car_id, start_date, duration_months, address, driver_required, price, transaction_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisisssd", $userId, $carId, $startDate, $duration, $address, $driver, $price, $transaction);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();
?>

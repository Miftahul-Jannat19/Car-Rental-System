<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check login
if (!isset($_SESSION['user_id'])) {
  die("User not logged in.");
}

// Get and sanitize input
$user_id = $_SESSION['user_id'];
$address = $conn->real_escape_string($_POST['address']);
$driver = $_POST['driver'];
$days = (int) $_POST['days'];
$offer_code = strtoupper(trim($_POST['offer']));
$total_amount = floatval(preg_replace('/[^0-9.]/', '', $_POST['totalAmount']));
$payment = $_POST['payment'];

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (user_id, address, driver, days, offer_code, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issisds", $user_id, $address, $driver, $days, $offer_code, $total_amount, $payment);

if ($stmt->execute()) {
  echo "<script>alert('Booking successful!'); window.location.href='confirmation.php';</script>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

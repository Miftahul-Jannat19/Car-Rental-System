<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

// Check login
if (!isset($_SESSION['user_id'])) {
  die("Please log in to view your booking.");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Get the latest booking
$sql = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_time DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking Confirmation - CARRUS</title>
  <link rel="stylesheet" href="carrusCSS/confirmation.css" />
</head>
<body>
  <div class="confirmation-container">
    <h2>✅ Booking Confirmed!</h2>

    <?php if ($booking): ?>
    <div class="booking-details">
      <p><strong>Pickup Address:</strong> <?= htmlspecialchars($booking['address']) ?></p>
      <p><strong>Driver:</strong> <?= htmlspecialchars($booking['driver']) ?></p>
      <p><strong>Days:</strong> <?= $booking['days'] ?></p>
      <p><strong>Offer Code:</strong> <?= htmlspecialchars($booking['offer_code']) ?: 'None' ?></p>
      <p><strong>Total Paid:</strong> Tk <?= number_format($booking['total_amount'], 2) ?></p>
      <p><strong>Payment Method:</strong> <?= htmlspecialchars($booking['payment_method']) ?></p>
      <p><strong>Booking Time:</strong> <?= $booking['booking_time'] ?></p>
    </div>
    <?php else: ?>
      <p>No booking information found.</p>
    <?php endif; ?>

    <a href="home.html" class="btn">Return to Home</a>
  </div>
</body>
</html>

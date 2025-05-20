<?php
include 'db.php';

$userId = $_GET['userId'];
$status = $_GET['status'] ?? '';
$date = $_GET['date'] ?? '';

$query = "SELECT b.*, c.make, c.model, c.year, d.name AS driver_name 
          FROM bookings b
          JOIN cars c ON b.car_id = c.id
          LEFT JOIN drivers d ON b.driver_id = d.id
          WHERE b.user_id = ?";

$params = [$userId];
$types = 'i';

if ($status !== '') {
  $query .= " AND b.status = ?";
  $types .= 's';
  $params[] = $status;
}

if ($date !== '') {
  $query .= " AND DATE(b.booking_date) = ?";
  $types .= 's';
  $params[] = $date;
}

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
  $bookings[] = $row;
}

echo json_encode($bookings);
?>

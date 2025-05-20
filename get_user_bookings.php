<?php
$conn = new mysqli("localhost", "root", "", "carrus");
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT id, car_model, rent_date FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = [];
while ($row = $result->fetch_assoc()) {
  $bookings[] = $row;
}
echo json_encode($bookings);
?>

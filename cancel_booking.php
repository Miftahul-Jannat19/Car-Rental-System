<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("UPDATE bookings SET status='cancelled' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo "Cancelled";
?>

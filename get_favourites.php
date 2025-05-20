<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "carrus");
if ($conn->connect_error) {
  echo json_encode([]);
  exit;
}

$user_id = $_SESSION['user_id'] ?? 1;

// add `c.id as id` to select
$sql = "SELECT c.id, c.registrationNumber, c.model
        FROM favourite_cars f
        JOIN cars c ON f.car_id = c.id
        WHERE f.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$favourites = [];
while ($row = $result->fetch_assoc()) {
  $model = strtolower(str_replace(' ', '', $row['model']));
  $row['image'] = "images/cars/{$model}.jpg"; // Path to the image
  $favourites[] = $row;
}

echo json_encode($favourites);

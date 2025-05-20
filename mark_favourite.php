<?php
session_start();
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "carrus");
if ($conn->connect_error) {
  echo json_encode(["success" => false, "message" => "DB Error"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$car_id = $data["carId"];
$user_id = $_SESSION["user_id"] ?? 1;

$stmt = $conn->prepare("INSERT IGNORE INTO favourite_cars (user_id, car_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $car_id);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>

<?php
session_start();
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "carrus");
$data = json_decode(file_get_contents("php://input"), true);
$car_id = $data["carId"];
$user_id = $_SESSION["user_id"] ?? 1;

$stmt = $conn->prepare("DELETE FROM favourite_cars WHERE user_id = ? AND car_id = ?");
$stmt->bind_param("ii", $user_id, $car_id);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>

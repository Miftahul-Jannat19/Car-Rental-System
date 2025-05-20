<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "carrus");
if ($conn->connect_error) {
  echo json_encode(["success" => false, "message" => "DB connection failed"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_SESSION['user_id'] ?? 1;

$car_id = $data['carId'];
$start_date = $data['startDate'];
$duration = (int)$data['duration'];
$address = $data['address'];
$need_driver = $data['driver'] === 'yes' ? 1 : 0;
$total_price = floatval($data['price']);
$transaction = $data['transaction'];

$conn->query("UPDATE cars SET is_rented = 1, rented_by = $user_id WHERE id = $car_id");

$stmt = $conn->prepare("INSERT INTO subscription (user_id, car_id, start_date, duration, address, need_driver, total_price, transaction_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisisiis", $user_id, $car_id, $start_date, $duration, $address, $need_driver, $total_price, $transaction);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>

<?php
header("Content-Type: application/json");
include 'db_config.php';

$userId = $_GET['userId'] ?? null;

if (!$userId) {
    http_response_code(400);
    echo json_encode(["message" => "User ID is required"]);
    exit;
}

$sql = "SELECT payment_method, amount, transaction_id, payment_date
        FROM payments WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$payments = [];

while ($row = $result->fetch_assoc()) {
    $payments[] = $row;
}

echo json_encode($payments);
?>

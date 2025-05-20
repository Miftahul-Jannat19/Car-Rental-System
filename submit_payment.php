<!-- <?php
header("Content-Type: application/json");
include 'db_config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['user']['id'], $data['paymentMethod'], $data['amount'], 
    $data['transactionId'], $data['paymentDate'])
) {
    http_response_code(400);
    echo json_encode(["message" => "Missing required fields"]);
    exit;
}

$userId = $data['user']['id'];
$method = $data['paymentMethod'];
$amount = $data['amount'];
$txnId = $data['transactionId'];
$date = $data['paymentDate'];

$sql = "INSERT INTO payments (user_id, payment_method, amount, transaction_id, payment_date)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isdss", $userId, $method, $amount, $txnId, $date);

if ($stmt->execute()) {
    echo json_encode(["message" => "Payment submitted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Database error"]);
}
?> -->

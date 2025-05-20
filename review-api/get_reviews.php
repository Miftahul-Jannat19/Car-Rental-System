<?php
header("Content-Type: application/json");

// Allow requests from any origin (for local testing only)
header("Access-Control-Allow-Origin: *");

// DB connection
$conn = new mysqli("localhost", "root", "", "carrus"); // replace with your DB details
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit;
}

$sql = "SELECT userId, reviewText, rating, created_at FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode($reviews);
$conn->close();
?>

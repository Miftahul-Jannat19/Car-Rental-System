<?php
header("Content-Type: application/json");

// Allow requests from any origin (for local testing only)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Connect to MySQL
$host = "localhost";
$db = "carrus"; // replace with your DB name
$user = "root";
$pass = ""; // your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed"]);
    exit;
}

// Get input JSON
$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['userId'] ?? '';
$reviewText = $data['reviewText'] ?? '';
$rating = $data['rating'] ?? '';

// Validate
if (empty($userId) || empty($reviewText) || empty($rating)) {
    http_response_code(400);
    echo json_encode(["message" => "Missing fields"]);
    exit;
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO reviews (userId, reviewText, rating) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $userId, $reviewText, $rating);

if ($stmt->execute()) {
    echo json_encode(["message" => "Review submitted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Error saving review"]);
}

$stmt->close();
$conn->close();
?>

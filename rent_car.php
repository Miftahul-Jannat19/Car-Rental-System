<?php
session_start();

// Set headers to support cross-origin credentials
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost'); // Adjust if you're using a different port or domain
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get input data from fetch POST body
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Check if car_id is provided
if (!isset($data['car_id'])) {
    echo json_encode(['success' => false, 'message' => 'Car ID missing']);
    exit;
}

$carId = intval($data['car_id']);
$userId = $_SESSION['user_id'];

// Connect to the MySQL database
$mysqli = new mysqli("localhost", "root", "", "carrus");

// Check for connection errors
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Sanitize input to prevent SQL injection (use prepared statements if possible)
$carId = $mysqli->real_escape_string($carId);

// Check if the car exists and is available
$result = $mysqli->query("SELECT is_rented FROM cars WHERE id = $carId");
if (!$result || $result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Car not found']);
    $mysqli->close();
    exit;
}

$row = $result->fetch_assoc();
if ($row['is_rented']) {
    echo json_encode(['success' => false, 'message' => 'Car is already rented']);
    $mysqli->close();
    exit;
}

// Update the car to set it as rented
$updateQuery = "UPDATE cars SET is_rented = 1, rented_by = $userId WHERE id = $carId";
if ($mysqli->query($updateQuery)) {
    echo json_encode(['success' => true, 'message' => 'Car rented successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update car status']);
}

$mysqli->close();
?>

<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// DB connection
$host = "localhost";
$db = "carrus";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed"]);
    exit;
}

// Parse input
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize and validate input
$registrationNumber = trim($data["registrationNumber"] ?? '');
$category = trim($data["category"] ?? '');
$seatCapacity = intval($data["seatCapacity"] ?? 0);
$make = trim($data["make"] ?? '');
$year = trim($data["year"] ?? '');
$model = trim($data["model"] ?? '');

if (!$registrationNumber || !$category || !$seatCapacity || !$make || !$year || !$model) {
    http_response_code(400);
    echo json_encode(["message" => "All fields are required"]);
    exit;
}

// Check for duplicates (optional but useful)
$checkStmt = $conn->prepare("SELECT * FROM cars WHERE registrationNumber = ?");
$checkStmt->bind_param("s", $registrationNumber);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    http_response_code(409); // Conflict
    echo json_encode(["message" => "Car with this registration number already exists"]);
    $checkStmt->close();
    $conn->close();
    exit;
}
$checkStmt->close();

// Insert into DB
$stmt = $conn->prepare("INSERT INTO cars (registrationNumber, category, seatCapacity, make, year, model) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisss", $registrationNumber, $category, $seatCapacity, $make, $year, $model);

if ($stmt->execute()) {
    echo json_encode(["message" => "Car registered successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to register car", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database connection parameters
$host = "localhost";
$db = "carrus";
$user = "root";
$pass = "";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Server error
    echo json_encode(["message" => "Database connection failed", "error" => $conn->connect_error]);
    exit;
}

// Prepare SQL query with error handling
$sql = "SELECT * FROM cars ORDER BY id DESC";
if ($result = $conn->query($sql)) {
    $cars = [];

    // Fetch results
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }

    // Send results as JSON
    echo json_encode($cars);
    $result->free(); // Free memory
} else {
    // Handle SQL errors
    http_response_code(500);
    echo json_encode(["message" => "Failed to retrieve cars", "error" => $conn->error]);
}

$conn->close();
?>

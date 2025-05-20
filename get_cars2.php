<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$host = 'localhost';
$user = 'root';  // Replace with your MySQL username
$pass = '';  // Replace with your MySQL password
$db = 'carrus';  // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Query the database to get car details
$result = $conn->query("SELECT * FROM cars ORDER BY year DESC");

if ($result->num_rows > 0) {
    // Fetch all the rows
    $cars = [];
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
    // Ensure the response structure is correct
    echo json_encode(['success' => true, 'cars' => $cars]);
} else {
    // No cars found
    echo json_encode(['success' => false, 'message' => 'No cars available']);
}

// Close connection
$conn->close();
?>

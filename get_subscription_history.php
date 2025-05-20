<?php
// get_subscription_history.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed", "error" => $conn->connect_error]));
}

// Get the user ID (you should be able to fetch this from the session)
$user_id = $_GET['user_id']; // Assuming user_id is passed in the query string

// Fetch subscription history
$sql = "SELECT * FROM subscriptions WHERE user_id = '$user_id' ORDER BY start_date DESC";
$result = $conn->query($sql);

$subscriptions = [];
while ($row = $result->fetch_assoc()) {
    $subscriptions[] = $row;
}

echo json_encode($subscriptions);

$conn->close();
?>

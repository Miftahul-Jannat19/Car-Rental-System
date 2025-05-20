<?php
$host = 'localhost';
$db = 'carrus';  // your database name
$user = 'root';     // your DB username
$pass = '';         // your DB password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Total Users
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];

// Logins Today
$today = date('Y-m-d');
$logins_today = $conn->query("SELECT COUNT(*) AS count FROM login_log WHERE DATE(login_time) = '$today'")->fetch_assoc()['count'];

// Active Sessions (this is optional and basic)
session_start();
$active_sessions = 1; // placeholder

header('Content-Type: application/json');
echo json_encode([
  'total_users' => $total_users,
  'logins_today' => $logins_today,
  'active_sessions' => $active_sessions
]);
?>

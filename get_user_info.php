<?php
header("Content-Type: application/json");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(["error" => "Database connection failed"]);
  exit;
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $stmt = $conn->prepare("SELECT name, email, phone, nid FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    echo json_encode($result->fetch_assoc());
  } else {
    echo json_encode(["error" => "User not found"]);
  }

  $stmt->close();
}

$conn->close();
?>

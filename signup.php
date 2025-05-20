<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $nid = $_POST['nid'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  if ($password !== $confirmPassword) {
    header("Location: signup.html?error=PasswordMismatch");
    exit;
  }

  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  $stmt = $conn->prepare("INSERT INTO users (name, phone, email, nid, password) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $phone, $email, $nid, $hashedPassword);

  if ($stmt->execute()) {
    header("Location: signup.html?success=1");
  } else {
    header("Location: signup.html?error=InsertFailed");
  }

  $stmt->close();
}

$conn->close();
?>

<?php
session_start();

// Set secure session cookie settings (optional, good practice)
ini_set('session.cookie_httponly', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  // Prepare SQL to fetch user
  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  // Check if user exists
  if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId, $name, $hashedPassword);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashedPassword)) {
      // Set session variables
      $_SESSION['user_id'] = $userId;
      $_SESSION['username'] = $name;

      // Log login
      $log_stmt = $conn->prepare("INSERT INTO login_log (user_id) VALUES (?)");
      $log_stmt->bind_param("i", $userId);
      $log_stmt->execute();
      $log_stmt->close();

      echo "<script>
              alert('Login successful!');
              window.location.href = 'profile.php';
            </script>";
    } else {
      echo "<script>alert('Invalid password'); window.history.back();</script>";
    }
  } else {
    echo "<script>alert('User not found'); window.history.back();</script>";
  }

  $stmt->close();
}

$conn->close();
?>

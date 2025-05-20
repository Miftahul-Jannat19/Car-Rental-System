<!-- <?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = htmlspecialchars(trim($_POST["email"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Missing required fields.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Message received.";
    } else {
        http_response_code(500);
        echo "Failed to store message.";
    }

    $stmt->close();
}

$conn->close();
?> -->

<?php
// DB connection
$host = 'localhost';
$db   = 'carrus'; // your DB name
$user = 'root';   // DB user
$pass = '';       // DB password
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get POST data
$licenseNumber = $_POST['licenseNumber'] ?? '';
$licenseClass = $_POST['licenseClass'] ?? '';

if (empty($licenseNumber) || empty($licenseClass)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO drivers (license_number, license_class) VALUES (?, ?)");
$stmt->bind_param("ss", $licenseNumber, $licenseClass);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Driver registered successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}


// ...existing registration logic...

if ($stmt->execute()) {
    // Fetch updated driver list
    $result = $conn->query("SELECT license_number, license_class, registered_at FROM drivers ORDER BY registered_at DESC");

    $drivers = [];
    while ($row = $result->fetch_assoc()) {
        $drivers[] = $row;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Driver registered successfully',
        'drivers' => $drivers
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

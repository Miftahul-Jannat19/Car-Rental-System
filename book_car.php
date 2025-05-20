<!-- <?php
// Setting headers for CORS and JSON response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Retrieve the POST data
$data = json_decode(file_get_contents("php://input"));

// Check if the necessary data is provided
if (!isset($data->email) || !isset($data->carRegistrationNumber) || !isset($data->pickUpLocation) || 
    !isset($data->dropOffLocation) || !isset($data->pickUpDate) || !isset($data->pickUpTime) || 
    !isset($data->totalDays) || !isset($data->totalPrice)) {
    echo json_encode(["message" => "Invalid data"]);
    exit;
}

// Database credentials
$host = "localhost";
$db = "carrus";  // Your database name
$user = "root";  // Your database username
$pass = "";      // Your database password

// Create a database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["message" => "Connection failed"]);
    exit;
}

// SQL query to insert the booking
$query = "INSERT INTO bookings (email, car_registration_number, pick_up_location, drop_off_location, 
          pick_up_date, pick_up_time, total_days, total_price) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters
$stmt->bind_param("ssssssii", $data->email, $data->carRegistrationNumber, $data->pickUpLocation, 
                  $data->dropOffLocation, $data->pickUpDate, $data->pickUpTime, $data->totalDays, $data->totalPrice);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["message" => "Booking successful!"]);
} else {
    echo json_encode(["message" => "Booking failed. Please try again."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?> -->

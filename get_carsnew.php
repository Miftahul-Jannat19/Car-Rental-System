<!-- <?php
$conn = new mysqli("localhost", "root", "", "carrus");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Connection failed"]);
  exit;
}

$result = $conn->query("SELECT id, registrationNumber, model FROM cars WHERE is_rented = 0");
$cars = [];

while ($row = $result->fetch_assoc()) {
  $cars[] = $row;
}

header('Content-Type: application/json');
echo json_encode($cars);
?>
 -->

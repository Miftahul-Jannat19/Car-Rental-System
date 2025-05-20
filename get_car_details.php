<?php
include('config.php');

$car_id = $_GET['car_id'];

$stmt = $conn->prepare("SELECT fixed_rate, make, model FROM cars WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($fixed_rate, $make, $model);
    $stmt->fetch();
    echo json_encode(["fixed_rate" => $fixed_rate, "make" => $make, "model" => $model]);
} else {
    echo json_encode(["error" => "Car not found"]);
}
?>

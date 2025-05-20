<?php
session_start();
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assume user is logged in
    $car_id = $_POST['car_id'];
    $driver_option = $_POST['driver_option'];
    $location = $_POST['location'];
    $subscription_duration = $_POST['subscription_duration'];
    $offer_code = $_POST['offer_code'];

    // Get car details (fixed rate)
    $stmt = $conn->prepare("SELECT fixed_rate FROM cars WHERE id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($fixed_rate);
        $stmt->fetch();
        
        // Calculate total cost based on subscription duration and driver option
        $driver_fee = ($driver_option == 'driver') ? 500 : 0; // Example driver fee
        $total_cost = $fixed_rate * $subscription_duration + $driver_fee;

        // Apply offer if available
        if (!empty($offer_code)) {
            // Check if offer code exists and apply discount (assuming 10% discount for valid codes)
            $stmt = $conn->prepare("SELECT discount_percentage FROM offers WHERE code = ?");
            $stmt->bind_param("s", $offer_code);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($discount_percentage);
                $stmt->fetch();
                $total_cost -= ($total_cost * ($discount_percentage / 100));
            }
        }

        // Insert the booking into the database
        $stmt = $conn->prepare("INSERT INTO car_rentals (user_id, car_id, driver_option, location, subscription_duration, total_cost, offer_code) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissdss", $user_id, $car_id, $driver_option, $location, $subscription_duration, $total_cost, $offer_code);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Booking successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Car not found."]);
    }
}
?>

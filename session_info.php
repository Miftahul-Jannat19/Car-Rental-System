<?php
session_start();

$response = ['loggedIn' => false];

if (isset($_SESSION['userId'])) {
  $response['loggedIn'] = true;
  $response['userId'] = $_SESSION['userId'];
  $response['username'] = $_SESSION['username'];
}

echo json_encode($response);
?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Car Subscription - CARRUS</title>
  <link rel="stylesheet" href="carrusCSS/subscribe.css" />
</head>
<body>
  <nav class="navbar">
   
    <div class="nav-links">
      <a href="./home.html">Back</a>
    </div>
  </nav>

  <div class="main-content">
    <div class="container">
      <h2>Subscribe to a Car</h2>
      <form id="subscription-form">
        <div class="form-group">
          <label for="car">Select Car</label>
          <select id="car" name="carId" required>
            <?php include('car_data.php'); ?>
          </select>
        </div>

        <div class="form-group">
          <label for="start-date">Start Date</label>
          <input type="date" id="start-date" name="startDate" required />
        </div>

        <div class="form-group">
          <label for="duration">Duration</label>
          <select id="duration" name="duration" required>
            <option value="1">1 Month</option>
            <option value="3">3 Months</option>
            <option value="6">6 Months</option>
            <option value="12">12 Months</option>
          </select>
        </div>

        <div class="form-group">
          <label for="address">Pickup Address</label>
          <input type="text" id="address" name="address" required />
        </div>

        <div class="form-group">
          <label for="driver">Need Driver?</label>
          <select id="driver" name="driver">
            <option value="no">No</option>
            <option value="yes">Yes</option>
          </select>
        </div>

        <div class="form-group">
          <label for="price">Estimated Price</label>
          <input type="text" id="price" name="price" readonly />
        </div>

        <div class="form-group">
          <label for="transaction-number">Transaction Number</label>
          <input type="text" id="transaction-number" required />
        </div>

        <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" id="amount" readonly />
        </div>

       <button type="button" onclick="simulatePayment(event)">Pay & Subscribe</button>

    </div>
  </div>

  <div class="container subscription-history">
    <h2>Your Subscription History</h2>
    <?php include('subscription_history.php'); ?>
  </div>

  <!-- <script src="subscribe.js"> -->
     
  </script>
</body>
</html>

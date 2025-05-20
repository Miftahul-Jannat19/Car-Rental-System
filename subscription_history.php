<?php
// session_start();  <-- REMOVE this line here, since session is already started before including this file

if (!isset($_SESSION['userId'])) {
  echo "<p>Please log in to view your subscription history.</p>";
  exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrus";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo "<p>Failed to connect to the database.</p>";
  exit;
}

$userId = $_SESSION['userId'];

$sql = "SELECT s.*, c.make, c.model 
        FROM subscriptions s
        JOIN cars c ON s.car_id = c.id
        WHERE s.user_id = ?
        ORDER BY s.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0): ?>
  <table border="1" cellpadding="10" cellspacing="0">
    <thead>
      <tr>
        <th>Car</th>
        <th>Start Date</th>
        <th>Duration (months)</th>
        <th>Driver</th>
        <th>Address</th>
        <th>Price</th>
        <th>Transaction #</th>
        <th>Subscribed On</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['make'] . ' ' . $row['model']) ?></td>
          <td><?= htmlspecialchars($row['start_date']) ?></td>
          <td><?= htmlspecialchars($row['duration_months']) ?></td>
          <td><?= htmlspecialchars(ucfirst($row['driver_required'])) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
          <td>₹<?= htmlspecialchars(number_format($row['price'], 2)) ?></td>
          <td><?= htmlspecialchars($row['transaction_number']) ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>You have no subscriptions yet.</p>
<?php endif;

$stmt->close();
$conn->close();

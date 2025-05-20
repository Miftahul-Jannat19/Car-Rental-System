<!-- <?php
$conn = new mysqli("localhost", "root", "", "carrus");
$userId = $_POST['userId'];
if ($_FILES['profile_image']['error'] === 0) {
  $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
  $filename = uniqid() . "." . $ext;
  move_uploaded_file($_FILES['profile_image']['tmp_name'], "./profile icon.png" . $filename);

  $stmt = $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
  $stmt->bind_param("si", $filename, $userId);
//   $stmt->execute();
  echo "Uploaded";
} else {
  echo "Upload failed";
}
?> -->

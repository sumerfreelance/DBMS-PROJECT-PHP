<?php
session_start();
include('db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header('Location: view_complaints_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $complaint = $_POST['complaint'];

    $sql = "UPDATE complaints SET complaint = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $complaint, $id);
    $stmt->execute();

    header('Location: view_complaints.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM complaints WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $_SESSION['user']['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();
} else {
    header('Location: view_complaints.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Complaint - University Complaint Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="text-center">Edit Complaint</h2>
    <a href="view_complaints.php" class="btn btn-secondary">Back</a>
  </div>

  <div id="complaintForm" class="mt-4">
    <form method="POST" action="edit_complaint.php">
      <input type="hidden" name="id" value="<?php echo $complaint['id']; ?>">
      <div class="form-group">
        <label for="complaint">Complaint</label>
        <textarea class="form-control" id="complaint" name="complaint" rows="5" required><?php echo htmlspecialchars($complaint['complaint']); ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Update Complaint</button>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
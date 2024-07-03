<?php
session_start();
include('db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header('Location: student_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $roleNumber = $_POST['roleNumber'];
    $category = $_POST['category'];
    $complaint = $_POST['complaint'];

    $sql = "INSERT INTO complaints (username, email, role_number, category, complaint, status) VALUES (?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $email, $roleNumber, $category, $complaint);

    if ($stmt->execute()) {
      echo "<script>alert('Complaint submitted successfully!'); window.location.href='student_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting complaint.'); window.location.href='student_dashboard.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - University Complaint Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="text-center">Student Dashboard</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <div id="complaintForm" class="mt-4">
    <h4>Submit a Complaint</h4>
    <form method="POST" action="student_dashboard.php">
      <div class="form-group">
        <label for="username">Name</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="roleNumber">Role Number</label>
        <input type="text" class="form-control" id="roleNumber" name="roleNumber" required>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" id="category" name="category" required>
          <option value="academic">Academic</option>
          <option value="administrative">Administrative</option>
          <option value="faculty">Faculty</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="form-group">
        <label for="complaint">Complaint</label>
        <textarea class="form-control" id="complaint" name="complaint" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php if (!empty($success)) { ?>
      <div class="mt-3 text-success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if (!empty($error)) { ?>
      <div class="mt-3 text-danger"><?php echo $error; ?></div>
    <?php } ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
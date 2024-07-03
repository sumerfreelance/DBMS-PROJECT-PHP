<?php
session_start();
include('db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header('Location: view_complaints_login.php');
    exit;
}

$email = $_SESSION['user']['email'];

$sql = "SELECT * FROM complaints WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$complaints = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Complaints - University Complaint Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="text-center">Your Complaints</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <div id="complaintsList" class="mt-5">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Category</th>
          <th>Complaint</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($complaints as $complaint) { ?>
          <tr>
            <td><?php echo htmlspecialchars($complaint['category']); ?></td>
            <td><?php echo htmlspecialchars($complaint['complaint']); ?></td>
            <td>
              <?php if ($complaint['status'] == 'pending') { ?>
                <span class="badge badge-warning">Pending</span>
              <?php } elseif ($complaint['status'] == 'resolved') { ?>
                <span class="badge badge-success">Resolved</span>
              <?php } else { ?>
                <span class="badge badge-danger">Deleted</span>
              <?php } ?>
            </td>
            <td>
              <?php if ($complaint['status'] == 'pending') { ?>
                <a href="edit_complaint.php?id=<?php echo $complaint['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
              <?php } else { ?>
                <button class="btn btn-secondary btn-sm" disabled>Edit</button>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
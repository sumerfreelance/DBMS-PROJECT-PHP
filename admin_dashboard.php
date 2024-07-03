<?php
session_start();
include('db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: admin_login.php');
    exit;
}

$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);
$complaints = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - University Complaint Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="text-center">Admin Dashboard</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <div id="pendingComplaintsList" class="mt-5">
    <h4>Pending Complaints</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role Number</th>
          <th>Category</th>
          <th>Complaint</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($complaints as $complaint) { ?>
          <?php if ($complaint['status'] == 'pending') { ?>
            <tr>
              <td><?php echo htmlspecialchars($complaint['username']); ?></td>
              <td><?php echo htmlspecialchars($complaint['email']); ?></td>
              <td><?php echo htmlspecialchars($complaint['role_number']); ?></td>
              <td><?php echo htmlspecialchars($complaint['category']); ?></td>
              <td><?php echo htmlspecialchars($complaint['complaint']); ?></td>
              <td><span class="badge badge-warning">Pending</span></td>
              <td>
                <a href="resolve_complaint.php?id=<?php echo $complaint['id']; ?>" class="btn btn-success btn-sm">Resolve</a>
                <a href="delete_complaint.php?id=<?php echo $complaint['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div id="resolvedComplaintsList" class="mt-5">
    <h4>Resolved Complaints</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role Number</th>
          <th>Category</th>
          <th>Complaint</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($complaints as $complaint) { ?>
          <?php if ($complaint['status'] == 'resolved') { ?>
            <tr>
              <td><?php echo htmlspecialchars($complaint['username']); ?></td>
              <td><?php echo htmlspecialchars($complaint['email']); ?></td>
              <td><?php echo htmlspecialchars($complaint['role_number']); ?></td>
              <td><?php echo htmlspecialchars($complaint['category']); ?></td>
              <td><?php echo htmlspecialchars($complaint['complaint']); ?></td>
              <td><span class="badge badge-success">Resolved</span></td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div id="deletedComplaintsList" class="mt-5">
    <h4>Deleted Complaints</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role Number</th>
          <th>Category</th>
          <th>Complaint</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($complaints as $complaint) { ?>
          <?php if ($complaint['status'] == 'deleted') { ?>
            <tr>
              <td><?php echo htmlspecialchars($complaint['username']); ?></td>
              <td><?php echo htmlspecialchars($complaint['email']); ?></td>
              <td><?php echo htmlspecialchars($complaint['role_number']); ?></td>
              <td><?php echo htmlspecialchars($complaint['category']); ?></td>
              <td><?php echo htmlspecialchars($complaint['complaint']); ?></td>
              <td><span class="badge badge-danger">Deleted</span></td>
            </tr>
          <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
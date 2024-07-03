<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = ['email' => $email, 'role' => 'student'];
        header('Location: student_dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login - University Complaint Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
  <h2 class="text-center">Student Login</h2>
  
  <div id="loginForm" class="mt-4">
    <form method="POST" action="student_login.php">
      <div class="form-group">
        <label for="studentEmail">Email</label>
        <input type="email" class="form-control" id="studentEmail" name="email" required>
      </div>
      <div class="form-group">
        <label for="studentPassword">Password</label>
        <input type="password" class="form-control" id="studentPassword" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <?php if (!empty($error)) { ?>
      <div class="mt-3 text-danger"><?php echo $error; ?></div>
    <?php } ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
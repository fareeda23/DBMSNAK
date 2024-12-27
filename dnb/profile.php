<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$message = '';

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For demonstration, simply updating the session values
    $_SESSION['user']['name'] = htmlspecialchars($_POST['name']);
    $_SESSION['user']['usn'] = htmlspecialchars($_POST['usn']);
    $message = "Profile updated successfully!";
    $user = $_SESSION['user']; // Refresh user data
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
        }
        .card {
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-primary mb-4">Edit Profile</h1>
        
        <!-- Display Success Message -->
        <?php if ($message): ?>
            <div class="alert alert-success" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Profile Form -->
        <div class="card">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="usn" class="form-label">USN</label>
                    <input type="text" class="form-control" id="usn" name="usn" value="<?= isset($user['usn']) ? htmlspecialchars($user['usn']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">User Type</label>
                    <input type="text" class="form-control" id="type" value="<?= isset($user['type']) ? htmlspecialchars($user['type']) : '' ?>" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="student_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg,rgb(57, 65, 77), #c9d6ff);
        }
        #sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            background: linear-gradient(45deg, #1d3557, #457b9d);
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        #sidebar h4 {
            text-align: center;
            color: #ffcd3c;
            margin-bottom: 20px;
        }
        #sidebar .nav-link {
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background-color: #e63946;
            color: white;
            border-radius: 5px;
        }
        #sidebar .nav-item:not(:last-child) {
            margin-bottom: 10px;
        }
        #sidebar .bi {
            font-size: 18px;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
            background: linear-gradient(135deg,rgb(245, 245, 245), #e2f3f5);
            min-height: 100vh;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }
        .carousel-item img {
            object-fit: cover;
            height: 400px;
            border-radius: 10px;
        }
        footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="container-fluid">
            <h4>Student Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="student_dashboard.php"><i class="bi bi-house-door-fill"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="announcement/view_announcement.php"><i class="bi bi-bell-fill"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-book-fill"></i> Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
            <div class="container-fluid">
                <a class="navbar-brand" href="student_dashboard.php">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <h1 class="mb-4">Welcome, <?= htmlspecialchars($user['name']) ?></h1>
            <h2>Your Dashboard</h2>

            <!-- Carousel -->
            <div id="studentCarousel" class="carousel slide mb-4 shadow" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="image1.jpg" class="d-block w-100" alt="Announcement 1">
                    </div>
                    <div class="carousel-item">
                        <img src="image2.webp" class="d-block w-100" alt="Announcement 2">
                    </div>
                    <div class="carousel-item">
                        <img src="image3.png" class="d-block w-100" alt="Announcement 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#studentCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#studentCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-bg-warning mb-3 shadow">
                        <div class="card-header">Notifications</div>
                        <div class="card-body">
                            <h5 class="card-title">Latest Updates</h5>
                            <p class="card-text">Stay informed about important updates and announcements.</p>
                            <a href="announcement/view_announcement.php" class="btn btn-light">View Notifications</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-info mb-3 shadow">
                        <div class="card-header">Resources</div>
                        <div class="card-body">
                            <h5 class="card-title">Student Resources</h5>
                            <p class="card-text">Access study materials, guides, and other helpful resources.</p>
                            <a href="#" class="btn btn-light">Explore Resources</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-success mb-3 shadow">
                        <div class="card-header">Profile</div>
                        <div class="card-body">
                            <h5 class="card-title">Manage Your Profile</h5>
                            <p class="card-text">Update your personal information and preferences.</p>
                            <a href="profile.php" class="btn btn-light">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y') ?> Student Dashboard. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

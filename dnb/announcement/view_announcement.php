<?php
session_start();
require '../db.php';

try {
    // Ensure session variable is set
    if (!isset($_SESSION['user']['id'])) {
        header("Location: ../login.php");
        exit();
    }

    $user_id = $_SESSION['user']['id'];

    // Initialize $announcements as an empty array
    $announcements = [];

    // Fetch announcements based on subscriptions
    $query_annc = "
        SELECT a.Announce_ID, a.Title, a.Content, a.Posted_Date
        FROM announcement a
        JOIN subscription s ON a.Category_ID = s.Category_ID
        WHERE s.USN = :user_id";
    $user_details = $pdo->prepare($query_annc);
    $user_details->execute(['user_id' => $user_id]);
    $announcements = $user_details->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }
        .navbar {
            background-color:rgb(134, 69, 166);
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .navbar .nav-link:hover {
            color: #ffeb3b !important;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #333333;
            font-weight: 600;
        }
        .announcement-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 10px 0;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .announcement-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .announcement-title {
            font-size: 1.5em;
            font-weight: 600;
            color:rgb(200, 16, 157);
        }
        .announcement-date {
            font-size: 0.9em;
            color: #6c757d;
        }
        .modal-header {
            background-color:rgb(102, 127, 154);
            color: white;
        }
        .modal-title {
            font-weight: 600;
        }
        .btn-close {
            color: #ffffff !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="../student_dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="../student_dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="../student_dashboard.php">Back</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-4">Announcements</h1>
        <ul class="announcement-list list-unstyled">
            <?php if (count($announcements) > 0): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <li class="announcement-item" data-bs-toggle="modal" data-bs-target="#announcementModal" 
                        data-title="<?= htmlspecialchars($announcement['Title']) ?>" 
                        data-content="<?= htmlspecialchars($announcement['Content']) ?>" 
                        data-date="<?= htmlspecialchars($announcement['Posted_Date']) ?>">
                        <div class="announcement-title"><?= htmlspecialchars($announcement['Title']) ?></div>
                        <div class="announcement-date">Posted on: <?= htmlspecialchars($announcement['Posted_Date']) ?></div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No announcements available for your subscriptions.</p>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Modal for Announcement Details -->
    <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="announcementModalLabel">Announcement Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modalTitle" class="mb-3"></h4>
                    <p id="modalContent"></p>
                    <p class="text-muted"><small>Posted on: <span id="modalDate"></span></small></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate modal with announcement details
        const announcementModal = document.getElementById('announcementModal');
        announcementModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const content = button.getAttribute('data-content');
            const date = button.getAttribute('data-date');

            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalContent').textContent = content;
            document.getElementById('modalDate').textContent = date;
        });

        // Reset modal content on close
        announcementModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('modalTitle').textContent = '';
            document.getElementById('modalContent').textContent = '';
            document.getElementById('modalDate').textContent = '';
        });
    </script>
</body>
</html>

<?php
require_once '../php/config.php';
require_once '../middleware/admin_auth.php';
require_once '../config/database.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FlickFinder</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <nav class="admin-nav">
            <h1>Admin Dashboard</h1>
            <ul>
                <li><a href="dashboard.php">Overview</a></li>
                <li><a href="manage-movies.php">Manage Movies</a></li>
				<li><a href="upload_tvshows.php">Manage TV Shows</a></li>
                <li><a href="manage-shows.php">Manage TV Shows</a></li>
                <li><a href="manage-users.php">Manage Users</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
        
        <main class="admin-main">
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p><?php echo getTotalUsers(); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Movies</h3>
                    <p><?php echo getTotalMovies(); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total TV Shows</h3>
                    <p><?php echo getTotalShows(); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Reviews</h3>
                    <p><?php echo getTotalReviews(); ?></p>
                </div>
            </div>
            
            <div class="recent-activity">
                <h2>Recent Activity</h2>
                <!-- Add recent activity content -->
            </div>
        </main>
    </div>
    
    <script src="../js/admin.js"></script>
</body>
</html>

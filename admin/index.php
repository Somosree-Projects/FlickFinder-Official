<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlickFinder Admin Dashboard</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="admin-sidebar">
        <h2>FlickFinder Admin</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="upload.php">Manage Movies</a></li>
			<li><a href="upload_tvshows.php">Manage TV Shows</a></li>
            <li><a href="#">Manage Users</a></li>
            <li><a href="http://localhost/Projects/BCA22C003/FlickFinder/">Back to Site</a></li>
			<li><a href="logout.php" class="logout-link">Logout</a></li>
        </ul>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Welcome to Admin Dashboard</h1>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Movies</h3>
                <p>0</p>
            </div>
            <div class="stat-card">
                <h3>Total Users</h3>
                <p>0</p>
            </div>
        </div>
    </div>
</body>
</html>

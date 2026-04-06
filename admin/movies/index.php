// admin/movies/index.php
<?php
require_once '../../middleware/admin_auth.php';
checkAdminAuth();
require_once '../../config/database.php';

// Fetch movies
$query = "SELECT * FROM movies ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<div class="content-header">
    <h2>Manage Movies</h2>
    <a href="/admin/movies/add" class="btn-primary">Add New Movie</a>
</div>

<div class="movie-grid">
    <?php while($movie = $result->fetch_assoc()): ?>
    <div class="movie-card">
        <img src="<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
        <div class="movie-info">
            <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
            <p><?php echo htmlspecialchars($movie['year']); ?></p>
            <div class="actions">
                <a href="/admin/movies/edit/<?php echo $movie['id']; ?>" class="btn-edit">Edit</a>
                <button onclick="deleteMovie(<?php echo $movie['id']; ?>)" class="btn-delete">Delete</button>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

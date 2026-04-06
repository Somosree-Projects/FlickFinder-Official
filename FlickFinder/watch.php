<?php
include 'C:\xampp\htdocs\admin\db.php';

// Input validation
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Get movie details
$movie_id = mysqli_real_escape_string($con, $_GET['id']);
$sql = "SELECT * FROM movies_flick WHERE movie_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $movie_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$movie = mysqli_fetch_assoc($result);

if (!$movie) {
    header("Location: index.php");
    exit();
}

// Handle Google Drive video URL
if(!empty($movie['video_url']) && strpos($movie['video_url'], 'drive.google.com') !== false) {
    $video_embed_url = $movie['video_url'];
} else {
    $video_embed_url = $movie['video_url'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> - FlickFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/watch.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'C:\xampp\htdocs\admin\header.php'; ?>

    <div class="watch-container">
        <div class="movie-info-header">
            <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
            <div class="movie-meta">
                <span class="year"><?php echo htmlspecialchars($movie['release_year']); ?></span>
                <span class="genre"><?php echo htmlspecialchars($movie['genre']); ?></span>
                <?php if($movie['imdb_rating']): ?>
                    <span class="rating">
                        <i class="fas fa-star"></i> IMDb <?php echo number_format($movie['imdb_rating'], 1); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <?php if(!empty($video_embed_url)): ?>
            <div class="video-container">
                <div class="video-wrapper">
                    <iframe
                        src="<?php echo htmlspecialchars($video_embed_url); ?>"
                        frameborder="0"
                        allowfullscreen
                        allow="autoplay; encrypted-media; picture-in-picture"
                        style="position:absolute; top:0; left:0; width:100%; height:100%;">
                    </iframe>
                </div>
                
                <div class="loading-overlay">
                    <div class="loading-spinner"></div>
                    <p>Loading video...</p>
                </div>

                <div class="error-message" style="display: none;">
                    <p>Unable to load video. Please try again later.</p>
                    <button onclick="retryLoading()">Retry</button>
                </div>
            </div>

            <div class="movie-details">
                <h2>About the Movie</h2>
                <p class="description"><?php echo nl2br(htmlspecialchars($movie['description'])); ?></p>
                <div class="movie-additional-info">
                    <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                    <p><strong>Stars:</strong> <?php echo htmlspecialchars($movie['actors']); ?></p>
                    <p><strong>Added on:</strong> <?php echo date('F j, Y', strtotime($movie['created_at'])); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="error-container">
                <h2>Video Not Available</h2>
                <p>Sorry, this video is currently unavailable. Please try again later.</p>
                <a href="index.php" class="back-button">Back to Movies</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'C:\xampp\htdocs\admin\footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iframe = document.querySelector('iframe');
            const loadingOverlay = document.querySelector('.loading-overlay');
            const errorMessage = document.querySelector('.error-message');

            if (iframe) {
                iframe.onload = function() {
                    loadingOverlay.style.display = 'none';
                };

                iframe.onerror = function() {
                    loadingOverlay.style.display = 'none';
                    errorMessage.style.display = 'block';
                };
            }

            // Prevent right-click
            document.addEventListener('contextmenu', (e) => {
                e.preventDefault();
            });
        });

        function retryLoading() {
            const iframe = document.querySelector('iframe');
            const loadingOverlay = document.querySelector('.loading-overlay');
            const errorMessage = document.querySelector('.error-message');

            if (iframe) {
                errorMessage.style.display = 'none';
                loadingOverlay.style.display = 'flex';
                iframe.src = iframe.src;
            }
        }
    </script>
</body>
</html>

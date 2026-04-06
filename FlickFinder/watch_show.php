<?php
include 'C:\xampp\htdocs\admin\db.php';

// Input validation
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Get show details
$show_id = mysqli_real_escape_string($con, $_GET['id']);
$sql = "SELECT * FROM tvshows_flick WHERE show_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $show_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$show = mysqli_fetch_assoc($result);

if (!$show) {
    header("Location: index.php");
    exit();
}

// Handle Google Drive video URL
if(!empty($show['video_url']) && strpos($show['video_url'], 'drive.google.com') !== false) {
    $video_embed_url = $show['video_url'];
} else {
    $video_embed_url = $show['video_url'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($show['title']); ?> - FlickFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/watch_show.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'C:\xampp\htdocs\admin\header.php'; ?>

    <div class="watch-container">
        <div class="show-info-header">
            <h1><?php echo htmlspecialchars($show['title']); ?></h1>
            <div class="show-meta">
                <span class="year"><?php echo htmlspecialchars($show['release_year']); ?></span>
                <span class="genre"><?php echo htmlspecialchars($show['genre']); ?></span>
                <span class="season">Season <?php echo htmlspecialchars($show['seasons']); ?></span>
                <?php if($show['imdb_rating']): ?>
                    <span class="rating">
                        <i class="fas fa-star"></i> IMDb <?php echo number_format($show['imdb_rating'], 1); ?>
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

            <div class="show-details">
                <h2>About the Show</h2>
                <p class="description"><?php echo nl2br(htmlspecialchars($show['description'])); ?></p>
                <div class="show-additional-info">
                    <p><strong>Creator:</strong> <?php echo htmlspecialchars($show['creator']); ?></p>
                    <p><strong>Stars:</strong> <?php echo htmlspecialchars($show['actors']); ?></p>
                    <p><strong>Total Episodes:</strong> <?php echo htmlspecialchars($show['episodes']); ?></p>
                    <p><strong>Added on:</strong> <?php echo date('F j, Y', strtotime($show['created_at'])); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="error-container">
                <h2>Video Not Available</h2>
                <p>Sorry, this episode is currently unavailable. Please try again later.</p>
                <a href="tvshows.php" class="back-button">Back to TV Shows</a>
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

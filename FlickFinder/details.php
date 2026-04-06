<?php
session_start(); // Add this at the top to enable sessions
include 'C:\xampp\htdocs\admin\db.php';

if(isset($_GET['id'])) {
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

    // Check if movie is in watchlist
    $isInWatchlist = false;
    if(isset($_SESSION['user_id'])) {
        $check_watchlist = "SELECT watchlist_id FROM watchlist WHERE user_id = ? AND movie_id = ?";
        $stmt = mysqli_prepare($con, $check_watchlist);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $movie_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $isInWatchlist = mysqli_num_rows($result) > 0;
    }

    // Convert YouTube URL to embed format
    if(!empty($movie['trailer_url'])) {
        if(strpos($movie['trailer_url'], 'youtu.be') !== false) {
            $movie['trailer_url'] = str_replace('youtu.be/', 'www.youtube.com/embed/', $movie['trailer_url']);
        } elseif(strpos($movie['trailer_url'], 'youtube.com/watch?v=') !== false) {
            $movie['trailer_url'] = preg_replace(
                "/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/",
                "youtube.com/embed/$1",
                $movie['trailer_url']
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> - FlickFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'C:\xampp\htdocs\admin\header.php'; ?>

    <div class="movie-details-container">
        <div class="movie-hero" style="background: linear-gradient(to right, rgba(26,15,15,0.95) 50%, transparent 100%), url('<?php echo htmlspecialchars($movie['poster_path']); ?>') no-repeat center center / cover;">
            <div class="content-wrapper">
                <div class="movie-info">
                    <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
                    <div class="movie-meta">
                        <span class="year"><?php echo htmlspecialchars($movie['release_year']); ?></span>
                        <span class="genre"><?php echo htmlspecialchars($movie['genre']); ?></span>
                        <?php if($movie['imdb_rating']): ?>
                            <div class="imdb-rating">
                                <i class="fas fa-star"></i>
                                <span>IMDb <?php echo number_format($movie['imdb_rating'], 1); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="movie-crew">
                        <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                        <?php if(!empty($movie['Writers'])): ?>
                            <p><strong>Writers:</strong> <?php echo htmlspecialchars($movie['Writers']); ?></p>
                        <?php endif; ?>
                        <p><strong>Stars:</strong> <?php echo htmlspecialchars($movie['actors']); ?></p>
                    </div>

                    <p class="description"><?php echo nl2br(htmlspecialchars($movie['description'])); ?></p>
                    
                    <div class="action-buttons">
                        <?php if(!empty($movie['video_url'])): ?>
                            <a href="watch.php?id=<?php echo $movie['movie_id']; ?>" class="play-button">
                                <i class="fas fa-play"></i> Watch Now
                            </a>
                        <?php else: ?>
                            <button class="play-button disabled" disabled>
                                <i class="fas fa-exclamation-circle"></i> Coming Soon
                            </button>
                        <?php endif; ?>
                        <button class="add-to-list <?php echo $isInWatchlist ? 'added' : ''; ?>" 
                                <?php echo !isset($_SESSION['user_id']) ? 'title="Login required"' : ''; ?>
                                <?php echo $isInWatchlist ? 'disabled' : ''; ?>>
                            <i class="fas <?php echo $isInWatchlist ? 'fa-check' : 'fa-plus'; ?>"></i>
                            <?php echo $isInWatchlist ? 'Added to List' : 'Add to List'; ?>
                        </button>
                    </div>
                </div>

                <div class="trailer-container">
                    <h3><i class="fas fa-film"></i> Movie Trailer</h3>
                    <div class="trailer-wrapper">
                        <?php if(!empty($movie['trailer_url'])): ?>
                            <iframe 
                                src="<?php echo htmlspecialchars($movie['trailer_url']); ?>"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        <?php else: ?>
                            <div class="trailer-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <p>Trailer coming soon</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'C:\xampp\htdocs\admin\footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToListBtn = document.querySelector('.add-to-list');
        if(addToListBtn && !addToListBtn.classList.contains('added')) {
            addToListBtn.addEventListener('click', function() {
                <?php if(!isset($_SESSION['user_id'])): ?>
                    window.location.href = 'login.html';
                    return;
                <?php endif; ?>
                
                const movieId = <?php echo $movie['movie_id']; ?>;
                
                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;
                
                // Make the AJAX request
                fetch('add_to_watchlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'movie_id=' + movieId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.innerHTML = '<i class="fas fa-check"></i> Added to List';
                        this.classList.add('added');
                        this.style.background = 'rgba(255, 75, 43, 0.2)';
                        this.disabled = true;
                    } else {
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-plus"></i> Add to List';
                        alert(data.message || 'Error adding movie to list');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-plus"></i> Add to List';
                    alert('Error adding movie to list. Please try again.');
                });
            });
        }
        
        // Trailer loading handling
        const trailerIframe = document.querySelector('.trailer-wrapper iframe');
        if(trailerIframe) {
            trailerIframe.onerror = function() {
                this.closest('.trailer-wrapper').innerHTML = `
                    <div class="trailer-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Trailer temporarily unavailable</p>
                    </div>
                `;
            };
        }
    });
    </script>
</body>
</html>

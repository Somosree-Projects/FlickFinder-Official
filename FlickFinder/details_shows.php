<?php
session_start();
include 'C:\xampp\htdocs\admin\db.php';

if(isset($_GET['id'])) {
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

    // Convert YouTube URL to embed format
    if(!empty($show['trailer_url'])) {
        if(strpos($show['trailer_url'], 'youtu.be') !== false) {
            $show['trailer_url'] = str_replace('youtu.be/', 'www.youtube.com/embed/', $show['trailer_url']);
        } elseif(strpos($show['trailer_url'], 'youtube.com/watch?v=') !== false) {
            $show['trailer_url'] = preg_replace(
                "/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/",
                "youtube.com/embed/$1",
                $show['trailer_url']
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
    <title><?php echo htmlspecialchars($show['title']); ?> - FlickFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/details_show.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'C:\xampp\htdocs\admin\header.php'; ?>

    <div class="show-details-container">
        <div class="show-hero" style="background: linear-gradient(to right, rgba(26,15,15,0.95) 50%, transparent 100%), url('<?php echo htmlspecialchars($show['poster_path']); ?>') no-repeat center center / cover;">
            <div class="content-wrapper">
                <div class="show-info">
                    <h1><?php echo htmlspecialchars($show['title']); ?></h1>
                    <div class="show-meta">
                        <span class="year"><?php echo htmlspecialchars($show['release_year']); ?></span>
                        <span class="genre"><?php echo htmlspecialchars($show['genre']); ?></span>
                        <?php if($show['imdb_rating']): ?>
                            <div class="imdb-rating">
                                <i class="fas fa-star"></i>
                                <span>IMDb <?php echo number_format($show['imdb_rating'], 1); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="show-details">
                        <p><strong>Seasons:</strong> <?php echo htmlspecialchars($show['seasons']); ?></p>
                        <p><strong>Episodes:</strong> <?php echo htmlspecialchars($show['episodes']); ?></p>
                        <p><strong>Creator:</strong> <?php echo htmlspecialchars($show['creator']); ?></p>
                        <p><strong>Stars:</strong> <?php echo htmlspecialchars($show['actors']); ?></p>
                    </div>

                    <p class="description"><?php echo nl2br(htmlspecialchars($show['description'])); ?></p>
                    
                    <div class="action-buttons">
                        <?php if(!empty($show['video_url'])): ?>
                            <a href="watch_show.php?id=<?php echo $show['show_id']; ?>" class="play-button">
                                <i class="fas fa-play"></i> Watch Now
                            </a>
                        <?php else: ?>
                            <button class="play-button disabled" disabled>
                                <i class="fas fa-exclamation-circle"></i> Coming Soon
                            </button>
                        <?php endif; ?>
                        <button class="add-to-list" <?php echo isset($_SESSION['user_id']) ? '' : 'title="Login required"'; ?>>
                            <i class="fas fa-plus"></i> Add to List
                        </button>
                    </div>
                </div>

                <div class="trailer-container">
                    <h3><i class="fas fa-film"></i> Show Trailer</h3>
                    <div class="trailer-wrapper">
                        <?php if(!empty($show['trailer_url'])): ?>
                            <iframe 
                                src="<?php echo htmlspecialchars($show['trailer_url']); ?>"
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
        if(addToListBtn) {
            addToListBtn.addEventListener('click', function() {
                <?php if(!isset($_SESSION['user_id'])): ?>
                    window.location.href = 'login.html';
                    return;
                <?php endif; ?>
                
                const showId = <?php echo $show['show_id']; ?>;
                
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;
                
                fetch('add_to_watchlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'show_id=' + showId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.innerHTML = '<i class="fas fa-check"></i> Added to List';
                        this.style.background = 'rgba(255, 75, 43, 0.2)';
                        this.disabled = true;
                    } else {
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-plus"></i> Add to List';
                        alert(data.message || 'Error adding show to list');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-plus"></i> Add to List';
                    alert('Error adding show to list. Please try again.');
                });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const addToListBtn = document.querySelector('.add-to-list');
        if(addToListBtn) {
            addToListBtn.addEventListener('click', function() {
                <?php if(!isset($_SESSION['user_id'])): ?>
                    window.location.href = 'login.html';
                    return;
                <?php endif; ?>
                
                const showId = <?php echo $show['show_id']; ?>;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;
                fetch('add_to_watchlist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'show_id=' + showId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        this.innerHTML = '<i class="fas fa-check"></i> Added to List';
                        this.style.background = 'rgba(255, 75, 43, 0.2)';
                        this.disabled = true;
                    } else {
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-plus"></i> Add to List';
                        alert(data.message || 'Error adding show to list');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-plus"></i> Add to List';
                    alert('Error adding show to list. Please try again.');
                });
            });
        }
    });
    </script>
</body>
</html>

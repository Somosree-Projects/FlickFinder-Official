<?php
include 'C:\xampp\htdocs\admin\db.php';

// Get all unique genres from the database for TV shows
$genresQuery = "SELECT DISTINCT genre FROM tvshows_flick";
$genresResult = mysqli_query($con, $genresQuery);
$allGenres = [];

while($row = mysqli_fetch_assoc($genresResult)) {
    $genres = explode(', ', $row['genre']);
    foreach($genres as $genre) {
        if(!in_array(trim($genre), $allGenres)) {
            $allGenres[] = trim($genre);
        }
    }
}

sort($allGenres);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlickFinder - TV Shows</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tvshows.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">FlickFinder</div>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="Movies.php">Movies</a>
            <a href="tvshows.php" class="active">TV Shows</a>
            <a href="mylist.php">My List</a>
            <div class="search-container">
                <button class="search-button" onclick="openSearchModal()">
                    <div class="search-icon-wrapper">
                        <i class="fas fa-search"></i>
                    </div>
                    <span class="search-text">Search</span>
                </button>
            </div>
        </div>
    </nav>

    <div id="searchModal" class="search-modal">
        <div class="search-modal-content">
            <span class="close-search">&times;</span>
            <input type="text" id="searchInput" placeholder="Search movies and TV shows...">
            <div id="searchResults" class="search-results"></div>
        </div>
    </div>

    <main class="tvshows-container">
        <h1>TV Shows by Genre</h1>
        
        <?php foreach($allGenres as $index => $genre): ?>
            <?php
            $sql = "SELECT * FROM tvshows_flick WHERE genre LIKE ? ORDER BY created_at DESC";
            $stmt = mysqli_prepare($con, $sql);
            $genreLike = '%' . $genre . '%';
            mysqli_stmt_bind_param($stmt, "s", $genreLike);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) > 0):
            ?>
                <div class="genre-section" id="genre-<?php echo $index; ?>">
                    <h2 class="genre-title"><?php echo $genre; ?></h2>
                    <button class="scroll-btn left" onclick="scrollShows('<?php echo $index; ?>', 'left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="scroll-btn right" onclick="scrollShows('<?php echo $index; ?>', 'right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="shows-grid" id="shows-grid-<?php echo $index; ?>">
                        <?php while($show = mysqli_fetch_assoc($result)): ?>
                            <div class="show-card">
                                <div class="show-poster" style="background-image: url('<?php echo $show['poster_path']; ?>');">
                                    <div class="show-overlay">
                                        <a href="details_shows.php?id=<?php echo $show['show_id']; ?>" class="watch-btn">More Info</a>
                                    </div>
                                    <?php if($show['imdb_rating']): ?>
                                        <div class="imdb-rating">
                                            <span>IMDb</span>
                                            <?php echo number_format($show['imdb_rating'], 1); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="show-info">
                                    <h3><?php echo $show['title']; ?></h3>
                                    <div class="show-meta">
                                        <span class="year"><?php echo $show['release_year']; ?></span>
                                        <span class="genre"><?php echo $show['genre']; ?></span>
                                    </div>
                                    <div class="show-crew">
                                        <span class="creator">Created by: <?php echo $show['creator']; ?></span>
                                        <span class="actors"><?php echo substr($show['actors'], 0, 50) . (strlen($show['actors']) > 50 ? '...' : ''); ?></span>
                                    </div>
                                    <p class="description"><?php echo substr($show['description'], 0, 100) . '...'; ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 FlickFinder. All rights reserved.</p>
        </div>
    </footer>
    <button id="backToTopBtn" onclick="scrollToTop()">↑ Back to Top</button>

    <script>
    function scrollShows(genreIndex, direction) {
        const container = document.getElementById(`shows-grid-${genreIndex}`);
        const scrollAmount = 300;
        
        if (direction === 'left') {
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const showGrids = document.querySelectorAll('.shows-grid');
        
        showGrids.forEach((grid, index) => {
            const section = document.getElementById(`genre-${index}`);
            const leftBtn = section.querySelector('.scroll-btn.left');
            const rightBtn = section.querySelector('.scroll-btn.right');

            leftBtn.style.opacity = '0';

            grid.addEventListener('scroll', function() {
                leftBtn.style.opacity = grid.scrollLeft > 0 ? '1' : '0';
                rightBtn.style.opacity = 
                    (grid.scrollWidth - grid.clientWidth - grid.scrollLeft) > 0 ? '1' : '0';
            });
        });
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    window.addEventListener('scroll', function() {
        const backToTopBtn = document.getElementById('backToTopBtn');
        backToTopBtn.style.display = window.scrollY > 300 ? 'block' : 'none';
    });
    </script>
</body>
</html>

<?php
include 'C:\xampp\htdocs\admin\db.php';

// Get all unique genres from the database
$genresQuery = "SELECT DISTINCT genre FROM movies_flick";
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
    <title>FlickFinder - Movies</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/movies.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">FlickFinder</div>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="Movies.php" >Movies</a>
            <a href="tvshows.php">TV Shows</a>
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

    <main class="movies-container">
        <h1>Movies by Genre</h1>
        
        <?php foreach($allGenres as $index => $genre): ?>
            <?php
            $sql = "SELECT * FROM movies_flick WHERE genre LIKE ? ORDER BY created_at DESC";
            $stmt = mysqli_prepare($con, $sql);
            $genreLike = '%' . $genre . '%';
            mysqli_stmt_bind_param($stmt, "s", $genreLike);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) > 0):
            ?>
                <div class="genre-section" id="genre-<?php echo $index; ?>">
                    <h2 class="genre-title"><?php echo $genre; ?></h2>
                    <button class="scroll-btn left" onclick="scrollMovies('<?php echo $index; ?>', 'left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="scroll-btn right" onclick="scrollMovies('<?php echo $index; ?>', 'right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="movies-grid" id="movies-grid-<?php echo $index; ?>">
                        <?php while($movie = mysqli_fetch_assoc($result)): ?>
                            <div class="movie-card">
                                <div class="movie-poster" style="background-image: url('<?php echo $movie['poster_path']; ?>');">
                                    <div class="movie-overlay">
                                        <a href="details.php?id=<?php echo $movie['movie_id']; ?>" class="watch-btn">More Info</a>
                                    </div>
                                    <?php if($movie['imdb_rating']): ?>
                                        <div class="imdb-rating">
                                            <span>IMDb</span>
                                            <?php echo number_format($movie['imdb_rating'], 1); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="movie-info">
                                    <h3><?php echo $movie['title']; ?></h3>
                                    <div class="movie-meta">
                                        <span class="year"><?php echo $movie['release_year']; ?></span>
                                        <span class="genre"><?php echo $movie['genre']; ?></span>
                                    </div>
                                    <div class="movie-crew">
                                        <span class="director">Dir: <?php echo $movie['director']; ?></span>
                                        <span class="actors"><?php echo substr($movie['actors'], 0, 50) . (strlen($movie['actors']) > 50 ? '...' : ''); ?></span>
                                    </div>
                                    <p class="description"><?php echo substr($movie['description'], 0, 100) . '...'; ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 FlickFinder. All rights reserved.</p>
        </div>
    </footer>
    <button id="backToTopBtn" onclick="scrollToTop()">↑ Back to Top</button>

    <script>
    function scrollMovies(genreIndex, direction) {
        const container = document.getElementById(`movies-grid-${genreIndex}`);
        const scrollAmount = 300; // Adjust this value to control scroll distance
        
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

    // Show/hide scroll buttons based on scroll position
    document.addEventListener('DOMContentLoaded', function() {
        const movieGrids = document.querySelectorAll('.movies-grid');
        
        movieGrids.forEach((grid, index) => {
            const section = document.getElementById(`genre-${index}`);
            const leftBtn = section.querySelector('.scroll-btn.left');
            const rightBtn = section.querySelector('.scroll-btn.right');

            // Initially hide left button
            leftBtn.style.opacity = '0';

            grid.addEventListener('scroll', function() {
                // Show/hide left button
                leftBtn.style.opacity = grid.scrollLeft > 0 ? '1' : '0';
                
                // Show/hide right button
                rightBtn.style.opacity = 
                    (grid.scrollWidth - grid.clientWidth - grid.scrollLeft) > 0 ? '1' : '0';
            });
        });
    });

    // Function to scroll to top
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Show/hide back to top button based on scroll position
    window.addEventListener('scroll', function() {
        const backToTopBtn = document.getElementById('backToTopBtn');
        if (window.scrollY > 300) { // Show button after scrolling 300px
            backToTopBtn.style.display = 'block';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });
    // Search functionality
    function openSearchModal() {
        document.getElementById('searchModal').style.display = 'block';
        document.getElementById('searchInput').focus();
    }
    
    function closeSearchModal() {
        document.getElementById('searchModal').style.display = 'none';
    }
    
    document.querySelector('.close-search').addEventListener('click', closeSearchModal);
    
    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('searchModal')) {
            closeSearchModal();
        }
    });
    // Search functionality
    function openSearchModal() {
        document.getElementById('searchModal').style.display = 'block';
        document.getElementById('searchInput').focus();
    }
    
    function closeSearchModal() {
        document.getElementById('searchModal').style.display = 'none';
    }
    
    // Add event listeners when the document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Close button event listener
        document.querySelector('.close-search').addEventListener('click', closeSearchModal);
        
        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === document.getElementById('searchModal')) {
                closeSearchModal();
            }
        });
        
        // Search input handler with debouncing
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = e.target.value.trim();
                if (searchTerm.length >= 2) {
                    performSearch(searchTerm);
                }
            }, 300);
        });
    });
    
    function performSearch(searchTerm) {
        console.log('Searching for:', searchTerm); // Debug log
        
        fetch(`search.php?q=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Search results:', data); // Debug log
            if (data.error) {
                console.error('Server error:', data.error);
                displayError(data.error);
            } else {
                displaySearchResults(data.results);
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            displayError('An error occurred while searching');
        });
    }
    
    function displaySearchResults(results) {
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = '';
        
        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="search-error">No results found</div>';
            return;
        }
        
        results.forEach(movie => {
            const resultItem = document.createElement('div');
            resultItem.className = 'search-result-item';
            resultItem.innerHTML = `
            <img src="${movie.poster_path}" alt="${movie.title}" class="result-poster">
            <div class="result-info">
            <h3 class="result-title">${movie.title} (${movie.release_year})</h3>
            <div class="result-rating">⭐ ${movie.imdb_rating}</div>
            </div>
            `;
            resultItem.addEventListener('click', () => {
                window.location.href = `details.php?id=${movie.movie_id}`;
            });
            resultsContainer.appendChild(resultItem);
        });
    }
    function displayError(message) {
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = `<div class="search-error">${message}</div>`;
    }
    </script>

</body>
</html>

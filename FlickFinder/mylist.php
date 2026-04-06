<?php
session_start();
include 'C:\xampp\htdocs\admin\db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get movies from watchlist
$movies_sql = "SELECT m.* FROM movies_flick m 
               JOIN watchlist w ON m.movie_id = w.movie_id 
               WHERE w.user_id = ? AND w.show_id IS NULL";
$stmt = mysqli_prepare($con, $movies_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$movies_result = mysqli_stmt_get_result($stmt);

// Get TV shows from watchlist
$shows_sql = "SELECT t.* FROM tvshows_flick t 
              JOIN watchlist w ON t.show_id = w.show_id 
              WHERE w.user_id = ?";
$stmt = mysqli_prepare($con, $shows_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$shows_result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My List - FlickFinder</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mylist.css">
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

    <main class="mylist-container">
        <h1>My List</h1>

        <?php if (mysqli_num_rows($movies_result) > 0 || mysqli_num_rows($shows_result) > 0): ?>
            <?php if (mysqli_num_rows($movies_result) > 0): ?>
                <section class="movies-section">
                    <h2>Movies</h2>
                    <div class="content-grid">
                        <?php while($movie = mysqli_fetch_assoc($movies_result)): ?>
                            <div class="content-card">
                                <div class="poster" style="background-image: url('<?php echo htmlspecialchars($movie['poster_path']); ?>');">
                                    <div class="overlay">
                                        <a href="details.php?id=<?php echo $movie['movie_id']; ?>" class="watch-btn">More Info</a>
                                        <button class="remove-btn" onclick="removeFromList('movie', <?php echo $movie['movie_id']; ?>)">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="content-info">
                                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                                    <div class="meta">
                                        <span class="year"><?php echo htmlspecialchars($movie['release_year']); ?></span>
                                        <?php if($movie['imdb_rating']): ?>
                                            <span class="rating"><i class="fas fa-star"></i> <?php echo number_format($movie['imdb_rating'], 1); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (mysqli_num_rows($shows_result) > 0): ?>
                <section class="shows-section">
                    <h2>TV Shows</h2>
                    <div class="content-grid">
                        <?php while($show = mysqli_fetch_assoc($shows_result)): ?>
                            <div class="content-card">
                                <div class="poster" style="background-image: url('<?php echo htmlspecialchars($show['poster_path']); ?>');">
                                    <div class="overlay">
                                        <a href="details_shows.php?id=<?php echo $show['show_id']; ?>" class="watch-btn">More Info</a>
                                        <button class="remove-btn" onclick="removeFromList('show', <?php echo $show['show_id']; ?>)">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="content-info">
                                    <h3><?php echo htmlspecialchars($show['title']); ?></h3>
                                    <div class="meta">
                                        <span class="year"><?php echo htmlspecialchars($show['release_year']); ?></span>
                                        <?php if($show['imdb_rating']): ?>
                                            <span class="rating"><i class="fas fa-star"></i> <?php echo number_format($show['imdb_rating'], 1); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-list">
                <i class="fas fa-film"></i>
                <p>Your list is empty. Start adding movies and TV shows!</p>
                <div class="browse-buttons">
                    <a href="Movies.php" class="browse-btn">Browse Movies</a>
                    <a href="tvshows.php" class="browse-btn">Browse TV Shows</a>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'C:\xampp\htdocs\admin\footer.php'; ?>

    <script>
    function removeFromList(type, id) {
        if (confirm('Are you sure you want to remove this from your list?')) {
            fetch('remove_from_watchlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: type + '_id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error removing from list');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error removing from list. Please try again.');
            });
        }
    }

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

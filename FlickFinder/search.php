<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "flickfinder");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
$searchTerm = $conn->real_escape_string($searchTerm);

// Search in movies
$movies_query = "SELECT 
    movie_id as id,
    'movie' as type,
    title,
    release_year,
    poster_path,
    imdb_rating,
    genre 
FROM movies_flick 
WHERE LOWER(title) LIKE LOWER(?) 
OR LOWER(description) LIKE LOWER(?) 
OR LOWER(genre) LIKE LOWER(?) 
OR LOWER(actors) LIKE LOWER(?)";

// Search in TV shows
$shows_query = "SELECT 
    show_id as id,
    'show' as type,
    title,
    release_year,
    poster_path,
    imdb_rating,
    genre,
    seasons,
    episodes 
FROM tvshows_flick 
WHERE LOWER(title) LIKE LOWER(?) 
OR LOWER(description) LIKE LOWER(?) 
OR LOWER(genre) LIKE LOWER(?) 
OR LOWER(actors) LIKE LOWER(?)";

// Prepare and execute movies query
$stmt_movies = $conn->prepare($movies_query);
$searchPattern = "%$searchTerm%";
$stmt_movies->bind_param("ssss", $searchPattern, $searchPattern, $searchPattern, $searchPattern);
$stmt_movies->execute();
$movies_result = $stmt_movies->get_result();

// Prepare and execute shows query
$stmt_shows = $conn->prepare($shows_query);
$stmt_shows->bind_param("ssss", $searchPattern, $searchPattern, $searchPattern, $searchPattern);
$stmt_shows->execute();
$shows_result = $stmt_shows->get_result();

// Combine results
$results = [];

// Add movies to results
while ($row = $movies_result->fetch_assoc()) {
    $results[] = array_merge($row, [
        'url' => 'details.php?id=' . $row['id']
    ]);
}

// Add shows to results
while ($row = $shows_result->fetch_assoc()) {
    $results[] = array_merge($row, [
        'url' => 'details_shows.php?id=' . $row['id'],
        'additional_info' => $row['seasons'] . ' Season' . ($row['seasons'] > 1 ? 's' : '') . 
                           ' • ' . $row['episodes'] . ' Episode' . ($row['episodes'] > 1 ? 's' : '')
    ]);
}

// Sort results by relevance (exact title matches first, then by rating)
usort($results, function($a, $b) use ($searchTerm) {
    // Exact title matches come first
    $a_exact = strtolower($a['title']) === strtolower($searchTerm);
    $b_exact = strtolower($b['title']) === strtolower($searchTerm);
    
    if ($a_exact && !$b_exact) return -1;
    if (!$a_exact && $b_exact) return 1;
    
    // Then sort by IMDb rating
    return $b['imdb_rating'] <=> $a['imdb_rating'];
});

// Limit results to 10
$results = array_slice($results, 0, 10);

echo json_encode([
    'results' => $results,
    'count' => count($results),
    'timestamp' => date('Y-m-d H:i:s')
]);

$stmt_movies->close();
$stmt_shows->close();
$conn->close();
?>

<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'flickfinder';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get recent movies ordered by created_at
    $stmt = $pdo->query("SELECT movie_id, title, poster_path, release_year, imdb_rating, created_at 
                        FROM movies_flick 
                        ORDER BY created_at DESC 
                        LIMIT 5");
    
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add badge types based on criteria
    foreach ($movies as &$movie) {
        $created = new DateTime($movie['created_at']);
        $now = new DateTime();
        $diff = $created->diff($now)->days;
        
        if ($diff <= 7) {
            $movie['badge_type'] = 'NEW';
        } elseif ($movie['imdb_rating'] >= 8.0) {
            $movie['badge_type'] = 'TRENDING';
        } else {
            $movie['badge_type'] = 'ORIGINAL';
        }
    }
    
    echo json_encode($movies);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

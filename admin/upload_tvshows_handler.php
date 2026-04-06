<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get and sanitize form data
    $title = mysqli_real_escape_string($con, $_POST['show_name']);
    $releaseYear = mysqli_real_escape_string($con, $_POST['release_year']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $description = mysqli_real_escape_string($con, $_POST['show_desc']);
    $driveUrl = $_POST['drive_url'];
    $trailerUrl = mysqli_real_escape_string($con, $_POST['trailer_url']);
    $posterPath = mysqli_real_escape_string($con, $_POST['poster_path']);
    $actors = mysqli_real_escape_string($con, $_POST['actors']);
    $creator = mysqli_real_escape_string($con, $_POST['creator']);
    $imdbRating = floatval($_POST['imdb_rating']);
    $seasons = intval($_POST['seasons']);
    $episodes = intval($_POST['episodes']);
    
    // Validate required fields
    if(empty($title) || empty($releaseYear) || empty($genre) || empty($driveUrl)) {
        echo "<script>
                alert('All fields are required!');
                window.location.href = 'upload_tvshows.php';
              </script>";
        exit();
    }

    // Extract and validate Google Drive URL
    $fileId = extractGoogleDriveFileId($driveUrl);
    if($fileId) {
        // Create proper embed URL
        $embedUrl = "https://drive.google.com/file/d/" . $fileId . "/preview";
        
        // SQL query for TV shows
        $sql = "INSERT INTO tvshows_flick (
            title, description, release_year, genre, 
            video_url, trailer_url, poster_path, actors, 
            creator, imdb_rating, seasons, episodes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssissssssiii", 
                $title, $description, $releaseYear, $genre,
                $embedUrl, $trailerUrl, $posterPath, $actors,
                $creator, $imdbRating, $seasons, $episodes
            );
            
            if(mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('TV Show added successfully!');
                        window.location.href = 'upload_tvshows.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Database error: " . mysqli_error($con) . "');
                        window.location.href = 'upload_tvshows.php';
                      </script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    alert('Failed to prepare database statement: " . mysqli_error($con) . "');
                    window.location.href = 'upload_tvshows.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid Google Drive URL. Please check the URL and sharing permissions.');
                window.location.href = 'upload_tvshows.php';
              </script>";
    }
}

function extractGoogleDriveFileId($url) {
    $patterns = array(
        '/\/file\/d\/([a-zA-Z0-9_-]+)/',
        '/id=([a-zA-Z0-9_-]+)/',
        '/\/d\/([a-zA-Z0-9_-]+)/'
    );

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
    }
    return false;
}

// Close database connection
if(isset($con)) {
    mysqli_close($con);
}
?>

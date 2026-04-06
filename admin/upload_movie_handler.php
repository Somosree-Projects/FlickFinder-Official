<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get and sanitize form data
    $title = mysqli_real_escape_string($con, $_POST['mv_name']);
    $releaseYear = mysqli_real_escape_string($con, $_POST['release_year']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $trailerUrl = mysqli_real_escape_string($con, $_POST['trailer_url']);
    $description = mysqli_real_escape_string($con, $_POST['mv_desc']);
    $driveUrl = $_POST['drive_url'];
    $posterPath = mysqli_real_escape_string($con, $_POST['poster_path']);
    $actors = mysqli_real_escape_string($con, $_POST['actors']);
    $director = mysqli_real_escape_string($con, $_POST['director']);
    // Check if writers field exists before accessing it
    $writers = isset($_POST['writers']) ? mysqli_real_escape_string($con, $_POST['writers']) : '';
    $imdbRating = floatval($_POST['imdb_rating']);
    
    // Validate required fields
    if(empty($title) || empty($releaseYear) || empty($genre) || empty($driveUrl)) {
        echo "<script>
                alert('All fields are required!');
                window.location.href = 'upload.php';
              </script>";
        exit();
    }

    // Extract and validate Google Drive URL
    $fileId = extractGoogleDriveFileId($driveUrl);
    if($fileId) {
        // Create proper embed URL
        $embedUrl = "https://drive.google.com/file/d/" . $fileId . "/preview";
        
        // Modified SQL query to use video_url instead of image_url
        $sql = "INSERT INTO movies_flick (
            title, description, release_year, genre, 
            video_url, trailer_url, poster_path, actors, 
            director, Writers, imdb_rating
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssisssssssd", 
                $title, $description, $releaseYear, $genre,
                $embedUrl, $trailerUrl, $posterPath, $actors,
                $director, $writers, $imdbRating
            );
            
            if(mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Movie added successfully!');
                        window.location.href = 'upload.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Database error: " . mysqli_error($con) . "');
                        window.location.href = 'upload.php';
                      </script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    alert('Failed to prepare database statement: " . mysqli_error($con) . "');
                    window.location.href = 'upload.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid Google Drive URL. Please check the URL and sharing permissions.');
                window.location.href = 'upload.php';
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

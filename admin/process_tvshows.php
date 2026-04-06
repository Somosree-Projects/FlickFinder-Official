<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    exit('Unauthorized Access');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tvshow'])) {
    // Get and sanitize form data
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $releaseYear = mysqli_real_escape_string($con, $_POST['release_year']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $seasons = intval($_POST['seasons']);
    $episodes = intval($_POST['episodes']);
    $imdbRating = floatval($_POST['imdb_rating']);
    $creator = mysqli_real_escape_string($con, $_POST['creator']);
    $actors = mysqli_real_escape_string($con, $_POST['actors']);
    $videoUrl = $_POST['video_url'];
    $trailerUrl = mysqli_real_escape_string($con, $_POST['trailer_url']);
    $posterPath = mysqli_real_escape_string($con, $_POST['poster_path']);

    // Validate required fields
    if(empty($title) || empty($description) || empty($releaseYear) || empty($videoUrl)) {
        $_SESSION['error'] = "All required fields must be filled out.";
        header("Location: add_tvshows.php");
        exit();
    }

    // Process Google Drive URL
    $fileId = extractGoogleDriveFileId($videoUrl);
    if($fileId) {
        // Create embed URL
        $embedUrl = "https://drive.google.com/file/d/" . $fileId . "/preview";

        // Insert into database
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
                $_SESSION['success'] = "TV Show added successfully!";
                header("Location: tvshows.php");
                exit();
            } else {
                $_SESSION['error'] = "Error adding TV Show: " . mysqli_error($con);
                header("Location: add_tvshows.php");
                exit();
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Database error: " . mysqli_error($con);
            header("Location: add_tvshows.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid Google Drive URL. Please check the URL and sharing permissions.";
        header("Location: add_tvshows.php");
        exit();
    }
}

// Handle Update TV Show
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tvshow'])) {
    $showId = intval($_POST['show_id']);
    // Similar sanitization as above
    // ... (sanitize all fields)

    $sql = "UPDATE tvshows_flick SET 
            title = ?, description = ?, release_year = ?, 
            genre = ?, video_url = ?, trailer_url = ?, 
            poster_path = ?, actors = ?, creator = ?, 
            imdb_rating = ?, seasons = ?, episodes = ? 
            WHERE show_id = ?";

    if($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssissssssiiii", 
            $title, $description, $releaseYear, $genre,
            $embedUrl, $trailerUrl, $posterPath, $actors,
            $creator, $imdbRating, $seasons, $episodes, $showId
        );

        if(mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "TV Show updated successfully!";
            header("Location: tvshows.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating TV Show";
            header("Location: edit_tvshow.php?id=$showId");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// Handle Delete TV Show
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $showId = intval($_GET['id']);

    $sql = "DELETE FROM tvshows_flick WHERE show_id = ?";
    if($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $showId);
        
        if(mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "TV Show deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting TV Show";
        }
        mysqli_stmt_close($stmt);
    }
    header("Location: tvshows.php");
    exit();
}

// Helper function to extract Google Drive file ID
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

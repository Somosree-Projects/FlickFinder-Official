<?php
session_start();
include 'C:\xampp\htdocs\admin\db.php';

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];
$response = ['success' => false, 'message' => 'Invalid request'];

// Handle TV Shows
if (isset($_POST['show_id'])) {
    $show_id = mysqli_real_escape_string($con, $_POST['show_id']);
    
    try {
        // Check if show exists
        $check_show = "SELECT show_id FROM tvshows_flick WHERE show_id = ?";
        $stmt = mysqli_prepare($con, $check_show);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($con));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $show_id);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Check if already in watchlist
            $check_watchlist = "SELECT watchlist_id FROM watchlist WHERE user_id = ? AND show_id = ?";
            $stmt = mysqli_prepare($con, $check_watchlist);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($con));
            }
            
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $show_id);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
            }
            
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 0) {
                // Add to watchlist
                $insert_sql = "INSERT INTO watchlist (user_id, movie_id, show_id) VALUES (?, NULL, ?)";
                $stmt = mysqli_prepare($con, $insert_sql);
                
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . mysqli_error($con));
                }
                
                mysqli_stmt_bind_param($stmt, "ii", $user_id, $show_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['success' => true, 'message' => 'Show added to watchlist successfully'];
                } else {
                    throw new Exception("Insert failed: " . mysqli_stmt_error($stmt));
                }
            } else {
                $response = ['success' => false, 'message' => 'Show is already in your watchlist'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Show not found'];
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}
// Handle Movies
elseif (isset($_POST['movie_id'])) {
    $movie_id = mysqli_real_escape_string($con, $_POST['movie_id']);
    
    try {
        // Check if movie exists
        $check_movie = "SELECT movie_id FROM movies_flick WHERE movie_id = ?";
        $stmt = mysqli_prepare($con, $check_movie);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($con));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            // Check if already in watchlist
            $check_watchlist = "SELECT watchlist_id FROM watchlist WHERE user_id = ? AND movie_id = ?";
            $stmt = mysqli_prepare($con, $check_watchlist);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($con));
            }
            
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $movie_id);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
            }
            
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 0) {
                // Add to watchlist
                $insert_sql = "INSERT INTO watchlist (user_id, movie_id, show_id) VALUES (?, ?, NULL)";
                $stmt = mysqli_prepare($con, $insert_sql);
                
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . mysqli_error($con));
                }
                
                mysqli_stmt_bind_param($stmt, "ii", $user_id, $movie_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['success' => true, 'message' => 'Movie added to watchlist successfully'];
                } else {
                    throw new Exception("Insert failed: " . mysqli_stmt_error($stmt));
                }
            } else {
                $response = ['success' => false, 'message' => 'Movie is already in your watchlist'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Movie not found'];
        }
    } catch (Exception $e) {
        $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

echo json_encode($response);
?>

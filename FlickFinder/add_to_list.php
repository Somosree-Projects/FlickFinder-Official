<?php
session_start();
include 'C:\xampp\htdocs\admin\db.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
    try {
        $user_id = $_SESSION['user_id'];
        $movie_id = mysqli_real_escape_string($con, $_POST['movie_id']);

        // Check if movie exists
        $check_movie = mysqli_query($con, "SELECT movie_id FROM movies_flick WHERE movie_id = '$movie_id'");
        if (mysqli_num_rows($check_movie) === 0) {
            echo json_encode(['success' => false, 'message' => 'Movie not found']);
            exit();
        }

        // Check if already in watchlist
        $check_sql = "SELECT * FROM watchlist WHERE user_id = ? AND movie_id = ?";
        $check_stmt = mysqli_prepare($con, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $movie_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            echo json_encode(['success' => false, 'message' => 'Movie already in your list']);
            exit();
        }

        // Add to watchlist
        $sql = "INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $movie_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Movie added to your list']);
        } else {
            throw new Exception(mysqli_error($con));
        }

    } catch (Exception $e) {
        error_log("Add to List Error: " . $e->getMessage());
        echo json_encode([
            'success' => false, 
            'message' => 'Error adding movie to list. Please try again.'
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

// Clean up
if (isset($stmt)) mysqli_stmt_close($stmt);
if (isset($check_stmt)) mysqli_stmt_close($check_stmt);
mysqli_close($con);
?>

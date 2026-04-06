<?php
session_start();
include 'C:\xampp\htdocs\admin\db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];
$response = ['success' => false, 'message' => 'Invalid request'];

if (isset($_POST['movie_id'])) {
    $movie_id = mysqli_real_escape_string($con, $_POST['movie_id']);
    $sql = "DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $movie_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $response = ['success' => true, 'message' => 'Movie removed from watchlist'];
    } else {
        $response = ['success' => false, 'message' => 'Error removing movie from watchlist'];
    }
} elseif (isset($_POST['show_id'])) {
    $show_id = mysqli_real_escape_string($con, $_POST['show_id']);
    $sql = "DELETE FROM watchlist WHERE user_id = ? AND show_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $show_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $response = ['success' => true, 'message' => 'Show removed from watchlist'];
    } else {
        $response = ['success' => false, 'message' => 'Error removing show from watchlist'];
    }
}

echo json_encode($response);
?>

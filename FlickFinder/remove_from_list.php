<?php
session_start();
include 'C:\xampp\htdocs\admin\db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
    try {
        $user_id = $_SESSION['user_id'];
        $movie_id = mysqli_real_escape_string($con, $_POST['movie_id']);

        $sql = "DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $movie_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Movie removed from your list']);
        } else {
            throw new Exception(mysqli_error($con));
        }

    } catch (Exception $e) {
        error_log("Remove from List Error: " . $e->getMessage());
        echo json_encode([
            'success' => false, 
            'message' => 'Error removing movie from list. Please try again.'
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

if (isset($stmt)) mysqli_stmt_close($stmt);
mysqli_close($con);
?>

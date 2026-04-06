// admin/process-movie.php
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    exit('Unauthorized');
}

include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    
    // Handle file uploads
    $poster_path = handleFileUpload($_FILES['poster'], 'posters');
    $movie_path = handleFileUpload($_FILES['movie_file'], 'movies');
    
    $query = "INSERT INTO movies (title, description, year, genre, poster_path, movie_path) 
              VALUES ('$title', '$description', '$year', '$genre', '$poster_path', '$movie_path')";
    
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php?success=1');
    } else {
        header('Location: add-movie.php?error=1');
    }
}

function handleFileUpload($file, $directory) {
    $target_dir = "../uploads/" . $directory . "/";
    $target_file = $target_dir . time() . '_' . basename($file["name"]);
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    }
    return false;
}
?>

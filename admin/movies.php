<?php
require_once 'middleware/admin_auth.php';
require_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies - Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include './includes/admin_nav.php'; ?>

        <main class="admin-content">
            <h1>Manage Movies</h1>
            
            <div class="action-button">
                <button onclick="showAddMovieForm()">Add New Movie</button>
            </div>

            <!-- Add Movie Form -->
            <div class="movie-form" id="addMovieForm" style="display: none;">
                <h2>Add New Movie</h2>
                <form action="process_movie.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Movie Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="release_year">Release Year:</label>
                        <input type="number" id="release_year" name="release_year">
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre:</label>
                        <input type="text" id="genre" name="genre">
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" id="rating" name="rating" step="0.1" min="0" max="5">
                    </div>

                    <div class="form-group">
                        <label for="image_url">Movie Image:</label>
                        <input type="file" id="image_url" name="image_url" accept="image/*">
                    </div>

                    <button type="submit" name="add_movie">Add Movie</button>
                </form>
            </div>

            <!-- Movies List -->
            <div class="movies-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Rating</th>
                            <th>Release Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Updated query to match your table structure
                        $query = "SELECT * FROM movies ORDER BY movie_id DESC";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            while($movie = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$movie['movie_id']}</td>";
                                echo "<td><img src='{$movie['image_url']}' width='50' alt='Movie Image'></td>";
                                echo "<td>{$movie['title']}</td>";
                                echo "<td>{$movie['genre']}</td>";
                                echo "<td>{$movie['rating']}</td>";
                                echo "<td>{$movie['release_year']}</td>";
                                echo "<td>
                                        <button onclick='editMovie({$movie['movie_id']})'>Edit</button>
                                        <button onclick='deleteMovie({$movie['movie_id']})'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function showAddMovieForm() {
            document.getElementById('addMovieForm').style.display = 'block';
        }

        function editMovie(id) {
            window.location.href = `edit_movie.php?id=${id}`;
        }

        function deleteMovie(id) {
            if(confirm('Are you sure you want to delete this movie?')) {
                window.location.href = `process_movie.php?action=delete&id=${id}`;
            }
        }
    </script>
</body>
</html>

<?php
require_once 'middleware/admin_auth.php';
require_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage TV Shows - Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include './includes/admin_nav.php'; ?>

        <main class="admin-content">
            <h1>Manage TV Shows</h1>
            
            <div class="action-button">
                <button onclick="showAddShowForm()">Add New TV Show</button>
            </div>

            <!-- Add TV Show Form -->
            <div class="show-form" id="addShowForm" style="display: none;">
                <h2>Add New TV Show</h2>
                <form action="process_tvshow.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Show Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="release_year">Release Year:</label>
                            <input type="number" id="release_year" name="release_year">
                        </div>

                        <div class="form-group">
                            <label for="genre">Genre:</label>
                            <input type="text" id="genre" name="genre">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="seasons">Number of Seasons:</label>
                            <input type="number" id="seasons" name="seasons" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="episodes">Total Episodes:</label>
                            <input type="number" id="episodes" name="episodes" min="1" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="imdb_rating">IMDB Rating:</label>
                            <input type="number" id="imdb_rating" name="imdb_rating" step="0.1" min="0" max="10">
                        </div>

                        <div class="form-group">
                            <label for="creator">Creator:</label>
                            <input type="text" id="creator" name="creator">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="video_url">Video URL:</label>
                        <input type="url" id="video_url" name="video_url" required>
                        <small>Enter Google Drive share link</small>
                    </div>

                    <div class="form-group">
                        <label for="trailer_url">Trailer URL:</label>
                        <input type="url" id="trailer_url" name="trailer_url">
                        <small>Enter YouTube trailer link</small>
                    </div>

                    <div class="form-group">
                        <label for="poster_path">Show Poster:</label>
                        <input type="url" id="poster_path" name="poster_path" required>
                        <small>Enter poster image URL</small>
                    </div>

                    <div class="form-group">
                        <label for="actors">Cast:</label>
                        <input type="text" id="actors" name="actors">
                        <small>Enter cast names separated by commas</small>
                    </div>

                    <button type="submit" name="add_show">Add TV Show</button>
                </form>
            </div>

            <!-- TV Shows List -->
            <div class="shows-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Rating</th>
                            <th>Seasons</th>
                            <th>Episodes</th>
                            <th>Release Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM tvshows_flick ORDER BY show_id DESC";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            while($show = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$show['show_id']}</td>";
                                echo "<td><img src='{$show['poster_path']}' width='50' alt='Show Poster'></td>";
                                echo "<td>{$show['title']}</td>";
                                echo "<td>{$show['genre']}</td>";
                                echo "<td>{$show['imdb_rating']}</td>";
                                echo "<td>{$show['seasons']}</td>";
                                echo "<td>{$show['episodes']}</td>";
                                echo "<td>{$show['release_year']}</td>";
                                echo "<td>
                                        <button onclick='editShow({$show['show_id']})'>Edit</button>
                                        <button onclick='deleteShow({$show['show_id']})'>Delete</button>
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
        function showAddShowForm() {
            document.getElementById('addShowForm').style.display = 'block';
        }

        function editShow(id) {
            window.location.href = `edit_tvshow.php?id=${id}`;
        }

        function deleteShow(id) {
            if(confirm('Are you sure you want to delete this TV show?')) {
                window.location.href = `process_tvshow.php?action=delete&id=${id}`;
            }
        }
    </script>
</body>
</html>

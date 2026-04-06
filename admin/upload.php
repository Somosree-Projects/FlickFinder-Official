<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Movies - FlickFinder Admin</title>
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-sidebar">
            <h2>FlickFinder Admin</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="upload.php">Manage Movies</a></li>
                <li><a href="#">Manage Users</a></li>
                <li><a href="http://localhost/FlickFinder/">Back to Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Upload Movies</h1>
            </div>
            
            <div class="stats-container">
                <div class="upload-form-container">
                    <form action="upload_movie_handler.php" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="mv_name">Movie Title</label>
                                <input type="text" id="mv_name" name="mv_name" class="form-control" placeholder="Enter Movie Title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="release_year">Release Year</label>
                                <input type="number" id="release_year" name="release_year" class="form-control" placeholder="Release Year" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" id="genre" name="genre" class="form-control" placeholder="Genre (e.g., Action, Drama, Comedy)" required>
                            </div>
							
							<!-- Add this to your form in upload.php -->
							<div class="form-group">
							<label for="trailer_url">Trailer URL</label>
							<input type="url" id="trailer_url" name="trailer_url" class="form-control" placeholder="Enter YouTube/Video Trailer URL">
							<small class="url-info">YouTube or other video embed URL</small>
							</div>

                            <div class="form-group">
                                <label for="imdb_rating">IMDB Rating</label>
                                <input type="number" id="imdb_rating" name="imdb_rating" class="form-control" placeholder="IMDB Rating (0.0 to 10.0)" step="0.1" min="0" max="10" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="drive_url">Movie URL</label>
                            <input type="url" id="drive_url" name="drive_url" class="form-control" placeholder="Enter Google Drive Share Link" required>
                            <small class="url-info">Make sure the link is set to 'Anyone with the link can view'</small>
                        </div>

                        <div class="form-group">
                            <label for="poster_path">Movie Poster URL</label>
                            <input type="url" id="poster_path" name="poster_path" class="form-control" placeholder="Enter Movie Poster URL" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="director">Director</label>
                                <input type="text" id="director" name="director" class="form-control" placeholder="Enter Director Name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="Writers">Writers</label>
                                <input type="text" id="Writers" name="Writers" class="form-control" placeholder="Enter Writers Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="actors">Actors</label>
                            <input type="text" id="actors" name="actors" class="form-control" placeholder="Enter Actors (comma separated)" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="mv_desc">Movie Description</label>
                            <textarea id="mv_desc" name="mv_desc" class="form-control" placeholder="Enter Movie Description" rows="4" required></textarea>
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-upload">Add Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

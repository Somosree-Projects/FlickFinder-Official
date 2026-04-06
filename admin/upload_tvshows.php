<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload TV Shows - FlickFinder Admin</title>
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-sidebar">
            <h2>FlickFinder Admin</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="upload.php">Manage Movies</a></li>
                <li><a href="upload_tvshows.php">Manage TV Shows</a></li>
                <li><a href="http://localhost/FlickFinder/">Back to Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Upload TV Shows</h1>
            </div>
            
            <div class="stats-container">
                <div class="upload-form-container">
                    <form action="upload_tvshows_handler.php" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="show_name">TV Show Title</label>
                                <input type="text" id="show_name" name="show_name" class="form-control" placeholder="Enter TV Show Title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="release_year">Release Year</label>
                                <input type="number" id="release_year" name="release_year" class="form-control" placeholder="Release Year" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" id="genre" name="genre" class="form-control" placeholder="Genre (e.g., Drama, Comedy, Action)" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="imdb_rating">IMDB Rating</label>
                                <input type="number" id="imdb_rating" name="imdb_rating" class="form-control" placeholder="IMDB Rating (0.0 to 10.0)" step="0.1" min="0" max="10" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="seasons">Number of Seasons</label>
                                <input type="number" id="seasons" name="seasons" class="form-control" placeholder="Number of Seasons" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="episodes">Total Episodes</label>
                                <input type="number" id="episodes" name="episodes" class="form-control" placeholder="Total Number of Episodes" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="drive_url">Show URL</label>
                            <input type="url" id="drive_url" name="drive_url" class="form-control" placeholder="Enter Google Drive Share Link" required>
                            <small class="url-info">Make sure the link is set to 'Anyone with the link can view'</small>
                        </div>

                        <div class="form-group">
                            <label for="trailer_url">Trailer URL</label>
                            <input type="url" id="trailer_url" name="trailer_url" class="form-control" placeholder="Enter YouTube/Video Trailer URL">
                            <small class="url-info">YouTube or other video embed URL</small>
                        </div>

                        <div class="form-group">
                            <label for="poster_path">Show Poster URL</label>
                            <input type="url" id="poster_path" name="poster_path" class="form-control" placeholder="Enter Show Poster URL" required>
                        </div>

                        <div class="form-group">
                            <label for="creator">Creator/Director</label>
                            <input type="text" id="creator" name="creator" class="form-control" placeholder="Enter Creator/Director Name" required>
                        </div>

                        <div class="form-group">
                            <label for="actors">Cast</label>
                            <input type="text" id="actors" name="actors" class="form-control" placeholder="Enter Cast Members (comma separated)" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="show_desc">Show Description</label>
                            <textarea id="show_desc" name="show_desc" class="form-control" placeholder="Enter Show Description" rows="4" required></textarea>
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-upload">Add TV Show</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

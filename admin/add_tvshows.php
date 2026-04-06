<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add TV Show - Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include './includes/admin_nav.php'; ?>

        <main class="admin-content">
            <h1>Add New TV Show</h1>

            <form action="process_tvshow.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>TV Show Title</label>
                    <input type="text" name="title" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Release Year</label>
                        <input type="number" name="release_year" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Genre</label>
                        <select name="genre" required>
                            <option value="">Select Genre</option>
                            <option value="Action">Action</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Drama">Drama</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Horror">Horror</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Romance">Romance</option>
                            <option value="Sci-Fi">Sci-Fi</option>
                            <option value="Thriller">Thriller</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Number of Seasons</label>
                        <input type="number" name="seasons" min="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Total Episodes</label>
                        <input type="number" name="episodes" min="1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>IMDB Rating</label>
                        <input type="number" name="imdb_rating" step="0.1" min="0" max="10" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Creator/Director</label>
                        <input type="text" name="creator" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Cast Members</label>
                    <input type="text" name="actors" placeholder="Enter cast names separated by commas" required>
                </div>

                <div class="form-group">
                    <label>Video URL (Google Drive)</label>
                    <input type="url" name="video_url" placeholder="Enter Google Drive share link" required>
                    <small class="form-text">Make sure the link is set to 'Anyone with the link can view'</small>
                </div>

                <div class="form-group">
                    <label>Trailer URL</label>
                    <input type="url" name="trailer_url" placeholder="Enter YouTube trailer link">
                    <small class="form-text">Optional: YouTube or other video platform link</small>
                </div>
                
                <div class="form-group">
                    <label>Show Poster URL</label>
                    <input type="url" name="poster_path" placeholder="Enter poster image URL" required>
                    <small class="form-text">Enter direct link to poster image</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="add_tvshow" class="btn-primary">Add TV Show</button>
                    <button type="reset" class="btn-secondary">Reset Form</button>
                </div>
            </form>
        </main>
    </div>

    <script>
        // Add any necessary JavaScript validation here
        document.querySelector('form').addEventListener('submit', function(e) {
            const required = this.querySelectorAll('[required]');
            required.forEach(field => {
                if (!field.value) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                    field.focus();
                }
            });
        });
    </script>
</body>
</html>

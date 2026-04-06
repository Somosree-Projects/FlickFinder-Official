// admin/add-movie.php
<form action="process-movie.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>Movie Title</label>
        <input type="text" name="title" required>
    </div>
    
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" required></textarea>
    </div>
    
    <div class="form-group">
        <label>Release Year</label>
        <input type="number" name="year" required>
    </div>
    
    <div class="form-group">
        <label>Genre</label>
        <select name="genre" required>
            <option value="action">Action</option>
            <option value="comedy">Comedy</option>
            <option value="drama">Drama</option>
            <!-- Add more genres -->
        </select>
    </div>
    
    <div class="form-group">
        <label>Movie Poster</label>
        <input type="file" name="poster" accept="image/*" required>
    </div>
    
    <div class="form-group">
        <label>Movie File</label>
        <input type="file" name="movie_file" accept="video/*" required>
    </div>
    
    <button type="submit">Upload Movie</button>
</form>

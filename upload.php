<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Picture Upload</title>
</head>
<body>
    <div>
        <h2>Upload Profile Picture</h2>

      
        <div id="preview">
            <img src="R.png" alt="Profile Image Preview" width="250" height="250">
        </div>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="profilePic">Select a profile picture (max 4MB):</label><br>
            <input type="file" name="profilePic" id="profilePic" required><br><br>
            
            <input type="submit" value="Upload">
        </form>
    </div>
</body>
</html>

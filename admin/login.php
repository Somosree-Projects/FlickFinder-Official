<?php
session_start();
include 'header.php';
include 'footer.php';
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Flickfinder</title>
    <link rel="stylesheet" href="css/login.css">  <!-- Add this line -->
</head>
<body>
<div class="container">
    <div class="head" style="text-align:center;">
        <h1>Login to Flickfinder</h1>
    </div>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="uname" class="form-control" id="exampleInputEmail1" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="pwd" class="form-control" id="exampleInputPassword1" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>

<?php
if(isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($con, $_POST['uname']);
    $pwd = mysqli_real_escape_string($con, $_POST['pwd']);
    
    $query = "SELECT * FROM admin WHERE uname = ? AND pwd = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $user, $pwd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1) {
        $_SESSION['loginsuccessful'] = 1;
        echo "<script>
                alert('Logged in successfully');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>alert('Check your ID or Password');</script>";
    }
    mysqli_stmt_close($stmt);
}
?>



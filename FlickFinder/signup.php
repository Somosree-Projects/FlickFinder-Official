<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php'; // Include your database connection file

    $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match. Please try again.');
                window.location.href = 'signup.html';
              </script>";
        exit();
    }

    // Check if the email already exists
    $checkEmailSql = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $checkEmailSql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>
                alert('An account with this email already exists. Please login.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }

    mysqli_stmt_close($stmt);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Sign up successful! You can now login.');
                window.location.href = 'login.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: Unable to register. Please try again later.');
                window.location.href = 'signup.html';
              </script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>

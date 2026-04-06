<?php
session_start();
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    // Check if the email exists in the database
    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $email;

            echo "<script>
                    alert('Login successful!');
                    window.location.href = 'index.html'; // Redirect to homepage
                  </script>";
        } else {
            echo "<script>
                    alert('Incorrect password. Please try again.');
                    window.location.href = 'login.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No account found with this email. Please sign up.');
                window.location.href = 'signup.html';
              </script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>

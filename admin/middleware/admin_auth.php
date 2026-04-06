<?php
// middleware/admin_auth.php

function checkAdminAuth(): void {
    session_start();
    
    // Check if user is logged in and has admin privileges
    if (!isset($_SESSION['user_id']) || 
        !isset($_SESSION['is_admin']) || 
        !isset($_SESSION['is_authenticated']) || 
        $_SESSION['is_authenticated'] !== true) {
        
        // Store the requested URL for redirect after login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        
        // Redirect to login page
        header("Location: /login.php");
        exit();
    }
    
    // Refresh session to prevent session fixation
    session_regenerate_id(true);
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
    
    // Session timeout check (30 minutes)
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity'] > 1800)) {
        
        // Destroy session if inactive for too long
        session_unset();
        session_destroy();
        header("Location: /login.php?timeout=1");
        exit();
    }
}

// Call the authentication check
checkAdminAuth();
?>

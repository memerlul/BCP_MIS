<?php
    $password = 'gabgesleich'; // The plain text password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash it
    echo $hashed_password; // Copy the hashed password to use in the query    
?>
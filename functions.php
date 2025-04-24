<?php
// Inside functions.php or at the top of manage-accounts.php

function generateUsername() {
    return 'user' . rand(1000, 9999); // Generates a username like 'user1234'
}
?>
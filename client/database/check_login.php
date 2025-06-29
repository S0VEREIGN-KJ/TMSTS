<?php

header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');


echo "Session username: " . $_SESSION['username'] . "<br>";
echo "Session authenticated: " . $_SESSION['authenticated'] . "<br>";


// Set a session variable indicating that the user is authenticated
$_SESSION['authenticated'] = true;

// You can use the session variable directly
$login_user = $_SESSION['username'];
?>
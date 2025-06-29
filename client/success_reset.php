<?php
header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalid_numberate');
header('Pragma: no-cache');
header('Expires: 0');

   
if (isset($_GET['url'])) {
  $url = $_GET['url'];
  header('Location: ' . $url);
  exit;
}
   ?>
<style>
     h2{
        font-size: 2.5em; /* Increase the font size */
        color: white; /* Change the text color to white */
        text-align: center;
    }

    p {
        font-size: 1.5em; /* Increase the font size for the paragraph */
        color: white; /* Change the text color to white */
        text-align: center;
    }

    /* Add more styles if necessary for other text elements */
</style>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wid_numberth=device-wid_numberth, initial-scale=1.0">
    <title>Activation Page</title>
    <link rel="stylesheet" href="log_in.css?v=1.2">
</head>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
<header>
    <img src="images/cicto_logo.png" alt="App Logo" style="wid_numberth: 30%; height: auto;">
    <h1>CICTO TABUK CITY</h1>
    <h1>City Information Communication Technology Office</h1>
</header>

    <main>
        <div class="main-image"></div>
        <div class="main-overlay"></div>
        <div class="login-container">
            
            <h1>Account Password Reset</h1>

<p>Account resetted successfully. You can now login in the app<p>

    </main>

</body>

</html>

<script>
       function loadContent(url) {      ///no cache function
    $.ajax({
        url: url,
        cache: false,
        headers: {
            'Cache-Control': 'no-cache',
            'Pragma': 'no-cache'
        },
        success: function(data) {
            console.log('Loaded content:', data);
            $('#content-loader').html(data);
            window.location.hash = url;
          
        }
    });
}
function preventBack() {
    window.history.pushState(null, '', window.location.href);
}

// Call it once to set the current state
preventBack();

// Use popstate to detect back navigation and prevent it
window.addEventListener('popstate', function () {
    preventBack();
});

        </script>
<?php
include('user_login_function.php');  // ...LOGIN FUNCTION
include('database/db_conn.php');

header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');


if (isset($_GET['url'])) {
  $url = $_GET['url'];
  header('Location: ' . $url);
  exit;
}

// Set a session variable indicating that the user is logged in
$_SESSION['logged_in'] = true;
?>

<style>
  
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Login Page</title>
    <link rel="stylesheet" href="log_in.css">
   
</head>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
<header>
    <img src="images/cicto_logo.png" alt="App Logo" style="width: 30%; height: auto;">
    <h1>CICTO TABUK CITY</h1>
    <h1>City Information Communication Technology Office</h1>
</header>

    <main>
        <div class="main-image"></div>
        <div class="main-overlay"></div>
        <div class="login-container">
        
        
<!-- SweetAlert for error handling -->
<?php if (!empty($error)) : ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        icon: 'warning',
        title: 'Oops!',
        text: <?= json_encode($error); ?>, // Display the error message
        showConfirmButton: false,
        timer: 3000
      });
    });
  </script>
<?php endif; ?>



<!-- From Uiverse.io by AnthonyPreite --> 

<div id="form-ui">
    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" id="form">
      <div id="form-body">
        <div id="welcome-lines">
          <div id="welcome-line-1">Log In</div>
          <div id="welcome-line-2">Welcome Employee</div>
        </div>
        <div id="input-area">
          <div class="form-inp">
            <input type="text" id="id_number" name="id_number" placeholder="Employee ID" required autocomplete="off">
          </div>
          <div class="form-inp">
            <input placeholder="Password" type="password" id="password" name="password" >
          </div>
        </div>
        <div id="submit-button-cvr">
          <button id="submit-button" type="submit">Login</button>
        </div>

        <div id="bar"></div>
      </div>
    </form>
    </div>
  

<br>

<!-- The Overlay -->
<div class="forgot-password-overlay" id="forgotPasswordOverlay">
    <div class="overlay-content">
        <button class="close-btn" onclick="hideForgotPasswordOverlay()">×</button> <!-- Close Button -->
        <h1>Forgot Password</h1>
        <form method="post" action="send-password-reset.php" id="forgotPasswordForm">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Your Email Address" autocomplete="off" required>

            <button type="submit">Send</button>
        </form>
        <div id="message"></div>
    </div>
</div>

<!-- Trigger to Show the Overlay -->
<a href="javascript:void(0);" onclick="showForgotPasswordOverlay()" class="forgot-password-link">Forgot Password?</a>

       
    </main>


    <footer>
  <div>
        <a href="Sign_up.html" class="create-account-btn">Create Account</a>
   </div>
    </footer>
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

// Show the overlay
function showForgotPasswordOverlay() {
    document.getElementById("forgotPasswordOverlay").style.display = "flex";
}

// Hide the overlay
function hideForgotPasswordOverlay() {
    document.getElementById("forgotPasswordOverlay").style.display = "none";
}

// Handle form submission using AJAX to display the message without reloading the page
document.getElementById("forgotPasswordForm").onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission

    var email = document.getElementById("email").value;
    var messageDiv = document.getElementById("message");
    var submitButton = document.querySelector("button[type='submit']");
    
    // Validate email
    if (!email || !/\S+@\S+\.\S+/.test(email)) {
        messageDiv.innerHTML = "Please enter a valid email address.";
        return;
    }

    submitButton.disabled = true; // Disable the button

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send-password-reset.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        submitButton.disabled = false; // Re-enable the button
        if (xhr.status === 200) {
            messageDiv.innerHTML = "Message sent, please check your inbox.";
            setTimeout(hideForgotPasswordOverlay, 3000); // Hide overlay after 3 seconds
        } else if (xhr.status === 404) { // Email not found
            messageDiv.innerHTML = "No email found in CICTO.";
        } else {
            messageDiv.innerHTML = "There was an error. Please try again.";
        }
    };

    xhr.send("email=" + encodeURIComponent(email));
};
</script>

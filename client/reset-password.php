<?php
// Retrieve the token from the GET request
$token = $_GET["token"];
$token_hash = hash("sha256", $token);

// Debug: Log the token and its hash
error_log("Token: " . $token);
error_log("Hashed Token: " . $token_hash);

// Disable caching
header_remove('ETag');
header_remove('Last-Modified');
ini_set('opcache.enable', 0);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Redirect if a URL is provided
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    header('Location: ' . $url);
    exit;
}

// Database connection
$mysqli = require __DIR__ . "/database.php";

// Check the `account` table for the token
$sql_account = "SELECT * FROM account WHERE reset_token_hash = ?";
$stmt_account = $mysqli->prepare($sql_account);
$stmt_account->bind_param("s", $token_hash);
$stmt_account->execute();
$result_account = $stmt_account->get_result();
$user_account = $result_account->fetch_assoc();

// If not found in `account`, check the `technician` table
if ($user_account === null) {
    $sql_technician = "SELECT * FROM technician WHERE reset_token_hash = ?";
    $stmt_technician = $mysqli->prepare($sql_technician);
    $stmt_technician->bind_param("s", $token_hash);
    $stmt_technician->execute();
    $result_technician = $stmt_technician->get_result();
    $user_account = $result_technician->fetch_assoc();
}

// If token is still not found, display an error
if ($user_account === null) {
        // Redirect to no-token.php if token is not found
        header('Location: no-token.php');
        exit;
}

// Check if the token has expired
if (strtotime($user_account["reset_token_expires_at"]) <= time()) {
    die("Token has expired.");
}

// At this point, token is valid, proceed to display the form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Page</title>
    <link rel="stylesheet" href="log_in.css?v=1.0">
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

          
<div id="form-ui">
    <form action="process-reset-password.php" method="POST" id="form">
      <div id="form-body">
        <div id="welcome-lines">
          <div id="welcome-line-1">Reset Form</div>
          <div id="welcome-line-2">Reset Password</div>
        </div>
        <br>
        <br>
   <div class="form-inp">
           <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <input type="password" id="password" name="password" placeholder="New Password" required oninput="checkPasswordsMatch()">
                    <span style="position: relative; top: 22px; float: left; margin-left: -10px;">
                        <input type="checkbox" onclick="seePass()" title="Show Password" style="transform: scale(1.5);">
                    </span>
                </div>
<br>
<br>
                <!-- Confirm Password input -->
                <div class="form-inp">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm New Password" required oninput="checkPasswordsMatch()">
                          <span style="position: relative; top: 22px; float: left; margin-left: -10px;">
                        <input type="checkbox" onclick="seeConfirmPass()" title="Show Password" style="transform: scale(1.5);">
                    </span>
                </div>

            </div>

        <div id="submit-button-cvr">
          <button id="submit-button" type="submit">Login</button>
        </div>

        <div id="bar"></div>
      </div>
    </form>
    </div>
  
        </div>
    </main>

</body>
</html>

<script>


function seePass() {
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

function seeConfirmPass() {
    var passwordInput = document.getElementById("password_confirmation");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

   function checkPasswordsMatch() {
        var password = document.getElementById("password");
        var confirmPassword = document.getElementById("password_confirmation");
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords do not match.");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
</script>

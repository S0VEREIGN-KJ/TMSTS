<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

// Database connection
$mysqli = require __DIR__ . "/database.php";

// Check the `account` table for the token
$sql_account = "SELECT * FROM account WHERE reset_token_hash = ?";
$stmt_account = $mysqli->prepare($sql_account);
$stmt_account->bind_param("s", $token_hash);
$stmt_account->execute();
$result_account = $stmt_account->get_result();
$user = $result_account->fetch_assoc();

// If not found in `account`, check the `technician` table
if ($user === null) {
    $sql_technician = "SELECT * FROM technician WHERE reset_token_hash = ?";
    $stmt_technician = $mysqli->prepare($sql_technician);
    $stmt_technician->bind_param("s", $token_hash);
    $stmt_technician->execute();
    $result_technician = $stmt_technician->get_result();
    $user = $result_technician->fetch_assoc();

    $isTechnician = true; // Flag to identify which table to update
} else {
    $isTechnician = false; // Indicates user is from `account` table
}

// If token is still not found, show an error
if ($user === null) {
     // Redirect to no-token.php if token is not found
     header('Location: no-token.php');
     exit;
}
// Check if token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

// Ensure the password and confirmation match
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

// Hash the new password
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Update the password in the appropriate table and clear the reset token
if ($isTechnician) {
    $sql_update = "UPDATE technician
                   SET password = ?,
                       reset_token_hash = NULL,
                       reset_token_expires_at = NULL
                   WHERE id_number = ?";
} else {
    $sql_update = "UPDATE account
                   SET password = ?,
                       reset_token_hash = NULL,
                       reset_token_expires_at = NULL
                   WHERE id_number = ?";
}

$stmt_update = $mysqli->prepare($sql_update);
$stmt_update->bind_param("ss", $password, $user["id_number"]);
$stmt_update->execute();

// Show success message
echo "<script>alert('Password updated. You can now login in the app.'); window.location.href = 'success_reset.php';</script>";
exit;

?>

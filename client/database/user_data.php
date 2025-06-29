<?php
session_start(); // Start the session

include ('db_conn.php');

// Check if the session variable for the username is set
if (!isset($_SESSION['username'])) {
    // If session variable is not set, redirect to the login page
    header('Location: ../index.php');
    exit;
}

// You can use the session variable directly
$login_user = $_SESSION['username'];

// Retrieve the full name of the employee from the database
$sql = "SELECT full_name FROM account WHERE id_number = ?"; // Replace with the actual column names and condition
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number); // Use string parameter type for id_number

$id_number = $_SESSION['username']; // Get the username from the session variable

// Execute the query
if (!$stmt->execute()) {
    echo "Error executing query: " . $stmt->error;
    exit;
}

$result = $stmt->get_result();

// Check if the user was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];

    // Set the id_number session variable (if not already set)
    $_SESSION['id_number'] = $id_number;
} else {
    // No results found, so end the session and redirect to login page
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header('Location: ../index.php'); // Redirect to the login page
    exit;
}
?>

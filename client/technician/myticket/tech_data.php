<?php
session_start(); // Start the session

include ('db_conn.php');

// Check if the username session variable is set
if (isset($_SESSION['username'])) {
    $login_user = $_SESSION['username']; // Retrieve the username from session
    $id_number = $login_user; // Use the username as id_number
} else {
    // Set a default value if the session variable is not set
    $id_number = '';
    echo "Username session is not set!";
    exit;
}

// Retrieve the full name of the technician from the database
$sql = "SELECT full_name FROM technician WHERE id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number); // Use string parameter type for id_number

if (!$stmt->execute()) {
    echo "Error executing query: " . $stmt->error;
    exit;
}

$result = $stmt->get_result();

// Check if the technician was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name']; // Assign the full name from the query result
} else {
    // If no technician is found, log the user out and redirect to login
    echo "<script>alert('No user found! You will be logged out.');</script>";
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    echo "<script>window.location.href = '../../index.php';</script>"; // Redirect to login page
    exit;
}

// Optionally set the full name in the session if you plan to use it later
$_SESSION['full_name'] = $full_name;
$_SESSION['assigned_name'] = $full_name; // Add this to `tech_data.php`

?>

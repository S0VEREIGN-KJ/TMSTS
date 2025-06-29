<?php
include('db_conn.php');

// Get the current date and time
$current_time = date("Y-m-d H:i:s");

// SQL query to delete rows where activation expiry is older than 24 hours
$sql = "DELETE FROM account WHERE activation_expiry < DATE_SUB(?, INTERVAL 24 HOUR) AND account_activation_hash IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_time);

if ($stmt->execute()) {
    // Get the number of rows affected by the DELETE query
    $deleted_rows = $stmt->affected_rows;
    
    if ($deleted_rows > 0) {
        echo "$deleted_rows expired activation tokens older than 24 hours have been deleted.";
    } else {
        echo "No expired activation tokens found to delete.";
    }
} else {
    echo "Error deleting expired rows: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>

<?php
session_start();
include('../database/db_conn.php'); // <-- adjust the path if needed

header('Content-Type: application/json');

$sql = "SELECT ticket_number, status FROM ticket WHERE notification = 1"; // <-- make sure table name is correct
$result = $conn->query($sql);

$notifications = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notifications[] = [
            'ticket_number' => $row['ticket_number'],
            'status' => $row['status']
        ];
    }
}

// Return JSON response
echo json_encode($notifications);

$conn->close();
?>

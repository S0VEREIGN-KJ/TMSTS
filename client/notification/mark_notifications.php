<?php
include('../database/db_conn.php'); // adjust path if needed

header('Content-Type: application/json');

if (isset($_POST['ticket_number'])) { // The key should be 'ticket_number'
    $ticketNumber = $_POST['ticket_number'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE ticket SET notification = NULL WHERE ticket_number = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare the SQL statement']);
        exit;
    }

    $stmt->bind_param("s", $ticketNumber); // "s" for string

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Missing ticket_number']);
}

$conn->close();
?>

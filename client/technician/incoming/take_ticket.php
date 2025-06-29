<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'tech_data.php';
include 'db_conn.php';

// Check if assigned_name is available in session
if (!isset($_SESSION['full_name'])) {
    die("Error: Technician's name is not set.");
}

// Retrieve assigned_name from session
$assigned_name = $_SESSION['full_name'];
$received_by = $_SESSION['full_name'];
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fields expected from form
$fields = [
    'serial_number', 'subject', 'category', 'accessories', 'item_date_received',
    'received_by', 'diagnostic', 'priority', 'status', 'comment',
    'approved_by', 'release_date', 'ticket_number'
];
$status = 'In Progress';
$data = [];
foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) && $_POST[$field] !== '' 
                    ? mysqli_real_escape_string($conn, $_POST[$field]) 
                    : null; // Assign NULL if empty
}

// Prepare statement
$stmt = $conn->prepare("UPDATE ticket SET
    serial_number = ?, 
    subject = ?, 
    category = ?, 
    accessories = ?, 
    item_date_received = ?,
    received_by = ?, 
    assigned_name = ?, 
    diagnostic = ?, 
    priority = ?, 
    status = ?, 
    comment = ?, 
    approved_by = ?, 
    release_date = ?,
    notification = 1
    WHERE ticket_number = ?");

// Check if the statement is prepared successfully
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ssssssssssssss", 
    $data['serial_number'], $data['subject'], $data['category'], $data['accessories'], 
    $data['item_date_received'], $data['received_by'], $assigned_name,
    $data['diagnostic'], $data['priority'], $status, $data['comment'], 
    $data['approved_by'], $data['release_date'], $data['ticket_number']
);


// Execute query
if ($stmt->execute()) {
    echo '<div class="toast">Ticket updated successfully!</div>';
    header('Location: ../tech_home.php');
    exit;
} else {
    echo "Error executing statement: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
mysqli_close($conn);
?>
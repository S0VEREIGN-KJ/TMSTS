<?php
include("db_conn.php"); 

// Function to generate sequential ticket number based on the highest existing ticket number
function generateTicketNumber($conn) {
  // Query to find the highest ticket number in the database
  $sql = "SELECT MAX(ticket_number) AS max_ticket_number FROM ticket";
  $result = mysqli_query($conn, $sql);

  // If there is an existing ticket number, increment it by 1
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $maxTicketNumber = $row['max_ticket_number'];

      // Increment the ticket number
      // Assuming ticket number is a number, e.g., 1001, 1002, etc.
      $nextTicketNumber = $maxTicketNumber + 1;
  } else {
      // If no tickets exist, start at 1
      $nextTicketNumber = 1;
  }

  return $nextTicketNumber;
}
// Get form data
$serial_number = $_POST['serial_number'];
$date_req = $_POST['date_req'];
$time_req = $_POST['time_req'];
$datetime_req = date("Y-m-d H:i", strtotime("$date_req $time_req"));
$office = $_POST['office'];
$req_name = $_POST['req_name'];
$phone_number = $_POST['phone_number'];
$id_number = $_POST['id_number'];
$subject = $_POST['subject'];
$unit = $_POST['unit'];
$category = isset($_POST['category']) ? $_POST['category'] : null; // Make category optional
$email = $_POST['email'];
$accessories = isset($_POST['accessories']) ? implode(", ", $_POST['accessories']) : '';
$assigned_name = null;
$priority = null;
$received_by = null;
$diagnostic = null;
$comment = null;
$approved_by = null;
$release_date = null;
$item_date_received = null;
$status = "Pending";

// Generate random ticket number
$ticket_number = generateTicketNumber($conn);

// Check if ticket number already exists in database
while (true) {
  $sql = "SELECT * FROM ticket WHERE ticket_number = '$ticket_number'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) == 0) {
    break;
  }
  $ticket_number = generateTicketNumber($conn);
}

// Initialize image content as null if no image is uploaded
$imgContent = null;
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
  $image = $_FILES['image']['tmp_name'];
  $imgContent = file_get_contents($image);
}

// Now you can insert into the ticket table
$sql = "INSERT INTO ticket (ticket_number, serial_number, datetime_req, office, req_name, phone_number, email, id_number, subject, unit, category, assigned_name, priority, accessories, received_by, diagnostic, comment, approved_by, release_date, item_date_received, status, image)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssss", 
  $ticket_number, 
  $serial_number, 
  $datetime_req, 
  $office, 
  $req_name, 
  $phone_number, 
  $email, 
  $id_number, 
  $subject, 
  $unit, 
  $category, // This can be NULL if not set
  $assigned_name, 
  $priority,  
  $accessories, 
  $received_by,  
  $diagnostic, 
  $comment, 
  $approved_by, 
  $release_date, 
  $item_date_received, 
  $status, 
  $imgContent);

// Check if the connection is still active
if (!mysqli_ping($conn)) {
  echo "MySQL connection has gone away. Reconnecting...";
  mysqli_close($conn);
  $conn = mysqli_connect($servername, $username, $password, $db_name);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
}

$response = array('success' => false, 'message' => '');

try {
  mysqli_stmt_execute($stmt);
  if (mysqli_stmt_affected_rows($stmt) > 0) {
    $response['success'] = true;
    $response['message'] = "Ticket submitted successfully!";
  } else {
    $response['message'] = "Error submitting ticket: " . mysqli_error($conn);
  }
} catch (mysqli_sql_exception $e) {
  error_log("Error executing query: " . $e->getMessage());
  $response['message'] = "Error executing query: " . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit; // End script execution

// Close database connection
mysqli_close($conn);
?>

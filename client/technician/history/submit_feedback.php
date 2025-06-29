<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "cicto";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the feedback data from the form and sanitize it
    $ticketId = mysqli_real_escape_string($conn, $_POST['ticketId']);
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $feedbackComment = mysqli_real_escape_string($conn, $_POST['feedbackComment']);

    // Check if feedback for the ticket ID already exists
    $checkSql = "SELECT * FROM feedback WHERE ticket_id = '$ticketId'";
    $result = mysqli_query($conn, $checkSql);

    if (!$result) {
        // Error in executing query
        header("Location: history.php?message=Error checking feedback existence: " . mysqli_error($conn));
        exit();
    }

    if (mysqli_num_rows($result) > 0) {
        // Feedback already exists for this ticket ID
        header("Location: history.php?message=Feedback already sent for this ticket.");
        exit();
    } else {
        // Insert the feedback into the database with the current timestamp
        $sql = "INSERT INTO feedback (ticket_id, full_name, feedback, created_at) VALUES ('$ticketId', '$fullName', '$feedbackComment', CURRENT_TIMESTAMP)";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect to the history page with a success message
            header("Location: history.php?message=Feedback sent successfully");
            exit();
        } else {
            // Redirect to the history page with an error message
            header("Location: history.php?message=Error: " . mysqli_error($conn));
            exit();
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
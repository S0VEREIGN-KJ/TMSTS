<?php
include('database/db_conn.php');

if (!isset($_SESSION['username'])) {
    header("Location:ticket_flow/ticket.php");
    exit();
}

// You can use the session variable directly
$login_user = $_SESSION['id_number'];

// Remove the redundant query
// $sql = mysqli_query($conn, "SELECT id_number FROM account WHERE id_number='$user_check'");
// $row=mysqli_fetch_array($sql, MYSQLI_ASSOC);
// $login_user=$row['id_number'];
?>
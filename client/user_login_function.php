<?php
session_start();
include('database/db_conn.php');

$error = ""; // Initialize the $error variable to hold error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_number']) && isset($_POST['password'])) {
        $id_number = $_POST['id_number'];
        $password = $_POST['password'];

        if (empty($id_number)) {
            $error = "ID number is required"; // Set error message for empty ID
        } elseif (empty($password)) {
            $error = "Password is required"; // Set error message for empty password
        } else {
            // First, check if the user exists in the 'account' table
            $query_account = "SELECT id_number, password, account_activation_hash FROM account WHERE id_number = ? AND deleted = 0 LIMIT 1";
            $stmt_account = $conn->prepare($query_account); // Prepare the SQL statement
            $stmt_account->bind_param("s", $id_number); // Bind the parameter
            $stmt_account->execute(); // Execute the prepared statement
            $result_account = $stmt_account->get_result(); // Get the result set from the prepared statement

            // Check if the user was found in the account table
            if ($result_account && $result_account->num_rows > 0) {
                $user_data = $result_account->fetch_array(MYSQLI_ASSOC); // Fetch the user data as an associative array
                $hashed_password = $user_data['password']; // Get the hashed password from the database
                $activation_hash = $user_data['account_activation_hash']; // Get the account activation hash

                // Check if the account is activated
                if ($activation_hash === null) {
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION['username'] = $id_number; // Set the session variable
                        header("Location: home.php"); // Redirect to account page
                        exit(); // Stop further execution
                    } else {
                        $error = "Invalid Username or Password."; // Set error for invalid login
                    }
                } else {
                    $error = "Your account is not activated. Please check your email for the activation link."; // Set error for unactivated account
                }
            } else {
                // If not found in the account table, check the 'technician' table
                $query_technician = "SELECT id_number, password, account_activation_hash FROM technician WHERE id_number = ? AND deleted = 0 LIMIT 1";
                $stmt_technician = $conn->prepare($query_technician); // Prepare the SQL statement
                $stmt_technician->bind_param("s", $id_number); // Bind the parameter
                $stmt_technician->execute(); // Execute the prepared statement
                $result_technician = $stmt_technician->get_result(); // Get the result set from the prepared statement

                // Check if the user was found in the technician table
                if ($result_technician && $result_technician->num_rows > 0) {
                    $user_data = $result_technician->fetch_array(MYSQLI_ASSOC); // Fetch the user data as an associative array
                    $hashed_password = $user_data['password']; // Get the hashed password from the database
                    $activation_hash = $user_data['account_activation_hash']; // Get the account activation hash

                    // Check if the technician's account is activated
                    if ($activation_hash === null) {
                        if (password_verify($password, $hashed_password)) {
                            $_SESSION['username'] = $id_number; // Set the session variable
                            header("Location: technician/tech_home.php"); // Redirect to technician page
                            exit(); // Stop further execution
                        } else {
                            $error = "Invalid password."; // Set error for invalid password
                        }
                    } else {
                        $error = "Your account is not activated. Please check your email for the activation link."; // Set error for unactivated account
                    }
                } else {
                    $error = "Incorrect username or password"; // Set error if user is not found
                }
            }
        }
    }
}
?>
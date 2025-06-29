<?php
include('db_conn.php');
include('mailer.php');

// Function to sanitize text and remove emojis and special characters
function sanitizeText($text) {
    // Remove all non-alphanumeric characters, including emojis and special characters
    $sanitizedText = preg_replace('/[^\w\s]/u', '', $text);
    return $sanitizedText;
}

// Get form data
$id_number = $_POST['id_number'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password

// Sanitize names to prevent emoticons and special characters
$first_name = sanitizeText($_POST['first_name']);
$middle_name = sanitizeText($_POST['middle_name']);
$last_name = sanitizeText($_POST['last_name']);
$full_name = $first_name . ' ' . $middle_name . ' ' . $last_name;

$phone_number = $_POST['phone_number'];
$email = $_POST["email"];

// Generate a random activation token and hash it
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

// Set the activation expiry time (e.g., 30 minutes from now)
$activation_expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 minutes

// Determine office based on which select has a value
$office = !empty($_POST['department']) ? $_POST['department'] : (!empty($_POST['barangay']) ? $_POST['barangay'] : '');

// Check for duplicates in the account and technician tables
$sql = "
    SELECT 'account' AS table_name, id_number, phone_number, email, account_activation_hash, activation_expiry 
    FROM account 
    WHERE (id_number = ? OR phone_number = ? OR email = ?) AND deleted = 0
    UNION
    SELECT 'technician' AS table_name, id_number, phone_number, email, account_activation_hash, activation_expiry 
    FROM technician 
    WHERE (id_number = ? OR phone_number = ? OR email = ?) AND deleted = 0
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $id_number, $phone_number, $email, $id_number, $phone_number, $email);
$stmt->execute();
$result = $stmt->get_result();

$duplicatedFields = [];

if ($result->num_rows > 0) {
    // Check if any result has an activation code that is not null
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['account_activation_hash'])) {
            // Collect the duplicated fields for error reporting
            if ($row['id_number'] == $id_number) {
                $duplicatedFields[] = 'ID Number';
            }
            if ($row['phone_number'] == $phone_number) {
                $duplicatedFields[] = 'Phone Number';
            }
            if ($row['email'] == $email) {
                $duplicatedFields[] = 'Email';
            }
        }
    }

    // Report which fields are duplicated
    $duplicateMessage = 'The following field(s) are already in use: ' . implode(', ', $duplicatedFields);
    $error = $duplicateMessage . ' Please try again.';
} else {
    // No active account or technician exists, proceed with creating a new account
    $sql = "INSERT INTO account (id_number, password, full_name, phone_number, email, office, account_activation_hash, activation_expiry, deleted) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $id_number, $hashed_password, $full_name, $phone_number, $email, $office, $activation_token_hash, $activation_expiry);

    if ($stmt->execute()) {
        // Send the activation email
        $emailStatus = sendActivationEmail($email, $_POST['first_name'], $activation_token);

        if ($emailStatus === true) {
            $successMessage = "Check your email to activate your account!";
        } else {
            $error = "Message could not be sent. " . $emailStatus;
        }
    } else {
        // Handle error on insert
        if ($stmt->errno === 1062) {
            $error = "Email already taken!";
        } else {
            $error = "Error inserting data: " . $stmt->error;
        }
    }
}

// Close connection
$conn->close();
?>

<!-- SweetAlert for error handling -->
<?php if (!empty($error)) : ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: <?= json_encode($error); ?>, // Display the error message
        showConfirmButton: true,
        timer: 5000
    }).then(function() {
        window.location.href = 'Sign_up.html'; // Redirect to the index page after success
      });
    });
  </script>
<?php endif; ?>

<!-- SweetAlert for success handling -->
<?php if (!empty($successMessage)) : ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        icon: 'success',
        title: 'CHECK YOUR EMAIL TO ACTIVATE!',
        text: <?= json_encode($successMessage); ?>, // Display the success message
        showConfirmButton: true,
        timer: 5000
      }).then(function() {
        window.location.href = 'index.php'; // Redirect to the index page after success
      });
    });
  </script>
<?php endif; ?>

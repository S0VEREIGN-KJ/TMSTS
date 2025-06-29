<?php
include 'tech_data.php'; // Ensure this is included to get the session data
include 'db_conn.php'; // Ensure this file correctly defines $conn

// Check if assigned_name is available in session
if (!isset($_SESSION['full_name'])) {
    die("Error: Technician's name is not set.");
}

// Retrieve assigned_name from session
$assigned_name = $_SESSION['full_name'];

// SQL query to retrieve the user's tickets
$sql = "SELECT * FROM ticket WHERE assigned_name = ? AND status IN ('In Progress', 'Scheduled') ORDER BY datetime_req DESC";

// Prepare the statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

// Bind the technician's assigned name to the statement
$stmt->bind_param("s", $assigned_name);  // "s" specifies a string parameter type

// Execute the statement
if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}


// Get the result
$result = $stmt->get_result();
echo '<h1>Taken Tickets</h1>';




echo '<a href="../tech_home.php" style="float: left; margin-left: 10px; margin-top: 0;">
        <button style="background-color:#AA0000; color: #fff; padding: 10px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 10pt; font-weight: bold;margin-bottom:10px;">
            &#8592; HOME
        </button>
    </a>';


if ($result->num_rows === 0) {
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo "<p>No tickets found for the specified criteria. GET TICKET?</p>";
  echo '<a href="../incoming/incoming.php" style="float: left; margin-left: 200px; margin-top: 0;">
          <button style="background-color:#90EE90; color: #fff; padding: 10px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 10pt; font-weight: bold;margin-bottom:10px;">
              !! GET TICKET?
          </button>
      </a>';
} else {
    echo '<div class="table-container"><table>';
    echo '<tr><th>Ticket ID</th><th>Ticket Date</th><th>Status</th><th>Details</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ticket_number']) . "</td>";
        echo "<td>" . date("m/d/Y - g:i A", strtotime($row["datetime_req"])) . "</td>";
        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
        echo '<td><a href="#" onclick="openNav(' . htmlspecialchars($row["ticket_number"]) . ')">Details</a></td>';
        echo "</tr>";
    }
    echo '</table></div>';
}

// Close the statement but do not close the connection yet
$stmt->close();
?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="loading.js" defer></script>

  <title>Current Ticket</title>
  <style>
    
   body {
      font-family: Arial, sans-serif;
      font-size: 16px; /* set a base font size */
      margin: 0;
      padding: 0;
    }
 
  .loadingOverlay {  
    position: fixed; /* Fixed position to cover the viewport */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
    z-index: 1000; /* High z-index to overlay on top */
    display: none; /* Hidden by default */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
}

.loader {
    display: flex;
    align-items: center;
}

.dot {
    width: 15px;
    height: 15px;
    margin: 0 5px;
    border-radius: 50%;
    background-color: #333;
    animation: bounce 0.6s infinite alternate;
}

.dot:nth-child(1) {
    animation-delay: 0s;
}

.dot:nth-child(2) {
    animation-delay: 0.2s;
}

.dot:nth-child(3) {
    animation-delay: 0.4s;
}
@keyframes bounce {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-20px);
    }
}
    h1 {
      text-align: center;
    }

    .table-container {
      padding: 1em; /* Add some padding */
    }

    table {
      border-collapse: collapse;
      width: 100%; /* Use full width */
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      box-sizing: border-box;
      border: 1px solid #000;
      margin: 0;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 0.5em; /* use em units instead of px */
      text-align: left;
      word-wrap: break-word; /* Allow long words to break and wrap onto the next line */
      overflow: hidden; /* Hide overflow content */
      text-overflow: ellipsis; /* Add ellipsis (...) for overflowed content */
      max-width: 150px; /* Set a maximum width for the cells */
    }

    th {
      background-color: #f0f0f0;
    }

    /* Media query for smaller screens (e.g., Android devices) */
    @media only screen and (max-width: 768px) {
      table {
        font-size: 20px; /* reduce font size for smaller screens */
      }
      th, td {
        padding: 0.25em; /* reduce padding for smaller screens */
        max-width: 100px; /* Adjust max-width for smaller screens */
      }
    }














/* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */
  /* overlay_container */
  .overlay_container {
    width: 100%;
    max-width: .5in; /* Max width to fit half of short bond paper */
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
   
    margin: 0; /* Remove extra margins */
    text-align: left;
      word-wrap: break-word; /* Allow long words to break and wrap onto the next line */
      text-overflow: ellipsis; /* Add ellipsis (...) for overflowed content */
      max-width: 400px; /* Set a maximum width for the cells */
    
}
/* Form Group */
.overlay_form_group {
    margin-bottom: 10px; /* Spacing between form groups */
    align-items: center; /* Align items vertically centered */
    justify-content: space-between; /* Space between label and input */
}

label {
    flex: 0 0 150px; /* Set a fixed width for the label */
    margin: 0; /* Remove extra margins */
    font-weight: bold ;
}

input, select {
    width: 100%;
    padding: 8px; /* Increased padding inside input fields */
    border: 1px solid #000;
    border-radius: 4px;
}

/* Custom Select with Device Image */
.custom-select {
    position: relative;
    width: 100%;
}

.select-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px; /* Increased padding inside select box */
    border: 1px solid #000;
    border-radius: 4px;
    cursor: pointer;
    background: #fff; /* Added background for select box */
}

.select-box img {
    width: 40px; /* Adjust size of the device image */
    height: auto;
}

.options-overlay_container {
    position: absolute;
    width: calc(100% - 2px); /* Adjust to match select box width */
    background: #fff;
    border: 1px solid #000;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 10;
    top: 100%; /* Position below the select box */
    left: 0; /* Align with left edge of select box */
}

.options-overlay_container.visible {
    display: block;
}

.option {
    display: flex;
    align-items: center;
    padding: 8px; /* Increased padding inside option items */
    border-bottom: 1px solid #ddd; /* Divider between options */
    cursor: pointer;
}

.option:hover {
    background-color: #f2f2f2; /* Highlight on hover */
}

.option img {
    width: 30px; /* Adjust size of option images */
    height: auto;
    margin-right: 10px; /* Space between image and text */
}


.overlay {
  height: 0; /* Full height */
  width: 100%; /* Full width */
  position: fixed;
  z-index: 1;
  top: 0;
  background-color: rgba(255, 255, 255, 0.9); /* Slightly opaque background */
  justify-content: center;
  display: flex;
  overflow-y: hidden; /* Allow scrolling */
  transition: 0.5s;
  
}

.overlay-content {
  width: 100%; /* Full width */
  max-width: 500px; /* Limit max width for larger screens */
  text-align: left; /* Align text to the left */
  margin: 0 auto; /* Center the overlay content */
  padding: 20px; /* Add padding */
  background-color: #FFFFFF;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  max-height: 90vh; /* Limit the height */
  overflow-y: auto; /* Allow scrolling if content is too tall */
}
.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.overlay a:hover, .overlay a:focus {
  color: #ff0000;
}

.overlay .closebtn {
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 40px;
  color: #ff0000; /* or rgb(255, 0, 0) or rgba(255, 0, 0, 1) */
  border: 2px solid #000;
}


@media screen and (max-height: 450px) {
  .overlay {overflow-y: auto;}
  .overlay a {font-size: 40px}
  .overlay .closebtn {
  font-size: 40px;
  top: 15px;
  right: 35px;
  }
}



  </style>
</head>
<body>

  <div id="loadingOverlay" class="loadingOverlay">  <!--LOADING SCREEN-->
        <div class="loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div> 



  
<div id="myNav" class="overlay">


<div class="overlay-content">
<div class="overlay_container">
      <!-- overlay_header with Logo -->


<form action="update_ticket.php" method="post" autocomplete="off" id="ticket_form">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>  <!-- close button for overlay -->
<div class="overlay_form_group">
              <label for="ticket_number">Ticket ID:</label>
              <input type="text" id="ticket_number" name="ticket_number"  value="<?php echo $ticket_data['ticket_number']; ?>" readonly required> <!-- date_req -->
          </div>
          
      <div class="overlay_form_group">
              <label for="serial_number">Serial No.</label>
              <input type="text" id="serial_number" name="serial_number"  value="<?php echo $ticket_data['serial_number']; ?>" readonly required> <!-- serial_number -->
          </div>

        <div class="overlay_form_group">
              <label for="datetime_req">Date and TIme Requested</label>
              <input type="datetime-local" id="datetime_req" name="datetime_req"  value="<?php echo $ticket_data['datetime_req']; ?>" readonly required>    <!-- date requested -->
          </div>

        <div class="overlay_form_group">
              <label for="id_number">Employee ID</label>
              <input type="text" id="id_number" name="id_number" value="<?php echo $ticket_data['id_number']; ?>" readonly required> <!-- id_number -->
          </div>
        <div class="overlay_form_group">
              <label for="req_name">Requester Name</label>
              <input type="text" id="req_name" name="req_name" value="<?php echo $ticket_data['req_name']; ?>" readonly required> <!-- ful name -->
          </div>
        <div class="overlay_form_group">
              <label for="office">Office</label>
              <input type="text" id="office" name="office" value="<?php echo $ticket_data['office']; ?>" readonly required> <!-- office -->
          </div>
        <div class="overlay_form_group">
              <label for="phone_number">Phone Number:</label>
              <input type="text" id="phone_number" name="phone_number"  value="<?php echo $ticket_data['phone_number']; ?>"readonly required> <!-- phone_number -->
          </div>
          <div class="overlay_form_group">
              <label for="email">Email Address</label>
              <input type="text" id="email" name="email"  value="<?php echo $ticket_data['email']; ?>"readonly required> <!-- email -->
          </div>
          <div class="overlay_form_group">
              <label for="subject">Subject</label>
              <input type="text" id="subject" name="subject"   value="<?php echo $ticket_data['subject']; ?>" readonly required><!-- subject -->
          </div>
 
<!-- Department and Barangay Selection -->
        
<div class="overlay_form_group">
          
          </div>
         
          <div class="overlay_form_group">
              <label for="unit">Select Device:</label>
              <input type="text" id="unit" name="unit"   readonly required> <!-- unit -->
          </div>

          <div class="overlay_form_group">
              <label for="category">Category:</label>
              <input type="text" id="category" name="category"   readonly required> <!-- unit -->
          </div>

   <!-- Accessories Table -->
   <div class="overlay_form_group">
              <label>Accessories:</label><!-- accessories -->
              <input type="text" id="accessories" name="accessories"   readonly required> <!-- unit -->
          </div>
          <!-- Additional Repair Information -->
          <div class="overlay_form_group">
              <label for="item_date_received">Item Date Received:</label><!-- item_date_received -->
              <input type="date" id="item_date_received" name="item_date_received" value="<?php echo $item_date_received; ?>" readonly>
          </div>

          <div class="overlay_form_group">
              <label for="received_by">Received by:</label><!-- received_by -->
              <input type="text" id="received_by" name="received_by" value="<?php echo $received_by; ?>"readonly >
          </div>

          <div class="overlay_form_group">
              <label for="assigned_name">Name of Technician:</label>
              <input type="text" id="assigned_name" name="assigned_name" value="<?php echo $assigned_name; ?>" readonly>     <!-- assigned_name -->
          </div>

          <div class="overlay_form_group">
              <label for="diagnostic" style="text-decoration: underline; color:green; font-weight:bold;">DIAGNOSTIC:</label>
              <input type="text" id="diagnostic" name="diagnostic" value="<?php echo $diagnostic; ?>">    <!-- diagnostic-->
          </div>

          <div class="overlay_form_group">
  <label for="status" >Priority:</label>
  <input id="priority" name="priority" value="<?php echo htmlspecialchars($priority); ?>" readonly>
</div>

</div>

<div class="overlay_form_group">
                <label for="status" style="text-decoration: underline; color:green; font-weight:bold;">STATUS:</label>
                <select id="status" name="status" value="<?php echo $status; ?>" required><!-- status-->
                    <option  selected> </option>
                    <option value="Condemn">Condemn</option>
                    <option value="Repaired">Repaired</option>
                    
                </select>
            </div>

            <div class="overlay_form_group" id="condemnReasonContainer" style="display: none; margin-top: 10px;">
  <label for="condemn_reason">Condemn Reason:</label>
  <input type="text" id="condemn_reason" name="condemn_reason" placeholder="Enter reason for condemnation" />
</div>

          <div class="overlay_form_group">
              <label for="comment" style="text-decoration: underline; color:green; font-weight:bold;">RECOMMENDATION:</label>
              <input type="text" id="comment" name="comment" value="<?php echo $comment; ?>" required><!-- comment -->
          </div>

          <div class="overlay_form_group">  
              <label for="approved_by">Approved for Release by:</label>
              <input type="text" id="approved_by"  name="approved_by"  value="<?php echo $approved_by; ?>" required><!-- approved_by -->
          </div>

          <div class="overlay_form_group">
              <label for="release_date">Item Release Date:</label>
              <input type="date" id="release_date" placeholder="Dated when Repaired..." name="release_date"  value="<?php echo $release_date; ?>" required><!-- release_date -->
          </div>

          <div class="overlay_form_group">
    <label for="image">Image:</label>
    <img id="image" src="" alt="Image" style="max-width: 80%; height: auto; object-fit: contain; margin-top: 10px; margin-left: 0;"> <!-- Added margin-top for spacing -->
</div>

     
<div class="overlay_form_group">
      <br>
   
    <!-- your form fields here -->
    <br>
   
    <button type="submit" id="save-changes" 
            style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
     Send Finish Ticket
    </button>
</form>
  </div>
  </div>


</div>
</div>

<!-- Include SweetAlert2 (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

document.getElementById('ticket_form').addEventListener('submit', function (e) {
  e.preventDefault(); // Prevent immediate submission

  Swal.fire({
    title: 'Send Ticket?',
    text: 'Are you sure you want to send this finished ticket?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#4CAF50',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, send it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Sending...',
        text: 'Please wait while we process your ticket.',
        didOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false
      });

      // Submit the form after a short delay
      setTimeout(() => {
        e.target.submit(); // Actually submit the form now
      }, 1200);
    }
  });
});

// Show success message if redirected with ?status=success
window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('status') === 'success') {
    Swal.fire({
      title: 'Ticket Sent!',
      text: 'The finished ticket has been successfully sent.',
      icon: 'success',
      confirmButtonText: 'OK'
    });
    // Remove the query parameter so it doesn't trigger again on reload
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});


document.getElementById('status').addEventListener('change', function () {
  const condemnReasonContainer = document.getElementById('condemnReasonContainer');
  if (this.value === 'Condemn') {
    condemnReasonContainer.style.display = 'block';
  } else {
    condemnReasonContainer.style.display = 'none';
  }
});


function openNav(ticketNumber) {
  // Fetch ticket details using AJAX
  $.ajax({
      type: 'GET',
      url: 'fetch_ticket.php',
      
      data: {ticket_number: ticketNumber, table_name: 'ticket'},
      cache: false, // Add this to prevent caching
      success: function(data) {
          // Populate form fields with fetched data
          var ticketDetails = JSON.parse(data);
          document.getElementById('ticket_number').value = ticketDetails.ticket_number;
          document.getElementById('serial_number').value = ticketDetails.serial_number;
          document.getElementById('datetime_req').value = ticketDetails.datetime_req;
          document.getElementById('id_number').value = ticketDetails.id_number;
          document.getElementById('req_name').value = ticketDetails.req_name;
          document.getElementById('office').value = ticketDetails.office;
          document.getElementById('phone_number').value = ticketDetails.phone_number;
          document.getElementById('email').value = ticketDetails.email;
          document.getElementById('subject').value = ticketDetails.subject;
          document.getElementById('unit').value = ticketDetails.unit;
          document.getElementById('category').value = ticketDetails.category;
          document.getElementById('accessories').value = ticketDetails.accessories;
          document.getElementById('item_date_received').value = ticketDetails.item_date_received;
          document.getElementById('received_by').value = ticketDetails.received_by;
          document.getElementById('assigned_name').value = ticketDetails.assigned_name;
          document.getElementById('diagnostic').value = ticketDetails.diagnostic;
          document.getElementById('priority').value = ticketDetails.priority;
          document.getElementById('status').value = ticketDetails.status;
          document.getElementById('comment').value = ticketDetails.comment;
          document.getElementById('approved_by').value = ticketDetails.approved_by;
          document.getElementById('release_date').value = ticketDetails.release_date;
          document.getElementById('image').value = ticketDetails.image;
                       // Display the image
                       var imageBase64 = ticketDetails['image'];
          var imageElement = document.getElementById('image');
          imageElement.src = 'data:image/jpeg;base64,' + imageBase64;
        },
      error: function(xhr, status, error) {
          console.error('Error fetching ticket details:', error);
        },
      complete: function() {
          console.log('AJAX request complete!');
      }
  });


  // Open the overlay
  document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.height = "0";
}

// Get the datetime input element
const datetimeInput = document.getElementById('datetime_req');

// Add an event listener to the input element
datetimeInput.addEventListener('input', () => {
// Get the value of the input element
const datetimeValue = datetimeInput.value;

// Format the time as AM/PM
const formattedTime = new Date(datetimeValue).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

// Update the input element with the formatted time
datetimeInput.value = formattedTime;
});
</script>
</body>
</html>

<!-- Optionally close connection after all queries are done -->
<?php
$conn->close();
?>
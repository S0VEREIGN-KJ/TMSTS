<?php
include 'tech_data.php';

$stmt = $conn->prepare("SELECT * FROM ticket WHERE status = ? ORDER BY datetime_req DESC") ;
$status = 'Pending';
$stmt->bind_param("s", $status); // "s" specifies a single string parameter
$stmt->execute();
$result = $stmt->get_result();

// Default values for form fields
$item_date_received = $received_by = $assigned_name = $diagnostic = $priority = $comment = $approved_by = $release_date = null;

// Initialize variables with POST data or session
if (isset($_POST['item_date_received'])) {
    $item_date_received = $_POST['item_date_received'];
}

if (isset($_POST['received_by'])) {
    $received_by = $_POST['received_by'];
}

if (isset($_POST['assigned_name'])) {
    $assigned_name = $_POST['assigned_name'];
} else {
    // If assigned_name is not set, use the session value if available
    if (isset($_SESSION['assigned_name'])) {
        $assigned_name = $_SESSION['assigned_name'];
    }
}

if (isset($_POST['diagnostic'])) {
    $diagnostic = $_POST['diagnostic'];
}

if (isset($_POST['priority'])) {
    $priority = $_POST['priority'];
}

if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
}

if (isset($_POST['approved_by'])) {
    $approved_by = $_POST['approved_by'];
}

if (isset($_POST['release_date'])) {
    $release_date = $_POST['release_date'];
}


?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Incoming Tickets</title>
  <style>
    
   body {
      font-family: Arial, sans-serif;
      font-size: 16px; /* set a base font size */
      margin: 0;
      padding: 0;
    }
    h1 {
      text-align: center;
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
      max-width: 140px; /* Set a maximum width for the cells */
    }

    th {
      background-color: #f0f0f0;
    }
    tr:nth-child(even) {
    background-color: #f9f9f9; /* Light gray for every other row */
}

tr:nth-child(odd) {
    background-color: #fff; /* White for the odd rows */
}

    /* Media query for smaller screens (e.g., Android devices) */
    @media only screen and (max-width: 768px) {
  
      th, td {
        padding: 0.25em; /* reduce padding for smaller screens */
        max-width: 100px; /* Adjust max-width for smaller screens */
      }
      #myNav {
  overflow-y: scroll; /* Allow vertical scrolling */
  -webkit-overflow-scrolling: touch; /* Smooth scrolling on touch devices */
  touch-action: none; /* Disable pull-to-refresh */
  scroll-behavior: smooth; /* Smooth scrolling */
}
    }


/* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */ /* overlay_container */
  /* overlay_container */
  .overlay_container {
    width: 90%;
    max-width: .5in; /* Max width to fit half of short bond paper */
    background-color: #fff;
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

.feedback-overlay {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    background-color: rgba(0, 0, 0, 0.8); /* Black with opacity */
    z-index: 1000; /* Sit on top */
    overflow: auto; /* Enable scroll if needed */
}

.overlay-content {
    background-color: #fefefe; /* White background */
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px; /* Inner padding */
    border: 1px solid #888; /* Border color */
    width: 70%; /* Set width */
    max-width: 600px; /* Max width */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow */
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 40px;
    color: #ff0000; /* Red color for close button */
    cursor: pointer;
}

h2 {
    color: #333; /* Darker text for better readability */
    font-family: 'Arial', sans-serif; /* Font style */
    margin-bottom: 20px; /* Margin below heading */
}

.ticket-number {
    font-size: 16px;
    color: #666; /* Grey color for ticket number */
    margin-bottom: 15px; /* Space below ticket number */
}

label {
    display: block; /* Block display for labels */
    margin: 10px 0 5px; /* Spacing for labels */
    font-weight: bold; /* Bold text for labels */
}

input[type="text"],
textarea {
    width: 100%; /* Full width */
    padding: 10px; /* Inner padding */
    margin: 5px 0 15px; /* Spacing */
    border: 1px solid #ccc; /* Border */
    border-radius: 5px; /* Rounded corners */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); /* Inner shadow */
    font-size: 14px; /* Font size */
}

textarea {
    height: 100px; /* Set height for textarea */
    resize: none; /* Disable resizing */
}

.submit-btn {
    background-color: #28a745; /* Green button */
    color: white; /* White text */
    border: none; /* No border */
    padding: 10px 20px; /* Padding */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor */
    font-size: 16px; /* Font size */
}

.submit-btn:hover {
    background-color: #218838; /* Darker green on hover */
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
  #myNav {
  overflow-y: scroll; /* Allow vertical scrolling */
  -webkit-overflow-scrolling: touch; /* Smooth scrolling on touch devices */
  touch-action: none; /* Disable pull-to-refresh */
  scroll-behavior: smooth; /* Smooth scrolling */
}
}

  </style>
</head>
<body>
  <h1>PENDING Tickets</h1>

  <?php include_once '../../loading.php'; ?>

      <!--Back to home.php-->
      <div>
    <a href="../tech_home.php" style="float: left; margin-left: 10px; margin-top: 0;">
        <button style="background-color:#AA0000; color: #fff; padding: 10px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 10pt; font-weight: bold;margin-bottom:10px;">
            &#8592; HOME
        </button>
    </a>
</div>



<div class="table-container">
    <table>
      <tr>
        <th>ID</th>
        <th>Ticket Date</th>
        <th>Office</th>
        <th>Category</th>
        <th>Get Ticket</th>
      </tr>
      <?php
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ticket_number'] . "</td>";
        echo "<td>" . date("m/d/Y - g:i A", strtotime($row["datetime_req"])) . "</td>"; // Modified line
        echo "<td>" . $row["office"] . "</td>";
        echo "<td>" . $row["category"] . "</td>";
        echo '<td><a href="#" onclick="openNav(\'' . $row["ticket_number"] . '\')">Accept?</a></td>'; // Feedback option click
        echo "</tr>";
      }
      ?>
    </table>
  </div>








  
<div id="myNav" class="overlay">


<div class="overlay-content">
<div class="overlay_container">
      <!-- overlay_header with Logo -->

      

<form action="take_ticket.php" method="post" autocomplete="off">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>  <!-- close button for overlay -->
<div class="overlay_form_group">
              <label for="ticket_number">Ticket ID:</label>
              <input type="text" id="ticket_number" name="ticket_number"  readonly required> <!-- date_req -->
          </div>
          
      <div class="overlay_form_group">
              <label for="serial_number">Serial No.</label>
              <input type="text" id="serial_number" name="serial_number"  required> <!-- serial_number -->
          </div>

        <div class="overlay_form_group">
              <label for="datetime_req">Date and TIme Requested</label>
              <input type="datetime-local" id="datetime_req" name="datetime_req"  readonly required>    <!-- date requested -->
          </div>

        <div class="overlay_form_group">
              <label for="id_number">Employee ID</label>
              <input type="text" id="id_number" name="id_number"readonly required> <!-- id_number -->
          </div>
        <div class="overlay_form_group">
              <label for="req_name">Requester Name</label>
              <input type="text" id="req_name" name="req_name" readonly required> <!-- ful name -->
          </div>
        <div class="overlay_form_group">
              <label for="office">Office</label>
              <input type="text" id="office" name="office"  readonly required> <!-- office -->
          </div>
        <div class="overlay_form_group">
              <label for="phone_number">Phone Number:</label>
              <input type="text" id="phone_number" name="phone_number" readonly required> <!-- phone_number -->
          </div>
          <div class="overlay_form_group">
              <label for="email">Email Address</label>
              <input type="text" id="email" name="email" readonly required> <!-- email -->
          </div>
          <div class="overlay_form_group">
              <label for="subject">Subject</label>
              <input type="text" id="subject" name="subject"   required><!-- subject -->
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
     <select type="text" id="category" name="category"    required> 
                    <option disabled selected> </option>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option><!-- category -->
                </select>
          </div>

   <!-- Accessories Table -->
   <div class="overlay_form_group">
              <label>Accessories:</label><!-- accessories -->
              <input type="text" id="accessories" name="accessories"    required> <!-- unit -->
          </div>
          <!-- Additional Repair Information -->
          <div class="overlay_form_group">
        <label for="item_date_received" style="text-decoration: underline; color:green; font-weight:bold;">ITEM RECEIVED / SCHEDULE:</label>
        <input type="date" id="item_date_received" name="item_date_received" value="<?php echo htmlspecialchars($item_date_received); ?>" required>
    </div>

    <div class="overlay_form_group">
        <label for="received_by">Received by:</label>
        <input type="text" id="received_by" placeholder="Your name will be here once getting the ticket...." name="received_by" value="<?php echo htmlspecialchars($received_by); ?>" readonly>
    </div>

    <div class="overlay_form_group">
        <label for="assigned_name" style="text-decoration: underline; color:green; font-weight:bold;">NAME OF TECHNICIAN:</label>
        <input type="text" id="assigned_name" placeholder="Your name will be here once getting the ticket...." name="assigned_name" value="<?php echo htmlspecialchars($assigned_name); ?>" readonly>
    </div>

    <div class="overlay_form_group">
        <label for="diagnostic" style="text-decoration: underline; color:green; font-weight:bold;">DIAGNOSTIC:</label>
        <input type="text" id="diagnostic" name="diagnostic" value="<?php echo htmlspecialchars($diagnostic); ?>" required>
    </div>


    <div class="overlay_form_group">
  <label for="status" >Priority:</label>
  <input id="priority" name="priority" value="<?php echo htmlspecialchars($priority); ?>" readonly>
</div>

    <div class="overlay_form_group">
        <label for="status">Status:</label>
        <input id="status" name="status" value="<?php echo htmlspecialchars($status); ?>" readonly>
    </div>

    <div class="overlay_form_group">
        <label for="comment">Recommendation:</label>
        <input type="text" id="comment" name="comment" value="<?php echo htmlspecialchars($comment); ?>" readonly>
    </div>

    <div class="overlay_form_group">
        <label for="approved_by">Approved for Release by:</label>
        <input type="text" id="approved_by" name="approved_by" value="<?php echo htmlspecialchars($approved_by); ?>" readonly>
    </div>

    <div class="overlay_form_group">
        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" value="<?php echo htmlspecialchars($release_date); ?>" readonly>
    </div>
          <div class="overlay_form_group">
    <label for="image">Image:</label>
    <img id="image" src="" alt="Image" style="max-width: 100%; height: auto; object-fit: contain; margin-top: 10px; margin-left: 0;"> <!-- Added margin-top for spacing -->
</div>
<div class="overlay_form_group">
      <br>
   
    <!-- your form fields here -->
    <br>
    
    <button type="submit" id="save-changes" 
            style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
      Take Ticket
    </button>
</form>
  </div>
  </div>


</div>
</div>

<script>

function openNav(ticketNumber) {
  // Reset the scroll position to the top (0)
  var overlayContainer = document.querySelector('.overlay-content');
  if (overlayContainer) {
    overlayContainer.scrollTop = 0;
  }
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

// Get elements
const feedbackBtn = document.getElementById("feedbackBtn");
const feedbackOverlay = document.getElementById("feedbackOverlay");
const closeBtn = document.getElementById("closeBtn");
const feedbackForm = document.getElementById("feedbackForm");

function openFeedbackOverlay(ticketNumber, assignedName) {
    document.getElementById("ticketNumberDisplay").innerText = "Ticket Number: " + ticketNumber;

    // Set the assigned name in the full name input field
    document.getElementById('fullName').value = assignedName; // Ensure assignedName is passed as a parameter
    
    // Set the ticket number in the hidden input field
    document.getElementById('ticketId').value = ticketNumber;

    feedbackOverlay.style.display = "block";
}


// Close overlay when clicking outside of content
window.onclick = function(event) {
    if (event.target === feedbackOverlay) {
        feedbackOverlay.style.display = "none";
    }
}

</script>
</body>
</html>
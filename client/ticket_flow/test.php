<?php
include("user_data.php"); 

// Use the session variable to retrieve the user's data
$login_user = $_SESSION['id_number'];

// Retrieve the user's data using a prepared statement
$stmt = $conn->prepare("SELECT id_number, full_name, phone_number, office, email FROM account WHERE id_number = ?");
$stmt->bind_param("s", $login_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // You can now use the user's data stored in $row
     $id_number = $row["id_number"];
    $full_name = $row['full_name'];
    $phone_number = $row['phone_number'];
    $email = $row['email'];
    $office = $row['office'];
} else {
    // If no user data is found, log the user out and redirect to the login page
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order Slip</title>
  <link rel="stylesheet" href="order_slip.css"> <!-- Link to the external CSS file -->
  <script src="../js/loading.js" defer></script>
  <style>
    .header img{
      width: 50px;
      height: auto;
    }
    table {
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
    }
    button[type="submit"] {
      font-size: 22pt;
      font-weight: bold;
  margin-left: 550px;
  background-color: #4CAF50; /* green background color */
  color: #fff; /* white text color */
  padding: 10px 20px; /* add some padding to make it look bigger */
  border: none; /* remove the default border */
  border-radius: 5px; /* add a slight curve to the corners */
  cursor: pointer; /* change the cursor to a pointing hand */
}

button[type="submit"]:hover {
  background-color: #3e8e41; /* darker green background color on hover */
}

    /* Overlay styles */
    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    #message {
      background: #333;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
    }
    .accessory-checkbox {
    transform: scale(1.4); /* Adjust the scale as needed */
}


  </style>
</head>
<body>

<!-- Overlay for success message -->
<div id="overlay">
    <div id="message"></div>
</div>


<div id="loadingOverlay" class="loadingOverlay">   <!--LOADING SCREEN-->
        <div class="loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>


  <div id="time-date"> <!--DATE AND TIME-->
    <div id="clock"></div>
    <div id="calendar"></div>
  </div> <!--DATE AND TIME-->


  <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <img src="image/cicto_logo.png" alt="Company Logo">
            <h1>City Information and Communications Technology &nbsp; &nbsp;&nbsp;</h1>
            <br>
            <h1> JOB ORDER SLIP &nbsp; &nbsp;&nbsp;</h1>
           
        </div>
      <!--Back to home.php-->
<a href="../home.php" style="float: left; margin-left: 10px; margin-top: 0;">
  <button style="background-color:#AA0000; color: #fff; padding: 5px 5px; border: none; border-radius: 5px; cursor: pointer; font-size: 25pt; font-weight: bold;">
  &#8592; HOME
  </button>
</a>
<br>
  <form action="submit_ticket.php" method="post" autocomplete="off"  enctype="multipart/form-data">
  <p>Instructions: Please fill out and check the appropriate Box</p>

        <div class="form-group">
                <label for="serial_number">Item Serial No.</label>
                <input type="text" id="serial_number" name="serial_number" > <!-- serial_number -->
            </div>

          <div class="form-group">
                <label for="date_req">Date Requested</label>
                <input type="date" id="date_req" name="date_req" readonly> <!-- date requested -->
            </div>

          <div class="form-group">
                <label for="time_req">Time Requested</label>
                <input type="time" id="time_req" name="time_req" readonly> <!-- time_req -->
            </div>
          <div class="form-group">
                <label for="id_number">Employee ID</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo $id_number; ?>" readonly required> <!-- id_number -->
            </div>
          <div class="form-group">
                <label for="req_name">Requester Name</label>
                <input type="text" id="req_name" name="req_name" value="<?php echo $full_name; ?>" readonly required> <!-- ful name -->
            </div>
          <div class="form-group">
                <label for="office">Office</label>
                <input type="text" id="office" name="office" value="<?php echo $office; ?>" readonly required> <!-- office -->
            </div>
          <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" readonly required> <!-- phone_number -->
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" readonly required> <!-- email -->
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject"><!-- subject -->
            </div>
   
 <!-- Department and Barangay Selection -->
          
 <div class="form-group">
    <label for="unit">Select Device:</label>
    <div class="custom-select">
        <div class="select-box">
            <span class="select-text">Select Device</span>
            <input type="hidden" id="unit" name="unit">
        </div>
        <div class="options-container">
            <div class="option" data-value="laptop" data-image="laptop.png">
                <img src="image/2.jpg" alt="Laptop">
                <span>Laptop</span>
            </div>
            <div class="option" data-value="desktop" data-image="desktop.png">
                <img src="image/3.jpg" alt="Desktop">
                <span>Desktop</span>
            </div>
            <div class="option" data-value="tablet" data-image="tablet.png">
                <img src="image/4.jpg" alt="Tablet">
                <span>Tablet</span>
            </div>
            <div class="option" data-value="smartphone" data-image="smartphone.png">
                <img src="image/5.jpg" alt="Smartphone">
                <span>Smartphone</span>
            </div>
            <div class="option" data-value="other" data-image="other.png">
                <img src="image/other.png" alt="Other">
                <span>Other</span>
            </div>
        </div>
    </div>
</div>

<!-- Input field for "Other" device -->
<div class="form-group" id="other-device-container" style="display:none;">
    <label for="other_device">Please specify the device:</label>
    <input type="text" id="other_device" name="other_device" placeholder="Enter device type">
</div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" >
                    <option disabled selected> </option>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option><!-- category -->
                </select>
            </div>

            <br>
     <!-- Accessories Table -->
     <div class="form-group" >
             <!-- accessories -->
                <table>
                    <thead>
                        <tr>
                            <th>Accessory</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Charger</td>
                            <td><input type="checkbox" class="accessory-checkbox" name="accessories[]" value="charger"></td>
                        </tr>
                        <tr>
                            <td>Keyboard</td>
                            <td><input type="checkbox" class="accessory-checkbox" name="accessories[]" value="keyboard"></td>
                        </tr>
                        <tr>
                            <td>Mouse</td>
                            <td><input type="checkbox" class="accessory-checkbox" name="accessories[]" value="mouse"></td>
                        </tr>
                        <tr>
                            <td>USB Cable</td>
                            <td><input type="checkbox" class="accessory-checkbox" name="accessories[]" value="usb_cable"></td>
                        </tr>
                        <tr>
                <td>Other</td>
                <td>
                    <input type="checkbox" id="other-checkbox" class="accessory-checkbox" name="accessories[]" value="other">
                    
                </td>
            </tr>
                    </tbody>
                </table>
            </div>
            <input type="text" id="other-text" name="accessories[]" placeholder="Specify other accessory" style="display: none;">
 
<br>
<br>
<input type="file" name="image" accept="image/*" id="image" capture="camera"> </input>
<label for="image" id="choose-file-label">SEND THE PROBLEM USING PHOTO</label>
<img id="preview" src="" alt="Preview Image" style="max-width: 100%; height: auto; object-fit: contain;">

        <br>
        <br>
        <body>

 

        <br>
        <br>
            <button type="submit" name="submit" value="Upload">Save Record</button>
            <a href="../home.php" style="float: left; margin-left: 20px; margin-top: 0;">
  <button style=" padding: 5px 5px; border: none; border-radius: 5px; font-size: 18pt; font-weight: bold;">

  </button>
</a>
    </div>
    
</form>

  </div>
  <script>
    const dateReq = document.getElementById('date_req');
    const timeReq = document.getElementById('time_req');

    // Set date to today's date
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    dateReq.value = `${year}-${month}-${day}`;

    // Set time to current time
    const hours = String(today.getHours()).padStart(2, '0');
    const minutes = String(today.getMinutes()).padStart(2, '0');
    timeReq.value = `${hours}:${minutes}`;

    document.addEventListener('DOMContentLoaded', function() {
    const selectBox = document.querySelector('.select-box');
    const optionsContainer = document.querySelector('.options-container');
    const hiddenInput = document.getElementById('unit'); // Ensure hidden input is correctly referenced
    const otherDeviceContainer = document.getElementById('other-device-container');
    const otherDeviceInput = document.getElementById('other_device');

    selectBox.addEventListener('click', function() {
        optionsContainer.classList.toggle('visible');
    });

    optionsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('option')) {
            const value = event.target.getAttribute('data-value');
            hiddenInput.value = value; // Set hidden input value
            selectBox.querySelector('.select-text').textContent = event.target.querySelector('span').textContent;
            optionsContainer.classList.remove('visible');

            // Show "Other" device input if selected
            if (value === 'other') {
                otherDeviceContainer.style.display = 'block';
            } else {
                otherDeviceContainer.style.display = 'none';
                otherDeviceInput.value = ''; // Clear input if not "Other"
            }
        }
    });
        // Update the hidden input with the user's input when they type in the "Other" field
        otherDeviceInput.addEventListener('input', function() {
        hiddenInput.value = otherDeviceInput.value; // Set the hidden input to the user's input
    });
    // Update the hidden input (or accessories array) with the user's input if the checkbox is checked
    otherTextInput.addEventListener('input', function() {
        if (otherCheckbox.checked) {
            // Update the value of the "other" accessory to the user's input
            otherCheckbox.value = otherTextInput.value || 'other'; // Set to the user input or 'other' if empty
        }
    });
});



        const imageInput = document.getElementById('image');
  const previewImage = document.getElementById('preview');
  const chooseFileLabel = document.getElementById('choose-file-label');

  imageInput.addEventListener('change', (e) => {
    const file = imageInput.files[0];
    const reader = new FileReader();

    reader.onload = (event) => {
      previewImage.src = event.target.result;
    };

    reader.readAsDataURL(file);
  });

  chooseFileLabel.addEventListener('click', () => {
    if (navigator.userAgent.match(/Android|iPhone|iPod|iPad/i)) {
      // Mobile device, check if camera or file input is preferred
      if (confirm("Do you want to take a photo or select a file?")) {
        imageInput.setAttribute('capture', 'environment'); // Rear camera capture
      } else {
        imageInput.removeAttribute('capture'); // File picker
      }
    } else {
      // Desktop device, just trigger file input
      imageInput.removeAttribute('capture');
    }
    imageInput.click();
  });


  document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Gather form data

    // Send form data using fetch API
    fetch('submit_ticket.php', { // Adjust to your PHP file
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      const overlay = document.getElementById('overlay');
      const message = document.getElementById('message');

      // Show overlay with the message from the server
      message.textContent = data.message;
      overlay.style.display = 'flex'; // Show overlay

      if (data.success) {
        setTimeout(() => {
          window.location.href = '../home.php'; // Redirect to home page after 3 seconds
        }, 3000);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
  

  const otherCheckbox = document.getElementById('other-checkbox');
    const otherTextInput = document.getElementById('other-text');

    otherCheckbox.addEventListener('change', function() {
        if (otherCheckbox.checked) {
            otherTextInput.style.display = 'inline';
        } else {
            otherTextInput.style.display = 'none';
            otherTextInput.value = ''; // Clear the input if unchecked
        }
    });
  </script>
</body>
</html>
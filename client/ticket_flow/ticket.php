<?php
include 'user_data.php';

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">


  <title>Current Ticket</title>
  <style>
    body {
    font-family: Arial, sans-serif;
    font-size: 30pt;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    background-color: #030101;
}
html {
    touch-action: manipulation; /* Prevents double-tap zoom */
    -ms-touch-action: manipulation; /* For older IE/Edge */
  }

/* Container */
.container {
    width: 100%;
    padding: 0.5in; /* Padding for spacing */
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    border: 1px solid #000;
    margin: 0; /* Remove extra margins */
}

/* Header */
.header {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #000;
    padding: 5px 0; /* Reduced padding for header */
    margin-bottom: 10px; /* Margin between header and content */
    background-color: rgb(64, 188, 246);
}

.header img {
    width: 60px;
    height: auto;
    margin-right: 10px; /* Space between logo and text */
    margin-left: 10px; /* Space between logo and text */
}

.header h1 {
    margin: 0; /* Remove default margin */
    font-size: 15pt; /* Adjust font size for header */
    text-align: center;
}

/* Form Group */
.form-group {
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
    font-size: 18pt;
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

.options-container {
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

.options-container.visible {
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


   body {
      font-family: Arial, sans-serif;
      font-size: 16px; /* set a base font size */
      margin: 0;
      padding: 0;
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


    table {
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
    }
    button[type="submit"] {
      font-size: 15pt;
      font-weight: bold;
  margin-left: 200px;
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

.header {
    display: flex;
    align-items: center;  /* Vertically center content */
    justify-content: left;  /* Optional: align to left */
}

.header img {
    height: 50px; /* Optional: adjust image size */
    margin-right: 10px; /* Optional: space between image and text */
}

.header h1 {
    margin: 0;
    font-size: 12px; /* Optional: adjust font size */
}

  </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <!-- Overlay for success message -->
<div id="overlay">
    <div id="message"></div>
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
    <h1> JOB ORDER SLIP &nbsp; &nbsp;&nbsp;</h1>
</div>
<br>
      <!--Back to home.php-->
<a href="../home.php" style="float: left; margin-left: 10px; margin-top: 0;">
  <button style="background-color:#AA0000; color: #fff; padding: 5px 5px; border: none; border-radius: 5px; cursor: pointer; font-size: 15pt; font-weight: bold;">
  &#8592; HOME
  </button>
</a>
<br>
<br>
  <form action="" method="post" autocomplete="off"  enctype="multipart/form-data" required>
  <p style="font-size: 20pt;">Instructions: Please fill out and check the appropriate Box</p>

            
 <div class="form-group">
    <label for="unit">Select Device:<em style="color: red;"> *</em></label>
    <div class="custom-select" style="font-size: 19pt;">
        <div class="select-box">
            <span class="select-text">--Select Device--</span>
            <input type="hidden" id="unit" name="unit" required>
        </div>
        <div class="options-container">
            <div class="option" data-value="laptop"alt="Laptop">
                <span>Laptop</span>
            </div>
            <div class="option" data-value="desktop" alt="Desktop">
                <span>Desktop</span>
            </div>
            <div class="option" data-value="tablet"  alt="Tablet">
                <span>Tablet</span>
            </div>
            <div class="option" data-value="smartphone" alt="Smartphone">
                <span>Smartphone</span>
            </div>
            <div class="option" data-value="printer" alt="Printer">
                <span>Printer</span>
            </div>
            <div class="option" data-value="other" alt="Other">
                <span>Other</span>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Input field for "Other" device -->
<div class="form-group" id="other-device-container" style="display:none;">
    <label for="other_device">Please specify the device:</label>
    <input type="text" id="other_device" name="other_device" placeholder="Enter device type">
</div>

            <div class="form-group">
                <label for="category">Category:<em style="color: red;"> *</em></label>
                <select id="category" name="category" required>
                    <option disabled selected>--Select Category--</option>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option><!-- category -->
                </select>
            </div>

            <br>
     <!-- Accessories Table -->
     <div class="form-group" >
             <!-- accessories -->
                <table style="font-size: 19pt;">
                    <thead>
                        <tr>
                            <th style="font-size: 16pt;">Accessory<em style="color: red; font-size: 8pt;"> *</em></th>
                            <th style="font-size: 16pt;">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                            <td>None</td>
                            <td><input type="checkbox" class="accessory-checkbox" name="accessories[]" value="none"></td>
                        </tr>
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

        <div class="form-group">
                <label for="serial_number">Item Serial No.<em style="color: red;"> *</em></label>
                <input type="text" id="serial_number" name="serial_number"  required> <!-- serial_number -->
            </div>

          <div class="form-group">
                <label for="date_req">Date Requested<em style="color: red;"> *</em></label>
                <input type="date" id="date_req" name="date_req" readonly required> <!-- date requested -->
            </div>

          <div class="form-group">
                <label for="time_req">Time Requested<em style="color: red;"> *</em></label>
                <input type="time" id="time_req" name="time_req" readonly required> <!-- time_req -->
            </div>
          <div class="form-group">
                <label for="id_number">Employee ID<em style="color: red;"> *</em></label>
                <input type="text" id="id_number" name="id_number" value="<?php echo $id_number; ?>" readonly required> <!-- id_number -->
            </div>
          <div class="form-group">
                <label for="req_name">Requester Name<em style="color: red;"> *</em></label>
                <input type="text" id="req_name" name="req_name" value="<?php echo $full_name; ?>" readonly required> <!-- ful name -->
            </div>
          <div class="form-group">
                <label for="office">Office<em style="color: red;"> *</em></label>
                <input type="text" id="office" name="office" value="<?php echo $office; ?>" readonly required > <!-- office -->
            </div>
          <div class="form-group">
                <label for="phone_number">Phone Number:<em style="color: red;"> *</em></label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>" readonly required> <!-- phone_number -->
            </div>
            <div class="form-group">
                <label for="email">Email Address<em style="color: red;">*</em></label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" readonly required> <!-- email -->
            </div>
            <div class="form-group">
                <label for="subject">Problem Encountered<em style="color: red;"> *</em></label>
                <input type="text" id="subject" name="subject"  required><!-- subject -->
            </div>
   
 <!-- Department and Barangay Selection -->
<br>
<br>
 <label for="image" id="choose-file-label">CLICK HERE TO SEND THE PROBLEM USING PHOTO<em style="color: red;"> *</em></label>
<input type="file" name="image" id="image" accept="image/*" style="display:none;"><br>
<img id="preview" src="" alt="Preview Image" style="max-width: 100%; height: auto; object-fit: contain;" required>

        <br>
        <br>
        <body>

 

        <br>
        <br>
   
        <button type="submit" id="preview-button" style="background-color: rgb(21, 189, 6); color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 15pt; font-weight: bold; float: right;">
        Submit Ticket
    </button>
</form>

<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center; color:white; font-size:18px;">
    <p id="message">Processing...</p>
</div>
  </div>


  <script>
const imageInput = document.getElementById('image');
const previewImage = document.getElementById('preview');
const chooseFileLabel = document.getElementById('choose-file-label');

// When the label is clicked, show SweetAlert and prevent file picker from opening immediately
chooseFileLabel.addEventListener('click', (event) => {
  event.preventDefault();  // Prevent file picker from opening immediately

  // SweetAlert to inform user
  Swal.fire({
    title: 'Choose picture from your file manager',
    text: 'Please select an image from your FILE MANAGER to prevent errors.',
    icon: 'info',
    confirmButtonText: 'OK',
    willClose: () => {
      // After SweetAlert is closed, trigger file input manually
      imageInput.click(); // Open file picker
    }
  });
});

// When a file is selected, display the preview image
imageInput.addEventListener('change', (e) => {
  const file = imageInput.files[0];

  // Check if the file is an image
  if (file && file.type.startsWith('image/')) {
    const reader = new FileReader();

    reader.onload = (event) => {
      previewImage.src = event.target.result; // Set preview image source
    };

    reader.readAsDataURL(file);
  } else {
    alert('Please select a valid image file.');
    imageInput.value = ''; // Clear the input if not an image
    previewImage.src = ''; // Clear the preview
  }
});



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

    document.getElementById('preview-button').addEventListener('click', function(e) {
    e.preventDefault();  // Prevent immediate submission

    // Collect form data
    var device = document.getElementById('unit').value;
    var category = document.getElementById('category').value;
    var accessories = Array.from(document.querySelectorAll('.accessory-checkbox:checked')).map(checkbox => checkbox.value);
    var serialNumber = document.getElementById('serial_number').value;
    var dateRequested = document.getElementById('date_req').value;
    var timeRequested = document.getElementById('time_req').value;
    var employeeID = document.getElementById('id_number').value;
    var requesterName = document.getElementById('req_name').value;
    var office = document.getElementById('office').value;
    var phoneNumber = document.getElementById('phone_number').value;
    var email = document.getElementById('email').value;
    var subject = document.getElementById('subject').value;
    var image = document.getElementById('image').files[0];

    // If category is not selected, set it to an empty string
    category = (category === '--Select Category--' || category === '') ? '' : category;

    // Validation: check required fields
    var missingFields = [];

    if (!device.trim()) missingFields.push('Device');
    if (!category.trim()) missingFields.push('Category');
    if (accessories.length === 0) missingFields.push('Accessories');
    if (!serialNumber.trim()) missingFields.push('Serial Number');
    if (!dateRequested.trim()) missingFields.push('Date Requested');
    if (!timeRequested.trim()) missingFields.push('Time Requested');
    if (!employeeID.trim()) missingFields.push('Employee ID');
    if (!requesterName.trim()) missingFields.push('Requester Name');
    if (!office.trim()) missingFields.push('Office');
    if (!phoneNumber.trim()) missingFields.push('Phone Number');
    if (!email.trim()) missingFields.push('Email');
    if (!subject.trim()) missingFields.push('Problem Encountered');
    if (!image) missingFields.push('Image');

    if (missingFields.length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            html: 'Please fill in the following required fields:<br><ul style="text-align:left;">' + missingFields.map(field => `<li>${field}</li>`).join('') + '</ul>',
            showConfirmButton: true
        });
        return; // STOP showing the preview if missing
    }

    // If all fields are complete, continue to show preview
    var previewContent = `
        <p><strong>Device:</strong> ${device}</p>
        <p><strong>Category:</strong> ${category}</p>
        <p><strong>Accessories:</strong> ${accessories.join(', ')}</p>
        <p><strong>Serial Number:</strong> ${serialNumber}</p>
        <p><strong>Date Requested:</strong> ${dateRequested}</p>
        <p><strong>Time Requested:</strong> ${timeRequested}</p>
        <p><strong>Employee ID:</strong> ${employeeID}</p>
        <p><strong>Requester Name:</strong> ${requesterName}</p>
        <p><strong>Office:</strong> ${office}</p>
        <p><strong>Phone Number:</strong> ${phoneNumber}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Problem Encountered:</strong> ${subject}</p>
        ${image ? `<p><strong>Image:</strong> <img src="${URL.createObjectURL(image)}" style="max-width: 100px;"></p>` : ''}
    `;

    // Insert preview into the message section
    document.getElementById('message').innerHTML = previewContent + `
        <button type="button" id="confirm-submit" style="background-color: green; color: white; padding: 5px 15px; margin-top: 10px;">Confirm and Submit</button>
        <button type="button" id="cancel-submit" style="background-color: red; color: white; padding: 5px 15px; margin-top: 10px;">Cancel</button>
    `;

    // Show the overlay
    document.getElementById('overlay').style.display = 'flex';

    // Handle the Cancel button
    document.getElementById('cancel-submit').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none';
    });

    // Handle the Confirm and Submit button
    document.getElementById('confirm-submit').addEventListener('click', function() {
        document.getElementById('confirm-submit').disabled = true;
        document.getElementById('confirm-submit').textContent = 'Submitting...';

    Swal.fire({
        title: 'Please Standby',
        text: 'Ticket is being submitted...',
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();  // Show loading animation
        }
    });
    
        document.querySelector('form').dispatchEvent(new Event('submit'));
    });
});


// Submit Function
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Gather form data

    // Show loading message before sending the ticket
    Swal.fire({
        title: 'Please Standby',
        text: 'Ticket is being submitted...',
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();  // Show loading spinner
        }
    });

    // Send form data using fetch API
    fetch('submit_ticket.php', { // Adjust to your PHP file
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Close the SweetAlert loading spinner
            Swal.close();

            if (data.success) {
                // Show a success message when the ticket is submitted
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket Submitted Successfully!',
                    text: 'Your ticket has been submitted and is now being processed.',
                });

                // Redirect to home page after 3 seconds
                setTimeout(() => {
                    window.location.href = '../home.php'; // Redirect to home page
                }, 3000);
            } else {
                // Show an error message if submission failed
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: `Error: ${data.message}`,
                });

                // Re-enable the button if submission fails
                const submitButton = document.querySelector('#confirm-submit');
                submitButton.disabled = false;
                submitButton.textContent = 'Send Ticket'; // Reset button text
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Close the loading spinner
            Swal.close();

            // Show an error message if there was an issue with the request
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed',
                text: 'An error occurred while submitting your ticket. Please try again later.',
            });

            // Re-enable the button in case of an error
            const submitButton = document.querySelector('#confirm-submit');
            submitButton.disabled = false;
            submitButton.textContent = 'Send Ticket'; // Reset button text
        });
});


  </script>
</body>
</html>
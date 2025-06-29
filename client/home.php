<?php
include("database/user_data.php"); 

if (isset($_GET['url'])) {
  $url = $_GET['url'];
  header('Location: ' . $url);
  exit;
}

  ?>


<!DOCTYPE html>
<html>
<head>


  <title>Employee Dashboard</title>
  <style>
    html {
  touch-action: manipulation; /* Prevents double-tap zoom */
  -ms-touch-action: manipulation; /* For older IE/Edge */
}
    body {
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color:rgb(255, 255, 255); /* Replace with your desired background color */
    flex-direction: column;
    background:rgb(255, 255, 255);
    position: relative;
    overflow: auto;
    }
    
    @media only screen and (max-device-width: 768px) and (-webkit-device-pixel-ratio: 1.5) {
      /* styles for Android devices here */
      .container {
        width: 30em; /* adjust to your desired width in ems */
        height: 50em; /* adjust to your desired height in ems */
      }
    }
    .container {
      background-image: linear-gradient( 105.9deg,  rgba(0,122,184,1) 24.4%, rgba(46,0,184,0.88) 80.5% );
      border-radius: 10px;
      padding: 30px;
      text-align: center;
      height: 800px;
      width: 480px;
    }
    .profile-icon img{
    width: 100px;
    height: 100px;
   position: center;
   border-radius: 50%;
    }
    .background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #21D4FD;
    background-image: linear-gradient( 105.9deg,  rgba(0,122,184,1) 24.4%, rgba(46,0,184,0.88) 80.5% );
    filter: blur(8px);
    z-index: -2;
}
.user-header {
background: white;
  padding: 15px 20px;
  border-radius: 20px;
  box-shadow: 
    0 4px 6px rgba(0, 0, 0, 0.1),
    0 10px 15px rgba(0, 0, 0, 0.15),
    0 20px 25px rgba(0, 0, 0, 0.05);
  text-align: center;
  margin: 15px;
  max-width: 100%;
  overflow-wrap: break-word;
}
.tips-guides {
background: white;
  padding: 15px 20px;
  border-radius: 20px;
  box-shadow: 
    0 4px 6px rgba(0, 0, 0, 0.1),
    0 10px 15px rgba(0, 0, 0, 0.15),
    0 20px 25px rgba(0, 0, 0, 0.05);
  text-align: center;
  max-width: 100%;
  height: 200px;
  overflow-wrap: break-word;
  margin-bottom: 20px;
}

#username {
  font-size: 40px;
  font-weight: 600;
  color: #333;
  margin: 0;
  word-wrap: break-word;
  text-shadow: 
  1px 1px 0 #999,
    2px 2px 0 #aaa,
    3px 3px 0 #bbb,
    4px 4px 0 #ccc,
    5px 5px 0 #ddd;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #21D4FD;
    background-image: linear-gradient( 105.9deg,  rgba(0,122,184,1) 24.4%, rgba(46,0,184,0.88) 80.5% );
    z-index: -1;
}
.image-container {
  position: relative;
  width: 100%;
  height: 0;
  padding-bottom: 56.25%; /* Aspect ratio for 16:9 image */
  overflow: hidden;
  margin-bottom: 30px;
}

.image-container img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50px;
  object-fit: cover;
}

.image-tip {
  position: absolute;
  bottom: 10px;
  left: 10px;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
  
}
.confirm-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
}

.confirm-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.confirm-content button {
  margin: 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 10px;
  background-color: #4CAF50;
  color: #fff;
  cursor: pointer;
}

.confirm-content button:hover {
  background-color: #3e8e41;
}
.options {
  margin-left: -20px;
  width: 500px;
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  animation: fadeIn 2s ease-in-out;
  padding: 10px; /* Add some padding inside the border */
  margin: 0;
  text-shadow: 
  1px 1px 0 #aaa,
    2px 2px 0 #ccc,
    3px 3px 0 #eee;

}

@keyframes fadeIn {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.options .item {
  background: white;
  width: 130px; /* adjust the width to your liking */
  height: 120px;
  background-size: cover;
  background-position: center;
  padding: 20px; /* add some padding to make room for the button */
  border-color: #000; /* sets the border color to a light gray */
  border-style: solid; /* sets the border style to solid */
  border-width: 5px; /* sets the border width to 1 pixel */
  border-radius: 30px;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* add a transition effect to the transform and box-shadow properties */
  -webkit-transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* for Chrome and Safari */
  -moz-transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* for Firefox */
  -o-transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* for Opera */
  box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
  
}

.options .item:hover {
  transform: translateY(-5px); /* move the item up by 5 pixels on hover */
  background-color: rgba(255, 255, 255, 0.2); /* add a white glow effect to the background */
  box-shadow: none; /* remove the box shadow to focus on the background glow */
}

.options .item:active {
  transform: translateY(5px); /* move the item down by 5 pixels on click */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* add a darker box shadow on click */
}
.options .item img {
  width: 50px; /* adjust the width and height to your desired values */
  height: 50px;
  margin-bottom: 5px; /* add some space between the image and description */
  
}

.options .item span {
  vertical-align: middle; /* align the description text with the image */
   font-weight: bold; /* make the description text bold */
  display: block; /* make the description text display as a block element */
  
}

.options .item a {
  text-decoration: none; /* remove the underline from the link */
  color: #333; /* set the text color to a dark gray */
}

.options .item a:hover {
  color: #45a049; /* set the text color to a darker green on hover */
}
.options button {
  display: block;
  width: 200px;
  padding: 15px;
  margin: 10px auto;
  background-color: #4CAF50; /* Green */
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

.options button:hover {
  background-color: #45a049; /* Darker green on hover */
}


.logout button {
  background-color: #f44336; /* Red */
  color: #fff; /* White text */
  padding: 5px 10px; /* Add some padding to make the button larger */
  border: none; /* Remove the default border */
  border-radius: 5px; /* Add a subtle curve to the button */
  cursor: pointer; /* Change the cursor to a hand pointer on hover */
  margin-top: 30%;
  font-size: 14px; /* Increase the font size for better readability */
  font-weight: bold; /* Make the text bold */
  transition: background-color 0.2s ease-in-out; /* Add a smooth transition effect on hover */
  border-radius: 10px;
}

.logout button:hover {
  background-color: #d32f2f; /* Darker red on hover */
}

.logout button:active {
  background-color: #b71c1c; /* Even darker red on click */
  transform: translateY(2px); /* Move the button down slightly on click */
}




/* For screens with a maximum width of 768px (e.g. tablets and smaller laptops) */
@media only screen and (max-width: 768px) {
  /* Adjust styles here */
  *{
  
  }
  .container {
    height: 100%;
    width: 90%; /* adjust to your desired width */
    
  }
  .options {
    margin: 0;
    display: flex; 
   animation: fadeIn 2s ease-in-out;
  }
  .options .item {
    width: 100px; /* adjust the width to your liking */
    height: 120px;
    margin-bottom: 15px; /* add some space between items */
  }
  .options .item img {
  width: 30px; /* adjust the width and height to your desired values */
  height: 30px;
  margin-bottom: 5px; /* add some space between the image and description */
  
}

}

/* For screens with a maximum width of 480px (e.g. smartphones) */
@media only screen and (max-width: 480px) {
  /* Adjust styles here */
  *{

  }
  .container {

    height: 100%;
    width: 100%; /* adjust to your desired width */
   
  }
  .options {
   width: 100%;
   display: flex; 
   animation: fadeIn 2s ease-in-out;
  }
  .options .item {
    width: 100px; /* adjust the width to your liking */
    height: 120px;
    margin-bottom: 15px; /* add some space between items */
    
  }
  .image-container {
    width: 100%; /* make image container full-width */
  }
  .image-container img {
    width: 100%; /* make image full-width */
  }
  .options .item img {
  width: 30px; /* adjust the width and height to your desired values */
  height: 30px;
  margin-bottom: 5px; /* add some space between the image and description */
}
}
        /* Style for the notification bell */
        .notification-bell {
            position: fixed;
            top: 50px;
            right: 50px;
            font-size: 24px;
            background-color:rgb(255, 255, 255);
            color: white;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index:7;
        }

        /* Style for the overlay */
        .notification-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 5;
        }
/* Badge for unread notifications */
.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    text-align: center;
    line-height: 20px;
    z-index: 9;
    
}

/* Show the badge if there are unread notifications */
.notification-badge.show {
    display: block;
}
        .notification-list {
            position: fixed;
            top: 50px;
            right: 45px;
            background-color: white;
            width: 300px;
          display: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 15px;
            overflow-y: auto;
            z-index:6;
        }

        .notification-list h3 {
            margin-top: 0;
        }

        .notification-item {
            background: #ecf0f1;
            border: 1px solid #bdc3c7;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .notification-item.unread {
    background-color: #fce8e8;
    border-color: #f39c12;
    font-weight: bold;
}
        .notification-overlay.show, .notification-list.show {
            display: block;
        }


  </style>

<script src="loading.js" defer></script>


</head>
<body>

<?php include_once 'loading.php'; ?>

<div class="notification-bell" onclick="toggleNotification()">
    🔔
    <span class="notification-badge" id="notificationBadge" style="display:none;"></span>
</div>

<!-- Notification Overlay & List -->
<div class="notification-overlay" id="notificationOverlay" onclick="toggleNotification()"></div>
<div class="notification-list" id="notificationList">
    <h3>Notifications</h3>
    <div id="notificationItems">
        <!-- Notifications from database will appear here -->
    </div>
</div>

  <div class="container">

 

  <div class="profile-icon">

  <img src="images/cicto_logo.png" alt="Profile Icon"> 
</div>

<div class="user-header">
  <h1 id="username"><?php echo $full_name; ?></h1>
</div>
<div class="tips-guides">
<h2 id="showTips" style="cursor: pointer; text-decoration: underline; color: blue; font-size: 18pt; margin: 0;">TIPS AND GUIDES</h2>

<div class="text-container">
    <div id="textTip" class="text-tip" style="font-size: 16px; text-align: center; padding: 20px;"></div>
</div>
</div>

  <div class="options">
  <div class="item">
    <a href="ticket_flow/ticket.php">
      <img src="images/profile/send_ticket.png" alt="Request a Ticket">
      <span style="display:block; font-weight:bold;text-align: center;">Request</span>
    </a>
  </div>
  <div class="item">
    <a href="history/history.php">
      <img src="images/profile/history.png" alt="History">
      <span style="display:block; font-weight:bold;text-align: center; font-size: 10pt;">Resolved Tickets</span>
    </a>
  </div>
  <div class="item">
    <a href="myticket/myticket.php">
      <img src="images/profile/my_ticket.png" alt="My Ticket">
      <span style="display:block; font-weight:bold;text-align: center;">My Ticket</span>
    </a>
  </div>
</div>

<div class="logout">
  <a href="#" id="logout-link">
    <button>Log Out</button>
  </a>
  <div class="confirm-overlay" id="confirm-overlay">
    <div class="confirm-content">
      <p>Are you sure you want to log out?</p>
      <button id="confirm-yes">Yes</button>
      <button id="confirm-no">No</button>
    </div>
  </div>
</div>


  </div>
</body>
<div class="background-image"></div>
    <div class="overlay"></div>
    <?php include_once 'chatbot2.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function toggleNotification() {
            document.getElementById('notificationOverlay').classList.toggle('show');
            document.getElementById('notificationList').classList.toggle('show');
        }


function loadContent(url) {      ///no cache function
    $.ajax({
        url: url,
        cache: false,
        headers: {
            'Cache-Control': 'no-cache',
            'Pragma': 'no-cache'
        },
        success: function(data) {
            console.log('Loaded content:', data);
            $('#content-loader').html(data);
            window.location.hash = url;
          
        }
    });
}

  // Array of text tips about computer technical issues
  var tips = [
    "Check cables: Make sure cables are plugged in and not broken.",
  "Restart: Restart your computer to fix many problems.",
  "Update drivers: Keep your drivers up-to-date for better performance.",
  "Clear cache: If your browser is slow, clear its cache.",
  "Turn it off: If your computer is slow, turn it off for a few minutes and then turn it back on.",
  "Save your work: Always save your work by clicking the save button or pressing Ctrl + S.",
  "Close programs: Close programs you’re not using to make the computer run faster.",
  "Ask for help: If something goes wrong, ask someone for help. It's okay to ask questions."
  ];

  var tipIndex = 0; // Keeps track of which tip to show
  var tipElement = document.getElementById("textTip");

  // Function to change the text tip
  function changeTip() {
    tipElement.innerHTML = tips[tipIndex]; // Display the current tip
    tipIndex = (tipIndex + 1) % tips.length; // Move to the next tip, loop back after the last one
  }

  // Change the tip every 5 seconds
  setInterval(changeTip, 5000); 

  // Initial display of the first tip
  changeTip();

document.getElementById("showTips").addEventListener("click", function () {
    const tipsHtml = tips.map((tip, index) => `<li>${tip}</li>`).join('');
    Swal.fire({
      title: 'All Tips and Guides',
      html: `<ul style="text-align: left; padding-left: 20px;">${tipsHtml}</ul>`,
      icon: 'info',
      width: 600,
      confirmButtonText: 'Close'
    });
  });

const logoutLink = document.getElementById('logout-link');
const confirmOverlay = document.getElementById('confirm-overlay');
const confirmYesBtn = document.getElementById('confirm-yes');
const confirmNoBtn = document.getElementById('confirm-no');

logoutLink.addEventListener('click', (e) => {
  e.preventDefault();
  confirmOverlay.style.display = 'block';
});

confirmYesBtn.addEventListener('click', () => {
  window.location.href = 'user_log_out.php';
  confirmOverlay.style.display = 'none';
});

confirmNoBtn.addEventListener('click', () => {
  confirmOverlay.style.display = 'none';
});
function fetchNotifications() {
    fetch('notification/get_notifications.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            const notificationItems = document.getElementById('notificationItems');

            // Clear existing notifications
            notificationItems.innerHTML = '';

            if (data.length > 0) {
                badge.textContent = data.length;
                badge.style.display = 'block';

                data.forEach(notification => {
                    const div = document.createElement('div');
                    div.classList.add('notification-item');
                    div.innerHTML = `
                        <a href="myticket/myticket.php" style="text-decoration: none; color: inherit;">
                            Your ticket <strong>#${notification.ticket_number}</strong> is <strong>${notification.status}</strong>
                        </a>
                    `;
                    // When user clicks the notification, mark as read
                    div.addEventListener('click', function() {
                        markAsRead(notification.ticket_number); // Pass ticket_number, not notification.id
                        div.remove(); // Remove it from the list
                    });

                    notificationItems.appendChild(div);
                });

            } else {
                badge.style.display = 'none';
                notificationItems.innerHTML = '<div class="notification-item">No new notifications</div>';
            }
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        });
}

function markAsRead(ticketId) {
    fetch('notification/mark_notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ticket_number=' + ticketId // Use ticket_number here
    })
    .then(response => response.text())
    .then(data => {
        console.log('Notification marked as read:', data);
        fetchNotifications(); // Refresh notification list
    });
}


// Toggle notification overlay
function toggleNotification() {
    document.getElementById('notificationOverlay').classList.toggle('show');
    document.getElementById('notificationList').classList.toggle('show');
}

// Fetch notifications every 5 seconds
setInterval(fetchNotifications, 5000);
fetchNotifications(); // Also call once immediately

</script>
</html>
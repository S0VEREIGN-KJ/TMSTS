<!-- From Uiverse.io by PriyanshuGupta28 --> 
<div id="loadingOverlay">
<div class="spinner">
  <div></div>   
  <div></div>    
  <div></div>    
  <div></div>    
  <div></div>    
  <div></div>    
  <div></div>    
  <div></div>    
  <div></div>    
  <div></div>    
</div>
</div>

<style>
    /* From Uiverse.io by PriyanshuGupta28 */ 
     /* Loading overlay */
     #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 100%;
        height: 100%;
        display: flex; /* Center the content */
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        z-index: 9999999; /* Ensure it's on top of other content */
        transition: opacity 0.5s ease;
        opacity: 1;
        background-color: rgba(255, 255, 255, 0.3); /* Light transparent overlay */
    backdrop-filter: blur(5px); /* Apply blur effect */
    -webkit-backdrop-filter: blur(5px); /* For Safari support */
    }
.spinner {
  position: absolute;
  width: 9px;
  height: 9px;
}

.spinner div {
  position: absolute;
  width: 50%;
  height: 150%;
  background: #000000;
  transform: rotate(calc(var(--rotation) * 1deg)) translate(0, calc(var(--translation) * 1%));
  animation: spinner-fzua35 1s calc(var(--delay) * 1s) infinite ease;
}

.spinner div:nth-child(1) {
  --delay: 0.1;
  --rotation: 36;
  --translation: 150;
}

.spinner div:nth-child(2) {
  --delay: 0.2;
  --rotation: 72;
  --translation: 150;
}

.spinner div:nth-child(3) {
  --delay: 0.3;
  --rotation: 108;
  --translation: 150;
}

.spinner div:nth-child(4) {
  --delay: 0.4;
  --rotation: 144;
  --translation: 150;
}

.spinner div:nth-child(5) {
  --delay: 0.5;
  --rotation: 180;
  --translation: 150;
}

.spinner div:nth-child(6) {
  --delay: 0.6;
  --rotation: 216;
  --translation: 150;
}

.spinner div:nth-child(7) {
  --delay: 0.7;
  --rotation: 252;
  --translation: 150;
}

.spinner div:nth-child(8) {
  --delay: 0.8;
  --rotation: 288;
  --translation: 150;
}

.spinner div:nth-child(9) {
  --delay: 0.9;
  --rotation: 324;
  --translation: 150;
}

.spinner div:nth-child(10) {
  --delay: 1;
  --rotation: 360;
  --translation: 150;
}

@keyframes spinner-fzua35 {
  0%, 10%, 20%, 30%, 50%, 60%, 70%, 80%, 90%, 100% {
    transform: rotate(calc(var(--rotation) * 1deg)) translate(0, calc(var(--translation) * 1%));
  }

  50% {
    transform: rotate(calc(var(--rotation) * 1deg)) translate(0, calc(var(--translation) * 1.5%));
  }
}
    </style>

    <script>
        // script.js
document.addEventListener("DOMContentLoaded", function() {
    const loadingOverlay = document.getElementById("loadingOverlay");

    // Function to show the loading overlay
    function showLoading() {
        loadingOverlay.style.display = "flex"; // Use flex to center the message
    }

    // Function to hide the loading overlay
    function hideLoading() {
        loadingOverlay.style.display = "none";
    }

    // Simulate loading process
    showLoading(); // Show overlay when loading starts

    // Simulate a loading delay (e.g., fetching data)
    setTimeout(() => {
        hideLoading(); // Hide overlay after loading is complete
    }, 1000); // Change this duration as needed
});
</script>
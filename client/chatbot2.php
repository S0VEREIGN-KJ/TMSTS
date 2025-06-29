<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"> <!-- Google Fonts Link for Icons -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
        * {
     
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        html {
            touch-action: manipulation;
            -ms-touch-action: manipulation; 
        }
        body {
            background: #E3F2FD;
        }
        @keyframes popInOut {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.-); } 
        }
        @keyframes popEffect {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
 .chatbot-toggler{
    overflow: auto;
  position: absolute;
  right: 770px;
  bottom: 200px;
  height: 70px;
  width: 70px;
  color: #fff;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  outline: none;
  cursor: pointer;
  background: #724ae8;
  border-radius: 50%;
  transition: all 0.2s ease;
  z-index: 2;

  /* White circle around the button */
  box-shadow: 0 0 0 8px white;
}
.chatbot-toggler img.toggler-img {
            width: 70px; 
            height: 70px;
            object-fit: contain;
            transition: transform 0.2s ease;
        }
.show-chatbot .chatbot-toggler{
    transform: rotate(90deg);
}
.chatbot-toggler span{
    position: absolute;
}
.show-chatbot .chatbot-toggler span:first-child,
.chatbot-toggler span:last-child{
    opacity: 0;
}
.show-chatbot .chatbot-toggler span:last-child{
    opacity: 1;
}
        .chatbot{
            overflow-x: hidden;
            position: fixed;
    right: 750px;
    bottom: 200px;
    width: 350px;
    height: 650px;
            max-height: 740px;
            height: 700px;
            transform: scale(0.5);
            opacity: 0;
            pointer-events: none;
            overflow: hidden;
            background: #fff;
            border-radius: 15px;
            transform-origin: bottom right;
            box-shadow: 0 0 128 px 0 rgba(0,0,0,0.1),
                        0 32px 64px -48px rgba(0,0,0,0.5);
            transition: all 0.1s ease;
            z-index: 999;
            border: 2px solid rgb(0, 0, 0);
        }

        .show-chatbot .chatbot{
            transform: scale(1);
            opacity: 1;
            pointer-events: auto;
        }
        .chatbot header{
            color: white;
            background:rgb(0, 0, 0);
            padding: 10px;
            text-align: center;
            display: flex;
            height: 90px;
        }
        .chatbot header h2 {
            color: #FFFFFF;
            font-size: 1.2rem;
        }
        .chatbot header span {
            position: absolute;
            right: 30px;
            top: 6%;
            color: #FFFFFF;
            cursor: pointer;
            display: block;
            transform: translateY(-50%);
        }
        .header-text-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center; 
        }
        .header-text {
            font-size: 12px; 
            font-weight: bold;
            color: white;
            margin: 0; 
        }
        .header-text2 {
            font-size: 30px; 
            font-weight: bold;
            color: white;
            margin: 0; 
            margin-left: 25px;
            text-align: left;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: -20px; 
            left: 0;
            width: 100%;
            height: 40px; 
            background: #4CC9FE; 
            border-radius: 50% 50% 0 0;
        }
        .chatbot .chatbox {
            overflow-x: hidden;
            height: 610px;
            overflow-y: auto;
            padding: 30px 20px 100px;
        }
        .chatbot .chat {
            display: flex;
        }
        .chatbot .incoming span{
            height: 32px;
            width: 32px;
            color: #fff;
            align-self: flex-end;
            background: #4CC9FE;
            text-align:center;
            line-height: 32px;
            border-radius: 4px;
            margin: 0 10px 0;
        }
        .chatbot .outgoing {
            margin: 20px 0;
            justify-content: flex-end;
            position: relative;
        }
        .chatbot .outgoing p {
            margin-top: 30px;
            font-weight: bold;
            position: relative;
            color: black;
            max-width: 75%;
            font-size: 0.95rem;
            white-space: pre-wrap;
            background: #4CC9FE;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chatbot .outgoing p::before {
            content: "";
            position: absolute;
            top: 0;
            right: -10px;
            width: 0;
            height: 0;
            border-bottom: 10px solid transparent;
            border-left: 10px solid #4CC9FE;
        }
        .chatbot .chat p {
            max-width: 75%;
            font-size: 0.95rem;
            white-space: pre-wrap;
            padding: 12px 16px;
            border-radius: 10px 0 10px 10px;
            background: linear-gradient(to right, #4CC9FE, #12D8FA,  #4CC9FE, #12D8FA);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chatbot .chat p.error {
        color: #721c24;
            background: #f8d7da;
        }
        .chatbot .incoming p {
            color: white;
            margin-top: 10px;
            position: relative;
            color: #000;
            background:rgb(255, 255, 255);
            border: 1px solid black;
            border-radius: 0 10px 10px 10px;
            width: 360px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chatbot .incoming p::before {
            content: "";
            position: absolute;
            top: -1px;
            left: -10px;
            width: 0;
            height: 0;
            border-bottom: 10px solid transparent;
            border-right: 10px solid rgb(0, 0, 0);
        }
        .chatbot .chat-input{
            position: absolute;
            bottom: 0;
            width: 100%;
            display: flex;
            gap: 5px;
            background: #fff;
            align-items: flex-end;
            padding: 5px 20px;
            border-top: 1px solid #ccc;
        } 
        .chat-input textarea {
            height: 55px;
            width: 100%;
            max-height: 180px;
            overflow: hidden;
            border: none;
            outline: none;
            font-size: 0.95rem;
            resize: none;
            padding: 16px 15px 16px 0;
        }
        .chat-input span{
            align-self: flex-end;
            height: 55px;
            line-height: 55px;
            color:rgba(58, 0, 231, 0.9);
            font-size: 1.35em;
            cursor: pointer;
            visibility: hidden;
        }
        .chat-input textarea:valid ~ span{
            visibility: visible;
        }
        .chat .dialog-options {
            display: flex;
            gap: 5px;
            padding: 5px;
            background: #fff;
            flex-wrap: wrap;
            justify-content: center;
            bottom: 0;
            width: 100%;
        }
        .chat .dialog-options button {
            color: black;
            background: linear-gradient(to right, #4CC9FE, #12D8FA,  #4CC9FE, #12D8FA);
            border-radius: 25px;
            padding: 8px 12px;
            cursor: pointer;
        }
        .chat .dialog-options button:hover {
            background: rgb(118, 191, 223);
        }
        .chat-icon{
            min-width: 40px; 
            display: flex;
            justify-content: center;
        }
        .chat-icon img {
            width: 30px;
            height: 30px; 
            margin-left: -10px;
            object-fit: contain;
        }
        .header-icon-wrapper {
            width: 75px; 
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white; 
            border: 2px solid rgb(255, 255, 255); 
            border-radius: 50%;
        }
        .header-icon {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .chatbot header .minimize-btn {
            margin: 0;
            right: 70px; 
            top: 20px;
        }
        .minimize-btn:hover {
            color: #ff9800;
        }
        .chatbot header .close-btn {
            top: 27px;

            margin-left: 20px;
            font-family: 'Material Symbols Outlined', sans-serif;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
            padding: 5px;
            border-radius: 50%;
        }
        .send-btn {
            font-size: 55;
        }
        .close-btn:hover {
            color: #ff3b30; 
        }
        .close-btn:active {
            color: #d32f2f; 
        }
        
 @keyframes scroll_4013 {
    0% {
        transform: translateY(40%);
    }
    50% {
        transform: translateY(90%);
    }
    100% {
        transform: translateY(40%);
    }
}
        .element {
            animation: scroll_4013 3s ease-in-out infinite;
        }
        .chatbox::-webkit-scrollbar {
            width: 5px; 
            height: 10px; 
        }
        .chatbox::-webkit-scrollbar-thumb {
            background-color: rgb(60, 62, 77); 
            border-radius: 10px; 
            box-shadow: 0px 0px 10px rgb(43, 45, 54); 
        }
        .chatbox::-webkit-scrollbar-thumb:hover {
            background-color: rgb(51, 52, 56); 
        }
        .chatbox::-webkit-scrollbar-track {
            background-color: rgba(105, 127, 255, 0.2); 
            border-radius: 10px; 
        }
        .chatbox::-webkit-scrollbar-track-piece {
            background-color: transparent; 
        }
        .custom-shape-divider-bottom-1743647769 {
            position: absolute;
            display: block;
            left: 0;
            width: 350px;
            overflow: hidden;
            z-index: 999;

        }
        .custom-shape-divider-bottom-1743647769 svg {
            position: relative;
            display: block;
            width: calc(179% + 1.3px);
            height: 30px;
            transform: rotateY(180deg);
            z-index: 999;
        }
        .custom-shape-divider-bottom-1743647769 .shape-fill {
            fill:rgb(0, 0, 0) ; 
            z-index: 999;
        }
        #send-btn {
        font-size: 32px;
        }

        .chatbot.minimized {
            height: 0;
    overflow: hidden;
    opacity: 0;
    transform: scaleX(0);
    transform-origin: left right;
    transition: all 0.3s ease;
        }
        .chatbox .chat.incoming.previous-dialog {
    width: 350px;
    max-width: 100%; /* Ensures it doesn't overflow on small screens */
}

@media (max-width: 768px) {
    .chatbot-toggler {
        right: 10%;
        bottom: 10%;
   
    }
    .chatbot {
        top: 10px;
        right: 10px;
        bottom: 5%;
    }
    .alert-mark{
        top: 75%;
        left: 80%;
        font-size: 40px;
        color: #ff0000; /* red color */
        font-weight: bold;  
    }
}

@media (max-width: 480px) {

    .chatbot-toggler {
        margin-top: 20px;
        right: 10%;
        bottom: 12%;
    }
    .chatbot {
        top: 10px;
        right: 10px;
        bottom: 5%;
    }
}

    </style>
</head>

<body>

        <button class="chatbot-toggler">
            <img class="toggler-img" src="images/cicto_logo.png" alt="Chatbot Toggler">
        </button>

        <ul class="chatbot">
            <header>
                <div class="header-icon-wrapper">
                    <img class="header-icon" src="images/cicto_logo.png" alt="Header Icon">
                </div>

                <div class="header-text-wrapper">
                <p class="header-text2">CHATBOT</p>
                    <p class="header-text">City Information Communication Technology Office</p>
               
                </div>
                
                <span class="close-btn material-symbols-outlined">close</span>

                <span class="minimize-btn material-symbols-outlined">minimize</span>
            
            </header>
            <div class="custom-shape-divider-bottom-1743647769">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                    <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
                </svg>
            </div>
            <ul div class="chatbox">        
        </ul>
                
        <div class="chat-input">
            <textarea placeholder="Enter a message..." required></textarea>
            <span id="send-btn" class="material-symbols-outlined">send</span>
            

    </div>
    <div class="dialog-options" style="display: none; height: 0%; overflow: hidden;"></div>

</body>

<script>
    const chatInput = document.querySelector(".chat-input textarea");
    const sendChatBtn = document.querySelector(".chat-input span");
    const chatbox = document.querySelector('.chatbox');
    const dialogOptions = document.querySelector('.dialog-options');
    const chatbotToggler = document.querySelector(".chatbot-toggler");
    const chatbotCloseBtn = document.querySelector(".close-btn");
    const chatTextarea = document.querySelector(".chat-input textarea");
    const minimizeBtn = document.querySelector('.minimize-btn');
const chatbot = document.querySelector('.chatbot');

let isMinimized = false;

const createChatLi = (message, className) => {
//Create a chat <li> element with passed message and className
const chatLi = document.createElement("li");
chatLi.classList.add("chat", className);
let chatContent = className === "outgoing" ? `<p>${message}</p>` : `<span class="material-symbols-outlined">smart_toy</span><p>${message}</p>`;
chatLi.innerHTML = chatContent;
chatLi.querySelector("p").textContent = message;
return chatLi;
}
const dialogFlow = {
    start: {
        message: "Hello! I'm here to help with any computer issues you're facing. What can I assist you with?",
        options: [
            { label: "Fix a slow computer", next: "slow_computer" },
            { label: "Internet connection issues", next: "internet" },
            { label: "Software not responding", next: "software_not_responding" },
            { label: "Can't find a file", next: "file_not_found" }
        ]
    },
    slow_computer: {
        message: "Your computer might be running slow for a few reasons. Let's try some simple fixes:",
        options: [
            { label: "Close unused programs", next: "close_programs" },
            { label: "Clear temporary files", next: "clear_files" },
            { label: "Restart your computer", next: "restart_computer" }
        ]
    },
    close_programs: {
        message: "Try closing any programs you're not actively using. You can open the Task Manager (Ctrl+Shift+Esc) to end unnecessary tasks.",
        options: [
            { label: "Try clearing temporary files", next: "clear_files" },
            { label: "Restart your computer", next: "restart_computer" },
            { label: "Go back to start", next: "start" }
        ]
    },
    clear_files: {
        message: "Clear out unnecessary files by running the Disk Cleanup tool. It can help free up space and speed up your system.",
        options: [
            { label: "Close unused programs", next: "close_programs" },
            { label: "Restart your computer", next: "restart_computer" },
            { label: "Go back to start", next: "start" }
        ]
    },
    restart_computer: {
        message: "Sometimes a simple restart helps reset everything and clears up temporary glitches. Try restarting your computer.",
        options: [
            { label: "Try closing unused programs", next: "close_programs" },
            { label: "Clear temporary files", next: "clear_files" },
            { label: "Go back to start", next: "start" }
        ]
    },
    internet: {
        message: "If your internet is acting up, let's go through a few quick checks:",
        options: [
            { label: "Check your router", next: "check_router" },
            { label: "Reconnect to Wi-Fi", next: "reconnect_wifi" },
            { label: "Restart your modem", next: "restart_modem" }
        ]
    },
    check_router: {
        message: "Ensure your router is plugged in and the lights are on. Sometimes, simply restarting it can fix the issue.",
        options: [
            { label: "Reconnect to Wi-Fi", next: "reconnect_wifi" },
            { label: "Restart your modem", next: "restart_modem" },
            { label: "Go back to start", next: "start" }
        ]
    },
    reconnect_wifi: {
        message: "Try disconnecting and reconnecting to your Wi-Fi. Make sure you're selecting the right network and entering the correct password.",
        options: [
            { label: "Check your router", next: "check_router" },
            { label: "Restart your modem", next: "restart_modem" },
            { label: "Go back to start", next: "start" }
        ]
    },
    restart_modem: {
        message: "Try unplugging your modem for 30 seconds and plugging it back in. This can help fix connection issues.",
        options: [
            { label: "Check your router", next: "check_router" },
            { label: "Reconnect to Wi-Fi", next: "reconnect_wifi" },
            { label: "Go back to start", next: "start" }
        ]
    },
    software_not_responding: {
        message: "If a software is not responding, try the following:",
        options: [
            { label: "Force close the app", next: "force_close" },
            { label: "Check for updates", next: "check_updates" },
            { label: "Restart the software", next: "restart_software" }
        ]
    },
    force_close: {
        message: "Press Ctrl+Alt+Del and open Task Manager to force close the app. This can help if it's frozen.",
        options: [
            { label: "Check for updates", next: "check_updates" },
            { label: "Restart the software", next: "restart_software" },
            { label: "Go back to start", next: "start" }
        ]
    },
    check_updates: {
        message: "Make sure your software is up to date. Check for updates in the app's settings or website.",
        options: [
            { label: "Force close the app", next: "force_close" },
            { label: "Restart the software", next: "restart_software" },
            { label: "Go back to start", next: "start" }
        ]
    },
    restart_software: {
        message: "Try closing the app and reopening it. Sometimes this can resolve the issue.",
        options: [
            { label: "Force close the app", next: "force_close" },
            { label: "Check for updates", next: "check_updates" },
            { label: "Go back to start", next: "start" }
        ]
    },
    file_not_found: {
        message: "Can't find your file? Let's check a few things:",
        options: [
            { label: "Search your computer", next: "search_computer" },
            { label: "Check the Recycle Bin", next: "recycle_bin" },
            { label: "Look in cloud storage", next: "cloud_storage" }
        ]
    },
    search_computer: {
        message: "Try using the search bar on your computer to find the file by name. You might have misplaced it.",
        options: [
            { label: "Check the Recycle Bin", next: "recycle_bin" },
            { label: "Look in cloud storage", next: "cloud_storage" },
            { label: "Go back to start", next: "start" }
        ]
    },
    recycle_bin: {
        message: "Check your Recycle Bin. You might have accidentally deleted the file. Right-click and restore if found.",
        options: [
            { label: "Search your computer", next: "search_computer" },
            { label: "Look in cloud storage", next: "cloud_storage" },
            { label: "Go back to start", next: "start" }
        ]
    },
    cloud_storage: {
        message: "If you use cloud storage (like Google Drive or OneDrive), check there. You might have saved it there by mistake.",
        options: [
            { label: "Search your computer", next: "search_computer" },
            { label: "Check the Recycle Bin", next: "recycle_bin" },
            { label: "Go back to start", next: "start" }
        ]
    }
};


const loadDialog = (step) => {
    const currentStep = dialogFlow[step];

    chatbox.innerHTML += `
        <div class="chat incoming thinking">
            <div class="chat-icon">
                <img src="images/cicto_logo.png" alt="Chat Icon" class="chat-icon-img">
            </div>
            <div class="chat-text">
                <p>Thinking...</p>
            </div>
        </div>`;

    chatbox.scrollTo(0, chatbox.scrollHeight);

    setTimeout(() => {
        document.querySelector('.thinking')?.remove();

        if (!currentStep) {
            chatbox.innerHTML += `
                <div class="chat incoming">
                    <div class="chat-icon">
                        <img src="images/cicto_logo.png" alt="Chat Icon" class="chat-icon-img">
                    </div>
                    <div class="chat-text">
                        <p>Thank you for chatting with us!</p>
                    </div>
                </div>`;
            dialogOptions.innerHTML = '';
            return;
        }

        chatbox.innerHTML += `
    <div class="chat incoming previous-dialog" data-step="${step}">
        <div class="chat-icon">
            <img src="images/cicto_logo.png" alt="Chat Icon" class="chat-icon-img">
        </div>
        <div class="chat-text">
            <p>${currentStep.message}</p>
        </div>
    </div>`;

        const optionsContainer = document.createElement('div');
optionsContainer.classList.add('chat', 'incoming');

const optionsText = document.createElement('div');
optionsText.classList.add('chat-text', 'dialog-options');

currentStep.options.forEach(option => {
    const button = document.createElement('button');
    button.textContent = option.label;
    button.addEventListener('click', () => handleOptionClick(option.label, option.next));
    optionsText.appendChild(button);
});

optionsContainer.appendChild(optionsText);
chatbox.appendChild(optionsContainer);


        chatbox.scrollTo(0, chatbox.scrollHeight);
    }, 1000);
};

const handleOptionClick = (label, next) => {
    chatbox.innerHTML += `
        <div class="chat outgoing">
            <p>${label}</p>
        </div>`;

    chatbox.scrollTo(0, chatbox.scrollHeight);

    loadDialog(next);
};


sendChatBtn.addEventListener('click', () => {
let userMessage = chatInput.value.trim().toLowerCase();
if (!userMessage) return;

chatbox.innerHTML += `<div class="chat outgoing"><p>${chatInput.value}</p></div>`;
chatInput.value = "";
chatbox.scrollTo(0, chatbox.scrollHeight);

let matchedStep = Object.keys(dialogFlow).find(key => key.includes(userMessage.replace(/ /g, "_")));
loadDialog(matchedStep || "start");
});



const handleChat = () => {
userMessage = chatInput.value.trim();
if(!userMessage) return;
chatInput.value = "";
chatInput.style.height = `${chatInput.scrollHeight}px`;

chatbox.appendChild(createChatLi(userMessage, "outgoing"));
chatbox.scrollTo(0, chatbox.scrollHeight);        //auto scroll chat

setTimeout(() => {

    const incomingChatLi = createChatLi("Thinking...", "incoming");
    chatbox.appendChild(incomingChatLi);
    chatbox.scrollTo(0, chatbox.scrollHeight);     
    chatbox.offsetHeight; 
    generateResponse(incomingChatLi);
}, 600);
}

chatbox.addEventListener('click', (e) => {
    const button = e.target.closest('.chat-text button'); 
    if (button) {
        const optionLabel = button.textContent;
        const optionNext = dialogFlow[button.closest('.previous-dialog').dataset.step].options.find(option => option.label === optionLabel).next;
        handleOptionClick(optionLabel, optionNext);
    }
});

chatInput.addEventListener("input", () => {

chatInput.style.height = `${inputInitHeight}px`;
chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
    e.preventDefault();
    sendChatBtn.click();
}
});

chatTextarea.addEventListener("input", () => {
chatTextarea.style.height = "55px"; 
chatTextarea.style.height = `${chatTextarea.scrollHeight}px`; 
dialogOptions.style.bottom = `${chatTextarea.scrollHeight + 10}px`;
});

chatInput.addEventListener("input", () => {
chatInput.style.height = "55px"; 
chatInput.style.height = chatInput.scrollHeight + "px"; 
});

const closeChatbot = () => {
chatbot.style.display = 'none';
};


chatbotToggler.addEventListener("click", () => {
        if (!document.body.classList.contains("show-chatbot")) {
            // new chatbot session
            document.body.classList.add("show-chatbot");
            chatbot.classList.remove("minimized");
            isMinimized = false;
            chatbox.innerHTML = "";
            dialogOptions.innerHTML = "";
            loadDialog("start");
        } else if (isMinimized) {
            // minimized
            chatbot.classList.remove("minimized");
            isMinimized = false;
        }
    });

    chatbotCloseBtn.addEventListener("click", () => {//CLOSE FUNCTION
        document.body.classList.remove("show-chatbot");
        chatbot.classList.remove("minimized");
        isMinimized = false;
    });

    minimizeBtn.addEventListener("click", () => {
        chatbot.classList.toggle("minimized");
        isMinimized = !isMinimized;
    });


</script>


</body>

</html>



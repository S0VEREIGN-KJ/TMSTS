
<!DOCTYPE html>
<html lang="en" dir="ltr">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">    <!--Google Fonts Link for Icons-->
  
<style>
    /* Import Google font - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
*{
 
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
html {
  touch-action: manipulation; /* Prevents double-tap zoom */
  -ms-touch-action: manipulation; /* For older IE/Edge */
}

body{
    background: #E3F2FD;
}
.chatbot-toggler{
    overflow: auto;
    position: absolute;
    right:770px;
    bottom: 200px;
    height: 50px;
    width: 50px;
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
    position: absolute;
    right: 750px;
    bottom: 200px;
    width: 420px;
    height: 650px;
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
      z-index: 3;
      overflow: auto;
}
.show-chatbot .chatbot{
    transform: scale(1);
    opacity: 1;
    pointer-events: auto;
}
.chatbot header{
    background: #724ae8;
    padding: 14px;
    text-align: center;
    height: 90px;
}
.chat header h2{
    color: #fff;
    font-size: 1.4rem;
}
.chatbot header span{
    position: absolute;
    right: 30px;
    top: 6%;
    color: #fff;
    cursor: pointer;
    display: block;
    transform: translateY(-50%);

}
.chatbot .chatbox {
    height: 510px;
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
    background: #724ae8;
    text-align:center;
    line-height: 32px;
    border-radius: 4px;
    margin: 0 10px 0;
}
.chatbot .outgoing{
    margin: 20px 0;
    justify-content: flex-end;
}

.chatbot .chat p {
    color: #fff;
    max-width: 75%;
    font-size: 0.95rem;
    white-space: pre-wrap;
    padding: 12px 16px;
    border-radius: 10px 10px 0 10px;
    background: #724ae8;
}
.chatbot .chat p.error {
    color: #721c24;
    background: #f8d7da;
}
.chatbot .incoming p{
    color: #000;
    background: #f2f2f2;
    border-radius: 10px 10px 10px 0;
}
.chatbot .chat-input{
    position: absolute;
    bottom: 0;
    width: 100%;
    display: flex;
    gap: 5px;
    background: #fff;
    padding: 5px 20px;
    border-top: 1px solid #ccc;
} 
.chat-input textarea{
    height: 55px;
    width: 100%;
    border: none;
    outline: none;
    max-height: 180px;
    font-size: 0.95rem;
    resize: none;
    padding: 16px 15px 16px 0;
}
.chat-input span{
    align-self: flex-end;
    height: 55px;
    line-height: 55px;
    color: #724ae8;
    font-size: 1.35em;
    cursor: pointer;
    visibility: hidden;
}
.chat-input textarea:valid ~ span{
    visibility: visible;
}
.alert-mark {
  position: absolute;
  top: 70%;
  left: 58%;
  transform: translateX(-50%);
  font-size: 40px;
  color: #ff0000; /* red color */
  font-weight: bold;
  z-index: 3;
}
@media (max-width: 768px) {
    .chatbot-toggler {
        right: 10%;
        bottom: 15%;
   
    }
    .chatbot {
        top: 10px;
        right: 20px;
        bottom: 10%;
        width: 90%;
        height: 90%;
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
        right: 10%;
        bottom: 15%;
    }
    .chatbot {
        top: 10px;
        right: 20px;
        bottom: 10%;
        width: 90%;
        height: 90%;
    }
    .alert-mark{
        top: 75%;
        left: 80%;
        font-size: 40px;
        color: #ff0000; /* red color */
        font-weight: bold;  
    }
}

</style>


  
</head>

<body>
<span class="alert-mark">!</span>
    <button class="chatbot-toggler">
        <span class="material-symbols-outlined">mode_comment</span>
        <span class="material-symbols-outlined">close</span>
        
    </button>
    <div class="chatbot">
        <header>
            <h2>HELPBOT</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>

        <ul class="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p>Hi There <br>How can I help you today, Tech? <br></p>
              
            </li>
            <li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p>Any problem on repairing?</p>
            </li>
        </ul>

        <div class="chat-input">
            <textarea placeholder="Enter a message..." required></textarea>
            <span id="send-btn"  class="material-symbols-outlined">send</span>
        </div>

    </div>

  
</body>

<script>
    const chatInput = document.querySelector(".chat-input textarea");
const sendChatBtn = document.querySelector(".chat-input span");
const chatbox = document.querySelector(".chatbox");
const chatbotToggler = document.querySelector(".chatbot-toggler");
const chatbotCloseBtn = document.querySelector(".close-btn");

let userMessage;
const API_KEY = "AIzaSyBQUJNwAfZa_hYqHd92MdsmSE92G1A78pM";
const inputInitHeight = chatInput.scrollHeight;

const createChatLi = (message, className) => {
    //Create a chat <li> element with passed message and className
    const chatLi = document.createElement("li");
    chatLi.classList.add("chat", className);
    let chatContent = className === "outgoing" ? `<p>${message}</p>` : `<span class="material-symbols-outlined">smart_toy</span><p>${message}</p>`;
    chatLi.innerHTML = chatContent;
    chatLi.querySelector("p").textContent = message;
    return chatLi;
}

const generateResponse = (incomingChatLi) => {
    const API_URL =  `https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=${API_KEY}`
    const messageElement = incomingChatLi.querySelector("p");
    
    const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ 
          contents: [{ 
            role: "user", 
            parts: [{ text: userMessage }] 
          }] 
        }),
      };
      
      //Send POST request to API, get  response
      fetch(API_URL, requestOptions).then(res => res.json()).then(data => {
        messageElement.textContent = data.candidates[0].content.parts[0].text; // Update message text with API response
    }).catch((error) => {
        messageElement.textContent = "Oops! Something went wrong. Please try again.";
    }).finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));  //auto scroll chat
  }
 
  const handleChat = () => {
    userMessage = chatInput.value.trim();
    if(!userMessage) return;
    chatInput.value = "";
    chatInput.style.height = `${chatInput.scrollHeight}px`;

    //Append the user's message to the chatbox
    chatbox.appendChild(createChatLi(userMessage, "outgoing"));
    chatbox.scrollTo(0, chatbox.scrollHeight);        //auto scroll chat

    setTimeout(() => {
        //Display "Thinking..." message while waiting for the response
        const incomingChatLi = createChatLi("Thinking...", "incoming");
        chatbox.appendChild(incomingChatLi);
        chatbox.scrollTo(0, chatbox.scrollHeight);     //auto scroll chat
        chatbox.offsetHeight; // Trigger reflow
        generateResponse(incomingChatLi);
    }, 600);
}


chatInput.addEventListener("input", () => {
  //Adjust the height of the input textarea based on its content
  chatInput.style.height = `${inputInitHeight}px`;
  chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
  // If Enter key is pressed without Shift key and the window
  // width is greater than 800px, handle the chat
  if(e.key === "Enter" && !e.shiftKey && window.innerWidth > 800){
    e.preventDefault();
    handleChat();
  }
})
chatbotToggler.addEventListener("mousedown", (e) => {
  console.log("MouseDown event triggered");
  document.body.classList.add("dragging");
  chatbotToggler.style.cursor = "move";
  let startX = e.clientX;
  let startY = e.clientY;
  let togglerX = chatbotToggler.offsetLeft;
  let togglerY = chatbotToggler.offsetTop;

  document.addEventListener("mousemove", (e) => {
    console.log("MouseMove event triggered");
    if (document.body.classList.contains("dragging")) {
      let newX = e.clientX;
      let newY = e.clientY;
      let deltaX = newX - startX;
      let deltaY = newY - startY;
      chatbotToggler.style.top = `${togglerY + deltaY}px`;
      chatbotToggler.style.left = `${togglerX + deltaX}px`;
    }
  });

  document.addEventListener("mouseup", () => {
    console.log("MouseUp event triggered");
    document.body.classList.remove("dragging");
    chatbotToggler.style.cursor = "pointer";
  });
});

document.addEventListener("mousemove", (e) => {
  if (document.body.classList.contains("dragging")) {
    let newX = e.clientX;
    let newY = e.clientY;
    let deltaX = newX - startX;
    let deltaY = newY - startY;
    chatbotToggler.style.top = `${togglerY + deltaY}px`;
    chatbotToggler.style.left = `${togglerX + deltaX}px`;

    // Update the chatbox position
    const chatbox = document.querySelector(".chatbot");
    chatbox.style.top = `${togglerY + deltaY + 50}px`; // adjust the top position to account for the toggler's height
    chatbox.style.left = `${togglerX + deltaX}px`;
  }
});

sendChatBtn.addEventListener("click", handleChat);
chatbotCloseBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));


</script>
</html>



    
        
function notification(title){
    const result = document.getElementById("result");
    
    result.innerHTML = ` 
                        <div class='notification' onclick='hide_notify()'>
                            <div class='notify-sign'><i class='positive fa-solid fa-check fa-2xl'></i></div>
                            <div class='notification-header'>${title}</div>
                        </div>`
    ;
    const x = document.querySelector(".notification");
    setTimeout(() => {
    x.style.width ='300px';
    x.style.opacity = '1';
    },10);
        // setTimeout(3);
    setTimeout(() => {
    x.style.width ='0px';
    x.style.opacity = '0';
    }, 3000);
   
}
function hide_notify(){
    var x = document.querySelector('.notification');
    if(x){
    x.style.width ='0px';
    x.style.opacity = '0';
}
}

function newMessage(id, message) {
    const result = document.getElementById("chatBox");

    // Tworzenie nowego elementu powiadomienia
    const newMessage = document.createElement("div");
    newMessage.classList.add("new-message", "friend", "selected");
    newMessage.onclick = function() {
        this.style.display = "none";
    };


    newMessage.innerHTML = `
        <div>
            <div class='avatar'><img src='pfp.png' alt="Friend's Avatar"></div>
            <div class='nick r font'>${id}</div>
            <div class='message-s'>${message}</div>
            <div class="bar"></div>
        </div>
    `;

    // Dodanie elementu do chatBox
    result.appendChild(newMessage);

    const x = result.lastElementChild;

    setTimeout(() => {
        x.style.animation = "reversepop 0.3s";
    }, 3000);
    setTimeout(() => {
        x.style.display = "none";
    }, 3300); 
}
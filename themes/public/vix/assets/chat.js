var form=null;
var incoming_id=null;
var inputField=null;
var chatBox=null;

function setup() {
    form = $(".typing-area")[0];
    incoming_id = $(".incoming_id")[0].value,
    inputField = $(".input-field")[0],
    sendBtn = $(".typing-area button")[0],
    chatBox = $(".chat-box")[0];
    
    form.onsubmit = (e)=>{
        e.preventDefault();
    }
    
    inputField.focus();
    inputField.onkeyup = ()=>{
        if(inputField.value != ""){
            sendBtn.classList.add("active");
        }else{
            sendBtn.classList.remove("active");
        }
    }

    sendBtn.onclick = ()=>{
        if($(".typing-area")[0] && !form) setup();

        if(!form) return;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/video-chat?_action=insert-chat&_other=" + $('#_other').val(), true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                  inputField.value = "";
                  scrollToBottom();
              }
          }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
    chatBox.onmouseenter = ()=>{
        chatBox.classList.add("active");
    }

    chatBox.onmouseleave = ()=>{
        chatBox.classList.remove("active");
    }
}

setInterval(() =>{
    if($(".typing-area")[0] && !form) setup();
    
    if(!form) return;
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/video-chat?_action=get-chat&_other=" + $('#_other').val(), true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          console.log(xhr.response);
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();//"incoming_id="+incoming_id);
}, 5000);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
setInterval(() =>{    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/video-chat?_action=get-chat&_other=" + $('#_other').val(), true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          console.log(xhr.response);
          if(xhr.status === 200){
            let data = xhr.response;
            $('.chat-box')[0].innerHTML = data;
//            if(!chatBox.classList.contains("active")){
                if(!$('.chat-box').has(":focus")) scrollToBottom();
 //             }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();//"incoming_id="+incoming_id);
}, 5000);

$(()=>{
    $('.chat-button').on('click',()=>{     
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
        let formData = new FormData();
        formData.append("_other",$('#_other').val());
        formData.append("_message",$('#_message').val());
        xhr.send(formData);
    });
});

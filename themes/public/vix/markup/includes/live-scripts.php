<script>
    const chatMsg = document.querySelector("#chat_msg");
    const chatSend = document.querySelector("#live_send");
    var chatWs=new WebSocket("<?=CHAT?>");  

    chatWs.addEventListener("open",(i)=>{
        log(i);
        chatSend.style.display = "";
        chatMsg.innerHTML += "<div class='mitem'>Connected....</div>";
    });
    chatWs.addEventListener("message", (m) => {
        log(m);
        var payload = JSON.parse(m.data);
        chatMsg.innerHTML += "<div class='mitem'>"+payload.message+"</div>";
    });
    chatSend.addEventListener("keyup",(e)=> {
        log(e);
        if(e.keyCode==13) {        
            var data = {
                chatHandle: "<?=md5("hjkdfs78jukhfd".@app::memberUser())?>",
                message: chatSend.value
            }
            chatWs.send(JSON.stringify(data));
            chatSend.value = "";
        }
    });

    chatMsg.innerHTML += "<div class='mitem'>Connecting....</div>";
</script>

<script src="https://unpkg.com/ion-sdk-js@1.5.5/dist/ion-sdk.min.js"></script>
<script src="https://unpkg.com/ion-sdk-js@1.5.5/dist/json-rpc.min.js"></script>
<script>

const liveVideo = document.querySelector("#live_video");
const serverUrl = "<?=STREAM?>";
const config = {
    /*iceServers: [
    {
        urls: 'turn:nerdycms.com.metered.live:80',
        username: '18ec771e33667f1499c88ea5',
        credential: 'Lbo+Qdv7Px85LzZm'
    }]*/
    iceServers: [
      {
        urls: "stun:stun.relay.metered.ca:80",
      },
      {
        urls: "turn:a.relay.metered.ca:80",
        username: "18ec771e33667f1499c88ea5",
        credential: "Lbo+Qdv7Px85LzZm",
      }]
      /*,
      {
        urls: "turn:a.relay.metered.ca:80?transport=tcp",
        username: "18ec771e33667f1499c88ea5",
        credential: "Lbo+Qdv7Px85LzZm",
      },
      {
        urls: "turn:a.relay.metered.ca:443",
        username: "18ec771e33667f1499c88ea5",
        credential: "Lbo+Qdv7Px85LzZm",
      },
      {
        urls: "turn:a.relay.metered.ca:443?transport=tcp",
        username: "18ec771e33667f1499c88ea5",
        credential: "Lbo+Qdv7Px85LzZm",
      },*/
  //    ]
};
const signalLocal = new Signal.IonSFUJSONRPCSignal(serverUrl);
const clientLocal = new IonSDK.Client(signalLocal, config);

signalLocal.onopen = () => clientLocal.join("default");
clientLocal.ontrack = (track, stream) => {    
    //console.log("got track", track.id, "for stream", stream.id);
    track.onunmute = () => {    
        liveVideo.srcObject = stream;    
        // When this stream removes a track, assume
        // that its going away and remove it.
        stream.onremovetrack = () => {
            try {
                chatSend.style.display = "none";
                liveVideo.srcObject = null;
            } catch (err) {}
        };      
    };    
};
 
let localStream;
const startCast = () => { 
  event.target.style.display = "none";  
  IonSDK.LocalStream.getUserMedia({
    resolution: "vga",
    audio: true,
    codec: "vp8"
  })
    .then((media) => {
      localStream = media;
      liveVideo.srcObject = media;                    
      clientLocal.publish(media);
    })
    .catch(console.error);
};



</script>
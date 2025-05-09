<script>
    var peer;
    function ll(m) {
        peer.appendMsg(m,"DEBUG");
    }
                
    function fmtDate(dte,p) {           
        var yyyy = dte.getFullYear();
        var mm = dte.getMonth() + 1; // getMonth() is zero-based
        var dd = dte.getDate();
        var ymd = String(10000 * yyyy + 100 * mm + dd); // Leading zeros for mm and dd

        var hh = dte.getHours();
        var ii = dte.getMinutes();
        var ss = dte.getSeconds();
        var his = String(10000 * hh + 100 * ii + ss); // Leading zeros for mm and dd
        his = hh<10?"0" + his:his;

        var ret = '';
        var idx = {};
        for(var i=0;i<p.length;i++) {
            var c = p[i];
            var cl = c.toLowerCase();
            switch(cl) {
                case 'h':             
                    idx[cl] = idx[cl]==undefined?0:idx[cl];
                    ret += his[idx[cl]];
                    idx[cl]+=1;
                    break
                    case 'h':
                case 'i':
                    idx[cl] = idx[cl]==undefined?0:idx[cl];
                    ret += his[2+idx[cl]];
                    idx[cl]+=1;
                    break                        
                case 's':
                    idx[cl] = idx[cl]==undefined?0:idx[cl];
                    ret += his[4+idx[cl]];
                    idx[cl]+=1;
                    break
                default:
                    ret += c;
                    break;
            }
        }

        return ret;
    }

    var peers = [];
    
    
    class wsPeer {                        
        constructor(isoffer,issub) {            
            peers.push(this);
            this.iceCandidates = {};
            this.offerCreated = false;
            this.idx = peers.length;
            this.castStream = null;
            this.isSub = issub==undefined?false:issub;            
            this.isOffer = isoffer;
            console.log("spawn:",this.isOffer,this.isSub, this.idx)
            this.host = '<?=str_replace("https:","wss:",DOM)?>:42030';
            this.localVideo = document.getElementById("localVideo");
            this.remoteVideo = document.getElementById("remoteVideo");            
            this.configuration = {
                iceServers: [
                {
                    urls: 'turn:openrelay.metered.ca:80',
                    username: 'openrelayproject',
                    credential: 'openrelayproject'
                }, 
                //{
                  //  urls: 'stun:stun.l.google.com:19302' // Google's public STUN server
                //}
            ] 
            };                     
            this.onconnected = (e)=>{};
        }
        
        connect(ss) {
            var self = this;
            this.socket = ss==undefined?new WebSocket(this.host):ss;
            if(ss==undefined) {
                this.socket.onerror = (e)=>{ ll(e); };
                this.socket.onopen = (e)=>{
                    self.startWebRTC(self.isOffer);    
                    self.onconnected(e);
                };
                this.socket.onmessage = (e)=> {self.recMessage(e)};
            }
        }
        
        recMessage(e) {            
            var self = this;            
            var message = JSON.parse(e.data);
            
            if(message.jrq!=undefined) {            
                if(this.isOffer && !this.isSub) {
                    var rem = new wsPeer(true,true);                
                    rem.connect();
                } else console.log("JRQ: ignore");
            } else if(message.sdp!=undefined) {                                
              // This is called after receiving an offer or answer from another peer
              console.log(message.sdp,self.idx,self.pc.signalingState);
              if(self.pc.signalingState!="have-remote-offer") self.pc.setRemoteDescription(new RTCSessionDescription(message.sdp), () => {                                                    
                if(!self.isOffer && self.pc.remoteDescription.type === 'offer') {
                    self.pc.createAnswer().then((desc)=>{ return self.remoteDescCreated(desc); }).catch((e)=> { throw e; });                
                }
              },(e)=> { throw e; });
            } else if (message.candidate) {
              // Add the new ICE candidate to our connections remote description
                if(this.iceCandidates[message.candidate.usernameFragment]==undefined) {
                    this.iceCandidates[message.candidate.usernameFragment] = message.candidate;
                    console.log("REC:",message);
                    this.pc.addIceCandidate(
                        new RTCIceCandidate(message.candidate), self.onSuccess, function (e) { ll(e); }
                    );
                }
            }
            if(message.text!=undefined) {
                this.appendMsg(message.text,"OTHER");
            }            
        }

        sendMessage(o) {       
            var os = JSON.stringify(o);
            console.log("SEND:",o)
            this.socket.send(os);
        }    

        appendMsg(m,u) {
            m = typeof(m)=="object"?JSON.stringify(m):m;
            var dte = new Date();            
            var ds = fmtDate(dte,"HH:ii.ss");

            var uc = "";
            if(u=="ME") uc = "#f99";
            else uc = "#99f";
            var bdy = "<span class='dte'>" + ds + "</span>:<span style='color:" + uc + "' class='usr'>" + u + "</span>:<span class='msg'>" + m + "</span>";
            document.getElementById('msg').innerHTML += "<span class='rmsg'>" + bdy + "</span>";
        }

        onSuccess() {}
        onError(error) { ll(error);}

        localDescCreated(desc) {       
            var self = this;
            self.pc.setLocalDescription(
                desc,
                () => self.sendMessage({sdp: self.pc.localDescription}),
                (ex)=>{throw ex;}        
            );
        }
        
        remoteDescCreated(desc) {                   
            var self = this;
            self.pc.setLocalDescription(
                desc,
                () => self.sendMessage({sdp: self.pc.localDescription}),
                (ex)=>{throw ex;}        
            );
        }
        
        startWebRTC() {
            var self = this;
            this.pc = new RTCPeerConnection(this.configuration);                

            // 'onicecandidate' notifies us whenever an ICE agent needs to deliver a
            // message to the other peer through the signaling server
            this.pc.onicecandidate = event => {
              if (event.candidate && self.pc.signalingState!="stable") {
                self.sendMessage({'candidate': event.candidate});
              }
            };

            // If user is offerer let the 'negotiationneeded' event create the offer
            if (this.isOffer) {
              this.pc.onnegotiationneeded = () => {
                 console.log(self.pc);
                 if(!self.offerCreated) {
                     self.offerCreated=true; 
                     self.pc.createOffer().then((desc)=>{ return self.localDescCreated(desc); }); //.catch(onError);
                 }
              }
            }

            // When a remote stream arrives display it in the #remoteVideo element
            if(!this.isOffer) this.pc.onaddstream = event => {  
                console.log("STREAM:",event.stream)
                document.getElementById("remoteVideo").srcObject = event.stream;
            };

            /*if(peers[0].castStream) {
                console.log(peers[0].castStream);
                this.pc.addStream(peers[0].castStream);
            } else */
            if(this.isOffer) navigator.mediaDevices.getUserMedia({
                audio: false,
                video: true }).then(stream => {
                    // Display your local video in #localVideo element
                    document.getElementById("localVideo").srcObject = stream;
                    // Add your stream to be sent to the conneting peer
                   // self.castStream = stream;
                    self.pc.addStream(stream);
                });

            //throw new Exeption("test");

        }
    }
    
    peer = new wsPeer(offer);
    peer.onconnected = (e)=>{
        if(!offer) peer.sendMessage({jrq: true});
        document.getElementById("send").style.display="";
        document.getElementById("send").addEventListener("keyup",(event)=> {
            if(event.which==13) {            
                peer.sendMessage({text: event.target.value });
                peer.appendMsg(event.target.value,"ME");
                event.target.value = "";
            }
        });     
    };
    peer.connect();
    
</script>

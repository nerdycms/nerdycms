<div id="<?=$gid="_gid_".random_int(10000,99999)?>" class="<?=$grp->style=="header"?"float-end":"row"?><?=!empty(@$grp->optional)?" grp-optional":""?>"><?php
$ronly = in_array($this->hook,["/admin/categories","/admin/tags","/admin/payouts"]);
if(is_string($grp->elements)) {
    $ent = new $grp->elements;
    $elements = $ent->cols->items(app::adminRole());
} else {
    $elements = $grp->elements;
}                    

if(!empty(@$grp->title) && in_array($grp->style, ["basic","horizontal"])) { ?>
        <div class="col-md-12 grp-title">
            <h5><?=$grp->title?></h5>                    
            <?php if(!empty(@$grp->link)) { list($lbl,$url) = explode("@",$grp->link); ?> <a class="grp-link href="<?=$url?>"><?=$lbl?> <i data-feather="link"></i> </a> <?php } ?>
            <span class="float-end">
                <?php if(@$grp->optional===true) { ?>
                <a href="javascript:reveal('<?=$gid?>')" class="float-end grp-option-ctl option-active">View <i data-feather="chevron-left"></i></a>
                <a href="javascript:reveal('<?=$gid?>')" class="float-end grp-option-ctl">Hide <i data-feather="chevron-down"></i></a>
                <?php } else if(is_string(@$grp->optional)) { ?>
                <input type="hidden" name="<?=$grp->optional?>" id="<?=$grp->optional?>" value="">
                <a href="javascript:reveal('<?=$gid?>','<?=$grp->optional?>')" class="float-end grp-option-ctl option-active">Enable<i data-feather="check"></i></a>
                <a href="javascript:reveal('<?=$gid?>','<?=$grp->optional?>')" class="float-end grp-option-ctl">Disable<i data-feather="x-square"></i></a>                                                            
                <?php } ?>
            </span>
        </div>
<?php }  
foreach($elements as $ele) {
    switch($ty = $this->inpType($form,$ele)) {  
        case 'chat': if($values) {
            $data[1]="group";
            ?>
     <div class="<?=$this->inpW($grp,$ele)?>">
         <style>             
/* Chat Area CSS Start */
.chat-area header{
  display: flex;
  align-items: center;
  padding: 18px 30px;
}
.chat-area header .back-icon{
  color: #333;
  font-size: 18px;
}
.chat-area header img{
  height: 45px;
  width: 45px;
  margin: 0 15px;
}
.chat-area header .details span{
  font-size: 17px;
  font-weight: 500;
}
.chat-box{
    border: solid 1px #555;
    border-radius: .3rem;
  position: relative;
  min-height: 500px;
  max-height: 500px;
  overflow-y: auto;
  padding: 10px 30px 20px 30px;
  background: #f7f7f7;
  box-shadow: inset 0 32px 32px -32px rgb(0 0 0 / 5%),
              inset 0 -32px 32px -32px rgb(0 0 0 / 5%);
}
.chat-box .text{
  position: absolute;
  top: 45%;
  left: 50%;
  width: calc(100% - 50px);
  text-align: center;
  transform: translate(-50%, -50%);
}
.chat-box .chat{
  margin: 0;
}
.chat-box .chat p{
  word-wrap: break-word;
  padding: 8px 16px;
  box-shadow: 0 0 32px rgb(0 0 0 / 8%),
              0rem 16px 16px -16px rgb(0 0 0 / 10%);
}
.chat-box .outgoing{
  display: flex;
}
.chat-box .outgoing .details{
  margin-left: auto;
  max-width: calc(100% - 130px);
}
.outgoing .details p{
  background: #333;
  color: #fff;
  border-radius: 18px 18px 0 18px;
}
.chat-box .incoming{
  display: flex;
  align-items: flex-end;
}
.chat-box .incoming img{
  height: 35px;
  width: 35px;
}
.chat-box .incoming .details{
  margin-right: auto;
  margin-left: 10px;
  max-width: calc(100% - 130px);
}
.incoming .details p{
  background: var(--bkg);
  color: var(--text);
  border-radius: 18px 18px 18px 0;
}
.typing-area{
  padding: 18px 30px;
  display: flex;
  justify-content: space-between;
}
.chat-input{
  height: 40px;
  width: calc(100% - 64px);
  font-size: 16px;
  padding: 0 10px;
  border: 1px solid #e6e6e6;
  outline: none;
  border-radius: 5px 0 0 5px;
}
.chat-button , .btn-upload {
  color: #fff;
  width: 55px;
  border: none;
  outline: none;
  background: #333;
  font-size: 19px;
  cursor: pointer;  
  
  transition: all 0.3s ease;
}
.typing-area button:last-child {
    border-radius: 0 5px 5px 0;
}
.typing-area button.active,.btn-upload{
  opacity: 1;
  pointer-events: auto;
}

.btn-upload {
    position: relative;
    width: 55px;
    height: 45px;
}

.btn-upload input[type=file] {
    position: absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;    
    z-index: 20;
    opacity: 0;        
}
.btn-upload i {
    position: absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    line-height: 40px;
    text-align: center;
}

.chat-table {
    width: 100%;    
}
.chat-table tr {
    vertical-align: top;        
}
         </style>
            <table class="chat-table">
    <tr>
        <td>                                  
            <section class="chat-area">            
              <div class="chat-box">

              </div>
              <progress style="display: none;width:100%"></progress>
              <div class="typing-area">
                <input type="hidden" id="_other" value="<?=-1*app::request("_id")?>">                
                <input type="text" id="_message" class="chat-input input-field" placeholder="Type a message here..." autocomplete="off">
                <!--<div class="btn-upload active"><input name="file" type="file"><i class="fa fa-cloud-upload"></i></div>-->
                <button type="button" class="chat-button"><i class="fab fa-telegram-plane"></i></button>
              </div>
            </section>                  
        </td>
    </tr>
</table>       
<?=app::asset("themes/admin/min/assets/chat.js")?>
</div> 
    <?php }
        break;
        case 'live_sel':?>
    <div class="<?=$this->inpW($grp,$ele)?>">
            <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                <input name="<?=$this->inpID($ele)?>" <?=$this->inpValue($form,$values,$ele)?> type="checkbox" class="form-check-input" id="<?=$this->inpID($ele)?>" onclick="toggleLive()">
                <label style="white-space: nowrap " class="form-check-label" for="<?=$this->inpID($ele)?>"><?=$this->label($ele)?></label>
            </div></div>
    <script>
        function toggleLive() {
            var $r = $('#live_video').parents(".row").first();
            if($('#live_stream').prop('checked')) $r.show();            
            else $r.hide();
        }
        $(()=>{
            toggleLive();
        });
    </script>
            <?php
        break;
        case 'live_stream':if($values) { ?>
    
            <div class="live-video <?=$this->inpW($grp,$ele)?>">
                <video style="background: #000;width: 100%" id="live_video" autoplay muted></video>                
                <button type="button" class="cast-btn btn btn-primary m-1" onclick="startCast()">Start Casting</button>                
                <label>INFO | CAST TIME: 00:00 - RECORDING: YES</label>
                <button style="float:right" type="button" class="m-1 cast-btn btn btn-danger">Mute</button>                
                <button style="float:right" type="button" class="m-1    cast-btn btn btn-danger">Blackout</button>                                
            </div>      
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
        <?php }
            break;
        case 'gallery':
            $gvl = @json_decode(@$values['image_gallery'],true);
            ?> <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>                                            
<table class="gallery">
    <tr>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:0')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[0]">
        </td>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:1')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[1]">
        </td>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:2')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[2]">
        </td>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:3')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[3]">
        </td>
    </tr>
    <tr>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:4')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[4]">
        </td>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:5')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[5]">
        </td>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:6')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[6]">
        </td>
        <td style="background-image: url('<?=$this->ent->meta($values,'gvl:7')?>')">
            <i class="fa fa-trash"></i>
            <input class="galf" type="file" name="gal[7]">
        </td>
    </tr>
</table>    
<script>
    $(document).ready(()=>{
      $('.gallery i').on('click',function () {
          var $i = $(this);  
          var $t = $i.parents("td").first();
          $t.css('background-image',"");
          $t.find('input').val('');
      });
      $('.galf').change(function(){
        var $i = $(this);  
        const file = this.files[0];
        console.log(file);
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
            console.log(event.target.result);
            $i.parents("td").first().css('background-image',"url('" + event.target.result + "')");
          }
          reader.readAsDataURL(file);
        }
      });
    });
</script>
                                    
                                    <?php
                                break;
                            case "image": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <div style="text-align: center;background-color: #000">
                                                <img id="preview" style="height:11.5rem" src="<?=$this->ent->meta($values,'poster')?>">
                                            </div>                                            
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>                                            
                                            <input value="<?=$this->inpValue($form,$values,$ele)?>" type="text" name="<?=$this->inpID($ele)?>" class="form-control" id="<?=$this->inpID($ele)?>">                                            
                                            <input type="file" name="<?=$this->inpID($ele)?>" class="m-2 float-end" id="<?=$this->inpID($ele)?>">                                            
                                        </div>
                                    </div>
                                </div>                                            
                            <?php break;
                            case "poster_basic": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <div style="text-align: center;background-color: #000">
                                                <img id="preview" style="height:11.5rem" src="<?=$this->ent->meta($values,$this->inpID($ele))?>">
                                            </div>
                                                                                        
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>                                            
                                            <input value="<?=$this->inpValue($form,$values,$ele)?>" type="text" name="<?=$this->inpID($ele)?>" class="form-control" id="<?=$this->inpID($ele)?>">                                            
                                            <input type="file" name="<?=$this->inpID($ele)?>" class="m-2 float-end" id="<?=$this->inpID($ele)?>">                                            
                                        </div>
                                    </div>
                                </div>                                            
                                <?php break;
                             case "poster": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <div style="text-align: center;background-color: #000">
                                                <img id="preview" style="height:11.5rem" src="<?=$this->ent->meta($values,'poster')?>">
                                            </div>
                                            
                                            <div id="slides" style="width: 100%;height:18.5rem;background-color: #eee;overflow-y: auto">                                                
                                            </div>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>                                            
                                            <input value="<?=$this->inpValue($form,$values,$ele)?>" type="text" name="<?=$this->inpID($ele)?>" class="form-control" id="<?=$this->inpID($ele)?>">
                                            <button type="button" id="generate" class="btn btn-primary mt-2 float-end">Generate slides</button>
                                            <input type="file" name="<?=$this->inpID($ele)?>" class="m-2 float-end" id="<?=$this->inpID($ele)?>">                                            
                                        </div>
                                    </div>
                                </div>            
                                <script>
                                    function genSlides() {                                       
                                        var dta = { _action: 'gen-slides', file: $('*[name=video_url]').val() };
                                        $.ajax({
                                            method: 'post',
                                            url: window.location.href,
                                            data: dta });                                       
                                    }
                                    function updSlides() {
                                         var dta = { _action: 'upd-slides', file: $('*[name=video_url]').val() };
                                            $.ajax({
                                                method: 'post',
                                                url: window.location.href,
                                                data: dta,
                                                success: (res)=> {                                         
                                                        var ra = res.split(':::');
                                                        res = ra[0];
                                                    //if(res!=lastres) {                                                             
                                                        $('#slides')[0].innerHTML = res;
                                                        $('#slides img').on('click',()=> {                                            
                                                            var $o = $(event.target);
                                                            $('#slides img').removeClass('active');
                                                            $o.addClass("active");
                                                            $('#preview').attr("src",$o.attr("src"));
                                                            $('*[name=poster_url]').val($o.attr("data-value"));
                                                        });
                                                        if(ra.length>1) eval(ra[1]);
                                                     //   lastres = res;
                                                     if(res=="") {
                                                         $('#slides').hide();
                                                     } else {
                                                         $('#slides').show();
                                                     }
                                                //}
                                                }
                                            });                                                
                                    }
                                    var lastres = null;
                                    $(()=> {
                                        $('#generate').on('click', ()=> genSlides() );
                                        updSlides();
                                        window.setInterval(()=> updSlides(),4000);                                                                              
                                    });
                                </script>
                                <?php break;
                            case "upload": ?>
                                <style>
                                    .myProgress {
                                        position: absolute;
                                        top: 18px;
                                        left: 350px;
                                        right: 200px;
                                        width: unset;
                                    }
                                    .plupload_container {
                                        min-height: 80px;
                                    }
                                    .plupload_file_name {
                                        width: auto!important;
                                    }
                                    .plupload_file_size {
                                        display: none;
                                    }
                                    .plupload_file_status {
                                        font-size: 3rem;
                                        width: 300px!important;
                                        position: absolute;
                                        right: 20px; top: 20px;
                                    }
                                    .plupload_button {
                                        background: #2ab57d;
                                        font-family: 'IBM Plex Sans';
                                        padding: 0.75rem 1rem;     
                                        color: #fff;     
                                        border-radius: .3rem;
                                    }
                                    .plupload_header {
                                        display: none;
                                    }
                                    .plupload_filelist_footer {
                                        position: absolute;
                                        top: 0;
                                        padding: .5rem;
                                        background: #fff;                                        
                                    }
                                    .plupload_filelist_header { display: none }
                                </style>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div class='row'>
                                        <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                        <div class="mb-3 col-md-6">                                            
                                            <textarea name="<?=$this->inpID($ele)?>" class="form-control upload" id="<?=$this->inpID($ele)?>"><?=$this->inpValue($form,$values,$ele)?></textarea>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <!--<label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>-->
                                            <?php } ?>
                                            <div data-key="<?=$this->inpID($ele)?>" class="uploader">
                                                    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                                            </div>
                                            <div id="myProgress">
                                                <div id="myBar"></div>
                                            </div>                                             
                                        </div>                                            
                                    </div>
                                </div>                                      
                                <?php break;
                            case "edit": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <div class="tab-controls">
                                                <button type="button" onclick="editSync('<?=$this->inpID($ele)?>');tab(event,'<?=$this->inpID($ele)?>')" class='btn btn-sm btn-info first'>Editor</button><button type="button" onclick="editSync('ace_<?=$this->inpID($ele)?>');tab(event,'ace_<?=$this->inpID($ele)?>')" class='btn btn-sm btn-info last tab-passive'>HTML</button>
                                            </div>
                                            <div class="clearfix"></div>           
                                            <div style='display:none' class="ace-editor tab-view" id="ace_<?=$this->inpID($ele)?>">
                                                <pre id="ace_pre_<?=$this->inpID($ele)?>" style='height:475px;'></pre>                                                
                                            </div>
                                            <?php } ?>
                                            <input type="hidden" name="<?=$this->inpID($ele)?>" class="edclone">                                            
                                            <div class="edit tab-view" id="<?=$this->inpID($ele)?>">
                                                <div class="edit-inner"><?=$this->inpValue($form,$values,$ele)?></div>
                                            </div>                                            
                                        </div>                                                                                
                                    </div>                                    
                                </div>                                        
                                <?php break;    
                            case "datalist": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input name="<?=$this->inpID($ele)?>" placeholder="Type to search..." value="<?=$this->inpValue($form,$values,$ele)?>" class="form-control" type="text" id="<?=$this->inpID($ele)?>" list="_list_<?=$this->inpID($ele)?>">
                                            <datalist id="_list_<?=$this->inpID($ele)?>"><?=$this->inpContent($form,$values,$ele)?></datalist>
                                        </div>
                                    </div>
                                </div>            
                            <?php break;
                            case "tags": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input type="hidden" name="<?=$this->inpID($ele)?>" id="<?=$this->inpID($ele)?>" class="input-multiple">
                                            <select data-type="select-multiple" name="_<?=$this->inpID($ele)?>" multiple class="form-control tags-multiple" id="_<?=$this->inpID($ele)?>"><?=$this->inpContent($form,$values,$ele)?></select>
                                        </div>
                                    </div>
                                </div>            
                                <?php break;                            
                            case "select": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <select name="<?=$this->inpID($ele)?>" class="form-control" id="<?=$this->inpID($ele)?>"><?=$this->inpContent($form,$values,$ele)?></select>
                                        </div>
                                    </div>
                                </div>            
                                <?php break;
                            case "check":?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                        <input name="<?=$this->inpID($ele)?>" <?=$this->inpValue($form,$values,$ele)?> type="checkbox" class="form-check-input" id="<?=$this->inpID($ele)?>">
                                        <label style="white-space: nowrap " class="form-check-label" for="<?=$this->inpID($ele)?>"><?=$this->label($ele)?></label>
                                    </div>
                                </div>    
                            <?php break;
                            case "text": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <textarea <?=$ronly?"disabled readonly":""?> placeholder="<?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" class="form-control" id="<?=$this->inpID($ele)?>"><?=$this->inpValue($form,$values,$ele)?></textarea>
                                        </div>
                                    </div>
                                </div>            
                                <?php break;
                            case "stat": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <div class="form-control"><?=$this->inpValue($form,$values,$ele)?></div>
                                        </div>
                                    </div>
                                </div>            
                                <?php break;                            
                            case "date": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input placeholder="<?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" value="<?=$this->inpValue($form,$values,$ele)?>" class="form-control" type="date" id="<?=$this->inpID($ele)?>">
                                        </div>
                                    </div>
                                </div>            
                                <?php break; 
                            case "!date": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input required placeholder="<?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" value="<?=$this->inpValue($form,$values,$ele)?>" class="form-control" type="date" id="<?=$this->inpID($ele)?>">
                                        </div>
                                    </div>
                                </div>            
                                <?php break; 
                            case "password": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input placeholder="<?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" value="<?=!empty($this->inpValue($form,$values,$ele))?"********":""?>" class="form-control" type="<?=$ty?>" id="<?=$this->inpID($ele)?>">
                                        </div>
                                    </div>
                                </div>            
                            <?php break;
                            case "!input": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input required placeholder="<?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" value="<?=$this->inpValue($form,$values,$ele)?>" class="form-control" type="text" id="<?=$this->inpID($ele)?>">
                                        </div>
                                    </div>
                                </div>            
                            <?php break;
                            case "money": ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input placeholder="$/BTC <?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" value="<?=$this->inpValue($form,$values,$ele)?>" class="form-control" type="number" step="0.01" min="0.00" max="999999999.00" id="<?=$this->inpID($ele)?>">
                                        </div>
                                    </div>
                                </div>            
                            <?php break;
                            default: ?>
                                <div class="<?=$this->inpW($grp,$ele)?>">
                                    <div>
                                        <div class="mb-3">
                                            <?php if(in_array($grp->style, ["basic","horizontal"])) { ?>
                                            <label for="<?=$this->inpID($ele)?>" class="form-label"><?=$this->label($ele)?></label>
                                            <?php } ?>
                                            <input placeholder="<?=$this->label($ele)?>" name="<?=$this->inpID($ele)?>" value="<?=$this->inpValue($form,$values,$ele)?>" class="form-control" type="<?=$ty?>" id="<?=$this->inpID($ele)?>">
                                        </div>
                                    </div>
                                </div>            
                                <?php break;
                        } 
                    }?></div>
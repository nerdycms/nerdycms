<?php        
    if(!isset($this->pdata['video'])) {        
        if(!empty(@$data[1])) {
            $term = $data[1];
            $st = '%'.app::slug($term," ").'%';
            $wh = " AND (tags LIKE '$st' OR category LIKE '$st' OR title LIKE '$st' or models LIKE '$st')";
        } else $wh = "";
        
        $ent = new video(["where"=>"casting_on is null AND sexuality='Straight' AND publish_status='Published' $wh"]);
        $list = $ent->fetch("valid");
        $a = $list[random_int(0, sizeof($list)-1)];        
        $standalone = true;
    } else {
        $ent = new video;    
        $a = $this->pdata['video'];
        $standalone = false;
    }

    $rent = new urating;
    $avg = 100*number_format($rent->fetch("avg",$a['id']),2);
    
    $ment = new member;    
    $cent = new ucomment(["where"=>"vid_id=".$a['id']]);
    $carr = $cent->fetch("array");
    $avg = 100*number_format($rent->fetch("avg",$a['id']),2);

    $scols = 4;    
    $q = "orig";
    
    $trailer = $ent->meta($a,"trailer");    
    $preview = $ent->meta($a,"preview");
    $video = $ent->meta($a,$q);//"__.mp4";    
    $videohd = $ent->meta($a,"hd");//."__.mp4";            
    
    $gvl = @json_decode(@$a['image_gallery'],true);
    $ida = [];
    $idx  = 0;
    $tries = 20;
    $scenes = [];
    $step = 9;
           
    $att = $ent->meta($a,"att");
    $dur = $att['hours'] * 3600 + $att['mins']*60 + $att['secs'];
    $durs = $att['hours'].":".$att['mins'].":".$att['secs'];
            
    $fr = 30;       
    if($dur<180) $fr = 10;
    if($dur>600) $fr = 60;
    
    $tslides = floor($dur/$fr);
    $step = floor($tslides/8);    
    if($step==0) $step = 1;
    
    for($idx=1;$idx<=$tslides;$idx+=$step) {        
        if(sizeof($scenes) < $scols*2) {            
            $sc = $ent->meta($a,"scene:$idx");
            if($sc) $scenes []= $sc;
            else break;
        } else break;
    }
    
    for($fi=0;$fi<8;$fi++) {
        $sc = $ent->meta($a,"gvl:$fi");
        if($sc) $scenes[$fi] = $sc;                
    }    
    
    $hidetitle = $hiderating = $hideinfo = $hidescenes = $standalone;
    $playable = app::memberUser() && !(app::memberRole() == "Free");
    $hidecom = $standalone || @$this->pdata['cst']['hide_comments']=="on";    
    $hidered = @$this->pdata['cst']['hide_video_release_date']=="on";    
    $preb4vid = @$this->pdata['cst']['play_preview_before_video']=="on";    
    $vidname = app::request("_video");
    
    $liveshow = $ent->meta($a,"liveshow");
    $nosett = false;
    if($liveshow=="now") { $nosett=true; $hidecom = true; $hidescenes = true; }
    
    if(app::memberUser() && app::memberRole() != "Free" && @$a['premium_member_view_price']>0) {
        $wat = new walletTransaction;                    
        if(!$wat->fetch("own",'video',$a['id'],app::memberUser())) $playable = false;
    }
    
    if(app::memberUser() && app::memberRole() == "Free" && @$a['free_member_view_price']>0) {
        $wat = new walletTransaction;                    
        if($wat->fetch("own",'video',$a['id'],app::memberUser())) $playable = true;
    }
    $decp = random_int(0, PHP_INT_MAX);
?>
<div class="nd-player-wrap">
    <?php if(!$playable) { ?>
    <div class="overlay" <?=$standalone?"style='transform:none'":""?>>
        <button onclick="playAtt()" class="ucase hotbutton">Watch now <?=$ent->meta($a, "effprice")>0?"for $".number_format($ent->meta($a, "effprice"),2):""?></button>
    </div>
    <?php } if(!$hidetitle) { ?>
    <h2 class="ucase text-left high-color"><?=$a['title']?> <?php if(@$this->pdata['cst']['hide_like_stat']!="on") { ?><span class="float-right">Likes: <?=$avg?>%</span><?php } ?></h2>
    <?php } if($playable) { ?>
    <video id="vid<?=$decp?>" controls playsinline class="nd-player" autoplay>        
        
    </video>
    <?php } else { ?>
    <video id="vid<?=$decp?>" data-poster="<?=$ent->meta($this->pdata["video"],'poster')?>" loop muted playsinline class="nd-player" autoplay>
        <source src="<?=$preview?>" label="PREVIEW" type="video/mp4">
    </video>
    <?php } ?>
    
    <h2 class="ucase nd-title mt0 p1 text-left"><?=$a['duration']?> <?=$hidered?"":"released ".@date('m/d/y',@strtotime($a['release_date']))?> 
        <?php 
        
            if(@$a['models']) { $tj = explode(',',$a['models']); foreach($tj as $t) { $st = app::slug($t,'-');
                echo "<span onclick=\"window.location.href='/model?_model-name=$st';\" class='nd-model'>$t</span>";
            }         }   else echo "<span class='nd-model' style='opacity:0'>&nbsp;</span>";
            ?>
        
        <span class="float-right" style="padding: .5rem"><?=$durs?> <?=$a['quality']?$a['quality']:"HD"?></span></h2>
        <?php if(!$hiderating) { ?>
        <br>
        <h2 class="com-rat" > <?php if(!$hidecom) { ?> <span onclick="$('#ucomments').slideToggle()">User comments: <i class="fa fa-chevron-down"></i></span> <?php } ?> <span id='ldd'><i onclick="urat(-1)" title="dislike" class="fa fa-thumbs-down float-right m-2"></i> <i onclick="urat(+1)" title="like" class="fa fa-thumbs-up float-right m-2"></i></span></h2>    
        <?php } if(!$hidecom) { ?> <div id="ucomments" style="display:none">
        <?php if(sizeof($carr)>0) { ?>
        <div id="cres">
            <?php foreach($carr as $c) { $m = $ment->fetch("id",$c['usr_id']); ?>
            <div class="comment">
                <h5><?=$m?$m['username']:"Admin"?></h5>
                <?=$c['comment']?>
            </div>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div id="cres">No comments added yet!</div>
        <?php } if(app::memberUser()) { ?>
        <textarea id="ctxt" placeholder="Enter comment..."></textarea>
        <div class="m-2 text-center">
            <button id="csub" onclick="csub()" class="ucase sub-button float-right">Submit <i class="fas fa-angle-double-right fa-1x"></i></button>
        </div>
        <?php } ?>
    </div> <?php } if(!$hidescenes) { ?>
    <h2 class="ucase">Video <span class="high-color">scenes</span></h2>
    <table class="nd-scenes">
        <tr>
        <?php $idx=0;  foreach($scenes as $i) { if($idx>0 && $idx%$scols==0) echo "</tr><tr>"; ?>
            <td data-zoom="<?=$i?>" class="scene" style="background-image:url('<?=$i?>')"></td>
        <?php $idx++; } ?>
        </tr>    
    </table><?php } ?>
</div>
<?php if(!$hideinfo) { ?>
<h2 class="ucase text-center"><span class='high-color'>Video</span> info</h2>
<table class="nd-info">
    <tr>
        <td class="nd-desc">
            <?=$a['description']?>
        </td>
    </tr><tr>    
        <td>
            <h5 class="high-color"><?php             
            $tj = @explode(",",$a['tags']);
            if($tj) foreach($tj as $t) {
                echo "<span class='nd-tag'>$t</span>";
            }            
            ?></h5>
        </td>
    </tr>
</table>
<?php } ?>
<div class="modal-scene">
    <img id="msimg">
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.2/plyr.css" integrity="sha512-SwLjzOmI94KeCvAn5c4U6gS/Sb8UC7lrm40Wf+B0MQxEuGyDqheQHKdBmT4U+r+LkdfAiNH4QHrHtdir3pYBaw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.2/plyr.min.js" integrity="sha512-5c+ic1AaqQ73rhjELeXI19EFx9KWd/LPFZ91ztP4x+MaufkHnpSEuLHcE6KwGn6G6I+ScYkSPONmrdGQh1GjiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function csub() {
        event.stopImmediatePropagation();
        $.ajax({
            method: 'post',
            url: '<?=$this->hook?>?_action=comment',
            data: { comment: $('#ctxt').val(),
                    video:'<?=$a['id']?>'
            },
            complete: function () {
                $('#csub').html('SUBMITTED!').prop('disabled',true);
            }
        });
    }
    
    function urat(rat) {
        event.stopImmediatePropagation();
        $.ajax({
            method: 'post',
            url: '<?=$this->hook?>?_action=rate',
            data: { rating: rat,
                    video:'<?=$a['id']?>'
            },
            complete: function () {
                $('#ldd').html("<span class='float-right high-color'>"+(rat>0?'LIKED!':'DISLIKED!')+"</span>");
            }
        });
    }
    
    function playAtt() {
        <?php if(app::memberUser()) { 
             if($a['premium_member_view_price']>0 || $a['free_member_view_price'] > 0) { ?>
                //alert(2);
                sshow("wallet");
                $('#topup').modal();
                aspo();
            <?php } 
            else { ?>
                //alert(3);
                sshow("sub");
                aspo();
            <?php } ?>
        <?php } 
        else {?>
            $('#signup').modal();aspo();
        <?php } ?>
    }
    
    $(()=> {
        $('*[data-zoom]').on('click',()=> {
            $('#msimg').attr("src",$(event.target).attr('data-zoom'));
            $('.modal-scene').addClass("active");
        });

        $('.modal-scene,#msing').on('click',()=>$('.modal-scene').removeClass("active"));
    });

    var opt<?=$decp?> = {};
    <?php if($playable) { ?>
    opt<?=$decp?>.controls = [
          'play-large', // The large play button in the center
          'restart', // Restart playback
          'rewind', // Rewind by the seek time (default 10 seconds)
          'play', // Play/pause playback
          'fast-forward', // Fast forward by the seek time (default 10 seconds)
          'progress', // The progress bar and scrubber for playback and buffering
          'current-time', // The current time of playback
          'duration', // The full duration of the media
          'mute', // Toggle mute
          'volume', // Volume control
          'captions', // Toggle captions
          'settings', // Settings menu
          'pip', // Picture-in-picture (currently Safari only)
          'airplay', // Airplay (currently Safari only)
          'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
          'fullscreen' // Toggle fullscreen              
      ];
      <?php if(!$nosett) { ?>                
          opt<?=$decp?>.settings = [
          'quality',
          'speed'
      ];
      opt<?=$decp?>.quality = {
          'default': <?=$att['height']?>,
          'options': [<?=$att['height']?>,720]
      };
      <?php }  ?>
      
    <?php } else { ?>
    opt<?=$decp?>.controls = [];
    <?php } ?>              
    const player<?=$decp?> = new Plyr('#vid<?=$decp?>',opt<?=$decp?>);
    <?php if($playable) { 
        if($nosett) { ?>
            player<?=$decp?>.source = {
                type: 'video',
                title: '<?=$a['title']?>',
                sources: [                  
                  {
                    src: '<?=$trailer?>',
                    type: 'video/mp4',
                    size: 720
                  }
                ],
                poster: '<?=$ent->meta($a,'poster')?>' };
        <?php } else {
        ?>
        
    player<?=$decp?>.source = {
  type: 'video',
  title: '<?=$a['title']?>',
  sources: [
    {
      src: '<?=$preb4vid?$preview:$video?>',
      type: 'video/mp4',
      size: <?=$att['height']?>
    },
    {
      src: '<?=$preb4vid?$preview:$videohd?>',
      type: 'video/mp4',
      size: 720
    },
  ],
  poster: '<?=$ent->meta($a,'poster')?>' };
    <?php } if(app::memberUser() && $preb4vid) { ?>
        document.getElementById('vid<?=$decp?>"').addEventListener('ended',handlePVE,false);
        function handlePVE(e) {
            e.target.medialoaded = ()=> {
                e.target.play();
            };
            e.target.src = '<?=$video?>';                            
        }
    <?php } } ?>    

</script>

<?php if($liveshow=="now") { ?>
<script src="https://unpkg.com/ion-sdk-js@1.5.5/dist/ion-sdk.min.js"></script>
<script src="https://unpkg.com/ion-sdk-js@1.5.5/dist/json-rpc.min.js"></script>
<script>

const liveVideo = document.querySelector(".nd-player-wrap video");
liveVideo.loop = true;
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
var signalLocal = new Signal.IonSFUJSONRPCSignal(serverUrl);
var clientLocal = new IonSDK.Client(signalLocal, config);

signalLocal.onerror = ()=> {
    signalLocal = new Signal.IonSFUJSONRPCSignal(serverUrl);
    clientLocal = new IonSDK.Client(signalLocal, config);
};

signalLocal.onopen = () => clientLocal.join("default");
clientLocal.ontrack = (track, stream) => {    
    console.log("got track", track.id, "for stream", stream.id);
    track.onunmute = () => {    
        liveVideo.srcObject = stream;           
        liveVideo.autoplay = true;
        //localVideo.controls = true;
        liveVideo.muted = true;
                
        // When this stream removes a track, assume
        // that its going away and remove it.
        stream.onremovetrack = () => {
            try {
                //chatSend.style.display = "none";
                liveVideo.srcObject = null;
            } catch (err) {}
        };      
    };    
};
</script>
<?php } ?>

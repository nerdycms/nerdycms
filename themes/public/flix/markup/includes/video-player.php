<?php 
    $ent = new video;    
    $preview = $ent->meta($this->pdata['video'],"preview");
    $video = VDIR."serve?url=".urlencode($this->pdata['video']["video_url"])."__.mp4";    
   // if(strpos('"height":"720"',$this->pdata['video']['attributes'])===false) {
        $video_1 = VDIR."serve?q=orig&url=".urlencode($this->pdata['video']["video_url"])."__.mp4";    
    //}
    $a = $this->pdata['video'];
    $ida = [];
    $idx  = 0;
    $tries = 20;
    do {
    //    do {
            //$idx = random_int(1, 20);        
            $idx += 1;
      //  } while (in_array($idx, $ida));
        $ida []= $idx;
        $ids = sprintf("%03d",$idx);
        $va = explode("/", explode("?", $a['video_url'])[0]); 
        $file = "slide_".urlencode($va[sizeof($va)-1]."__$ids.jpg");
        if(app::http_file_exists("https://nerdycms.b-cdn.net/upload/{$file}")) {
            $scenes []= VDIR."serve?url=$file";        
        } else {
            break;
        }
    } while(sizeof($scenes)<8 && $tries-->0);
    
    $scols = 4;
?>
<div class="nd-player-wrap">
    <?php if(!app::memberUser()) { ?>
    <div class="overlay">
        <button class="ucase hotbutton">Watch now</button>
    </div>
    <?php } ?>
    <h2 class="ucase nd-title"><?=$a['title']?> <span class="float-right">Rating: 100%</span></h2>
    <?php if(app::memberUser()) { ?>
    <video controls playsinline class="nd-player" autoplay>
        <source src="<?=$video?>" label="HD" type="video/mp4">
        <source src="<?=$video_1?>" label="UHD" type="video/mp4">
    </video>
    <?php } else { ?>
    <video data-poster="<?=$ent->meta($this->pdata["video"],'poster')?>" loop muted playsinline class="nd-player" autoplay>
        <source src="<?=$preview?>" label="PREVIEW" type="video/mp4">
    </video>
    <?php } ?>
    
    <h2 class="ucase nd-title mt0 text-left"><?=$a['duration']?> <?=$a['release_date']?> 
        <?php 
            $tj = @json_decode($a['models'],true);
            if($tj) { foreach($tj as $t) {
                echo "<span class='nd-model'>$t[value]</span>";
            }         }   
            ?>
        
        <span class="float-right"><?=$a['quality']?></span></h2>
    <h2 class="ucase">Video <span class="high-color">scenes</span></h2>
    <table class="nd-scenes">
        <tr>
        <?php $idx=0; foreach($scenes as $i) { if($idx>0 && $idx%$scols==0) echo "</tr><tr>"; ?>
            <td data-zoom="<?=$i?>" class="scene" style="background-image:url('<?=$i?>')"></td>
        <?php $idx++; } ?>
        </tr>    
    </table>
</div>
<h2 class="ucase text-center"><span class='high-color'>Video</span> info</h2>
<table class="nd-info">
    <tr>
        <td class="nd-desc">
            <h2><?=$a['description']?></h2>
        </td>
    </tr><tr>    
        <td>
            <h5 class="high-color"><?php 
            $tj = @json_decode($a['tags'],true);
            if($tj) foreach($tj as $t) {
                echo "<span class='nd-tag'>$t[value]</span>";
            }            
            ?></h5>
        </td>
    </tr>
</table>
<div class="modal-scene">
    <img id="msimg">
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.2/plyr.css" integrity="sha512-SwLjzOmI94KeCvAn5c4U6gS/Sb8UC7lrm40Wf+B0MQxEuGyDqheQHKdBmT4U+r+LkdfAiNH4QHrHtdir3pYBaw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.2/plyr.min.js" integrity="sha512-5c+ic1AaqQ73rhjELeXI19EFx9KWd/LPFZ91ztP4x+MaufkHnpSEuLHcE6KwGn6G6I+ScYkSPONmrdGQh1GjiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(()=> {
        $('*[data-zoom]').on('click',()=> {
            $('#msimg').attr("src",$(event.target).attr('data-zoom'));
            $('.modal-scene').addClass("active");
        });

        $('.modal-scene,#msing').on('click',()=>$('.modal-scene').removeClass("active"));
    });
        var opt = {};
        opt.controls = [
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
          
          /*opt.settings = { 'quality': {
              'default': 'HD',
              'options': ['HD','UHD']
          } };*/

    const player = new Plyr('video',opt );

</script>
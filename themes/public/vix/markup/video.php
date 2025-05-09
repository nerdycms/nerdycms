<?php if($name = app::request("_video")) {  
    $ent = new video;
    $a = $ent->fetch("linked",$name);
    $this->pdata["video"] = $a;
} else app::redirect("/");
$showchat = false;
$hidemore = @$this->pdata['cst']['hide_more_videos']=="on";
$hiderel = @$this->pdata['cst']['hide_related_videos']=="on";
$this->pdata['page_title'] = $a['title'];
$this->pdata['page_description'] = $a['description'];

$liveshow = $ent->meta($a,"liveshow");
if($liveshow=="now") { $hidemore = true; $showchat = true; }
?>
{{doc}}
    <head>
        {{head-main}}
    </head>
    <body>       
        {{back-to-top}}
        {{nav}}
        <table class="media-wrap">
            <tr id='nd-main'>
                <td class='nd-player-td text-center'>
                    {{video-player}}
                    <?php if(!$hiderel) { ?> <h2 class='ucase'>Related<span class='high-color'> videos</span> </h2> <?php } ?>
                </td>
                <?php if(!$hidemore) { ?> <td class="nd-player-desktop">
                    <h2 id="desk_title" class='ucase nd-title-center'><span class='high-color'>More</span> videos</h2>
                    {{video-wall|random|v}}
                </td> <?php } ?>
                <?php if($showchat) { ?> <td>                    
                    {{chat|group}}
                </td> <?php } ?>
            </tr>
            <?php if(!$hiderel) { ?> <tr>
                <td colspan="2">                    
                    {{video-wall|related|h}}
                </td>
            </tr>
            <?php } ?>
        </table>
        {{footer}}
        {{util-scripts}}        
    </body>
</html>    
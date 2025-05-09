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

$idx = @app::request("_idx")??1;
$ty = @app::request("_ty")??"scene";
$eidx = $ty=="gvl"?$idx-1:$idx;
$imgsrc = $ent->meta($a,"$ty:$eidx");
if(!$imgsrc || !app::http_file_exists($imgsrc)) $imgsrc = VDIR."loading.jpg";

$hidered = @$this->pdata['cst']['hide_video_release_date']=="on";    
$att = $ent->meta($a,"att");
$durs = $att['hours'].":".$att['mins'].":".$att['secs'];
$this->pdata['wall-small'] = true;
$this->pdata['meta_sub_post'] = " - ".($ty=='gvl'?"GALLERY IMAGE $idx":"SCENE $idx");
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
                    <h2 class="ucase text-left high-color"><?=$a['title']?><?=$this->pdata['meta_sub_post']?></h2>                    
                    <a href="<?=VDIR."video?_video=".app::request("_video")?>"><img class="galp-img" src="<?=$imgsrc?>"><a>
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
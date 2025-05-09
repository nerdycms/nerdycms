<div class="wrapper">
    <section>        
        <a href="<?=VDIR?>#section_<?=$data[1]?>3" class="arrow__btn">‹</a>
        <span class='sec-id' id="section_<?=$data[1]?>1"></span>
    
<?php
$wh = "";
switch($data[1]) {
    case "model":
        if($name = app::request("_model-name")) {
            $rs = app::slug($name, " ");            
        } 
        $wh = " AND models LIKE '%$rs%'";
        break;
    case "random":
    case "new":
        break;
    default:
        $wh = " AND tags LIKE '%$data[1]%'";
        break;   
}

$ent = new video(["where"=>"sexuality='Straight' AND publish_status='Published' $wh"]);
$list = $ent->fetch("array");
$vidlim = 13;
/* 
if($data[1]=="random") {    
    $nlist = [];
    $is = sizeof($list);
    do {
        do { $idx = random_int(0, $is-1); } while(!isset($list[$idx]));
    //    if(!app::http_file_exists($ent->meta($list[$idx],"preview"))) continue;
        $nlist []= $list[$idx];        
        unset($list[$idx]);
    } while(sizeof($nlist)<($vidlim+2));
    $list = $nlist;
} */

$idx = 0;
$seclim = 5;
$section = 2;
foreach($list as $row) {
    $poster = $ent->meta($row, "small-poster");
    if($poster=="https://new.nerdyvids.com") continue;  
    //if($poster=="https://new.nerdyvids.com" || !app::http_file_exists($ent->meta($row,"preview"))) continue;  
    //$sz = getimagesize($poster);        
    //$asp = $sz[0] / $sz[1];
    //if(abs($asp-1.7777777777777777)>0.1) continue;
    
    if($idx>0 && $idx % $seclim==0) {  ?>
        <a href="<?=VDIR?>#section_<?=$data[1]?><?=$section?>" class="arrow__btn">›</a>
    </section>    
    <section>      
        <a href="<?=VDIR?>#section_<?=$data[1]?><?=$section-1?>" class="arrow__btn">‹</a>
        <span class='sec-id' id="section_<?=$data[1]?><?=$section?>"></span>
<?php
     $section++; } ?>
        <a href="<?=app::asset("video")."?_video=".$row["seo_url"]?>" class="item video-item">
            <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($row, "preview")?>"></video>
            <div class="video-back" style="<?=$ent->meta($row, "small-background")?>"></div>
</a> <?php 
        if($idx++>$vidlim) break;
    }
?>      
        <a href="<?=VDIR?>#section_<?=$data[1]?>1" class="arrow__btn">›</a>
    </section>    
</div>
<div class="wrapper">
    <section>                
<?php
$wh = "";
$key = "array";
$vidlim = 4;
switch(@$data[1]) {
    case "featured":
        $wh = " AND show_on_homepage='Yes'";
        break;
    case "model":
        $vidlim = 1;
        if($name = app::request("_model-name")) {
            $rs = app::slug($name, " ");            
        } 
        $wh = " AND models LIKE '%$rs%'";
        break;
    case "top":
        $key = "popular";
        break;
    case "most":
        break;
    case "random":
        break;
    case "new":
        $key = "newest";
        break;
    default:
        if(!empty($data[1])) $wh = " AND tags LIKE '%$data[1]%'";
        break;   
}

$ent = new video(["where"=>"sexuality='Straight' AND publish_status='Published' $wh"]);
$list = $ent->fetch($key);

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
$seclim = 3;
$section = 2;
foreach($list as $row) {
    //$poster = $ent->meta($row, "poster");
    //if($poster=="https://new.nerdyvids.com") continue;  
    //if($poster=="https://new.nerdyvids.com" || !app::http_file_exists($ent->meta($row,"preview"))) continue;  
    //$sz = getimagesize($poster);        
    //$asp = $sz[0] / $sz[1];
    //if(abs($asp-1.7777777777777777)>0.1) continue;
    
    if($idx>0 && $idx % $seclim==0) {  ?>
        
    </section>    
    <section>      
        
<?php
     $section++; } 
        $preview = $ent->meta($row,"preview"); 
        $background = $ent->meta($row,"med-background"); 
        $title = $ent->meta($row,"title"); 
        ?>
        <a href="<?=app::asset("video")."?_video=".$row["seo_url"]?>" class="item video-item">
            
            <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$preview?>"></video>
            <div class="video-back" style="<?=$background?>"></div>
            <div class="overlay-text hover-title"><?=$title?></div>
</a> <?php 
        if($idx++>$vidlim) break;
    }
    while($idx<$vidlim+2) {   if($idx>0 && $idx % $seclim==0) {  ?>
        
    </section>    
    <section>      
        
<?php
     $section++; } ?>
           <a href="<?=VDIR?>" class="item video-item">
            
            <video loop muted playsinline class="overlay high-bkg" style="opacity:.2;border:solid 10px rgba(127,127,127,.15)"></video>
            <div class="video-back"></div>
            <div class="overlay-more">...</div>
</a> 
    <?php $idx++; }
?>      
        
    </section>    
</div>
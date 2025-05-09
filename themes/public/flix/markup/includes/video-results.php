<?php

$wh = "";
/*switch($data[1]) {
    
}*/

$ent = new video(["where"=>"sexuality='Straight' AND publish_status='Published' $wh"]);
$list = $ent->fetch("array");

$vidlim = 12;
if(@$data[1]=="random") {    
    $nlist = [];
    $is = sizeof($list);
    do {
        do { $idx = random_int(0, $is-1); } while(!isset($list[$idx]));
    //    if(!app::http_file_exists($ent->meta($list[$idx],"preview"))) continue;
        $nlist []= $list[$idx];        
        unset($list[$idx]);
    } while(sizeof($nlist)<($vidlim+2));
    $list = $nlist;
} 
$l=0; ?>

<section class='results-<?=$data[1]?>'> <?php while($l<$vidlim) { ?>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video></a>
<?php } ?>
</section> 
{{pager|bottom}}
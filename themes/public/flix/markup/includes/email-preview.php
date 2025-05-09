<?php
$mode = isset($data[1])?$data[1]:"home";
if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new video(["where"=>"models LIKE '%$rs%' AND publish_status='Published'"]);
    $mode = "model";
} else {
    $ent = new video(["where"=>"sexuality='Straight' AND show_on_homepage='Yes' AND publish_status='Published'"]);
}
$list = $ent->fetch("array");
if(sizeof($list)>4) {
    do {    
        $a = $list[random_int(0, sizeof($list)-1)];        
    } while($ent->meta($a,"poster")=="https://new.nerdyvids.com" || !app::http_file_exists($ent->meta($a,"preview")));
} else {
    $a = @$list[0];
}
if(!$a) app::redirect("/bio-coming-soon"); ?>  
<img src="<?=$ent->meta($a,"poster")?>">
<?php
$a = null;
$name = app::request("_model-name");
$namer = app::slug($name, " ");
if(!empty($name)) {    
    $ent = new video(["where"=>"models LIKE '%$namer%' AND publish_status='Published'"]);  
} 
$list = $ent->fetch("array"); 
if(sizeof($list)>0) {
    $idx = $idx>1?random_int(0, sizeof($list)-1):1;
    //while($idx < sizeof($list)) $idx++;
    $a = $list[$idx]; 
    $key = "background";
}
$ent2 = new model;
$m = $ent2->fetch("by","model_name",$namer);
if(!empty($m['banner_url'])) {
    $key="banner";
    $a = $m;
    $ent = $ent2;
}
if($a) {
?>

<div class="preview model-scene model-still"  style="<?=$ent->meta($a,$key)?>">               
    
</div> <?php } ?>

<?php
if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new video(["where"=>"models LIKE '%$rs%' AND publish_status='Published'"]);  
} 
$list = $ent->fetch("array"); 
$idx = 0;
while($idx < sizeof($list) && $ent->meta($list[$idx],"poster")=="https://new.nerdyvids.com") $idx++;
if($idx < sizeof($list)) { $a = $list[$idx]; ?>

<div class="preview model-scene"  style="<?=$ent->meta($a,"background")?>">               
    <div>
        <h1 class='ucase'>LATEST SCENE</h1>            
        <button class="ucase hotbutton">Watch now</button>
    </div>        
</div>

<?php } ?>
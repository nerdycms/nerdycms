<?php

    $ent = new video(["where"=>"release_date>'".date('Y-m-d H:i:s')."' AND publish_status='Published'"]);  

if(sizeof($list = $ent->fetch("array"))<1) {
    $ent = new video(["order"=>"created desc","where"=>"publish_status='Published'"]);  
    $idx = 0;
    $list = $ent->fetch("array");    
} else {
    $idx = sizeof($list>1)?random_int(0, sizeof($list)-1):0;
}
//while($idx < sizeof($list)) $idx++;
$a = $list[$idx]; 

?>


                
<div class="col-md-12 cwrap">
    <video autoplay muted class="col-md-12 text-left " src="<?=$ent->meta($a, "preview")?>">"></video>                    
    <h1 id="demo" class="mt80" style="color:#fff"><span><?=$a['title']?><br><?=$a['release_date']?><br><?=$a['models']?></span></h1>
</div>
                


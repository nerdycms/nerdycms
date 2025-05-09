<?php    
    $ent = new blog();
    if(!($a = $ent->fetch("by","slug",app::request("_id")))) $a = $ent->fetch("id",app::request("_id")); 
    
    if($a) {?>
    
<div class="blog blog-large">
    <div class="title">
        <div class="float-right">
            <?=$a['updated']?>
        </div>
        <?=$a['title']?>
    </div>
    <div class="body">
        <?=$a['body']?>
    </div>    
    <div class="float-left">
        <a class="hotbutton" href="<?=VDIR?>blog">Back</a>
    </div>
    </div> <?php } ?>
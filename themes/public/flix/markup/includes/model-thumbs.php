<div class="wrapper">
    <section id="">        
        <a href="<?=VDIR?>#msection_<?=$data[1]?>3" class="arrow__btn">‹</a>
        <span class='sec-id' id="msection_<?=$data[1]?>1"></span>
    
<?php
$ent = new model(["where"=>"gender='Female'"]);
$list = $ent->fetch("array");

$vidlim = 13;
/*$vidlim = 13;
if($data[1]=="random") {    
    $nlist = [];
    $is = sizeof($list);
    do {
        do { $idx = random_int(0, $is-1); } while(!isset($list[$idx]));
        $vids = new video(["where"=>"models LIKE '%{$list[$idx]['model_name']}%' AND publish_status='Published'"]);
        if(!$vids->count()) continue;
        
        $nlist []= $list[$idx];        
        unset($list[$idx]);
    } while(sizeof($nlist)<($vidlim+2));
    $list = $nlist;
}*/

$idx = 0;
$seclim = 5;
$section = 1;
foreach($list as $row) {
    $poster = $ent->meta($row, "small-background");
    if($idx>0 && $idx % $seclim==0) {  $section++;?>
        <a href="<?=VDIR?>#msection_<?=$data[1]?><?=$section?>" class="arrow__btn">›</a>
    </section>    
    <section>        
        <a href="<?=VDIR?>#msection_<?=$data[1]?><?=$section-1?>" class="arrow__btn">‹</a>
        <span class='sec-id' id="msection_<?=$data[1]?><?=$section?>"></span>
<?php
    } ?>
        <a href="<?=app::asset("model")."?_model-name=".$ent->meta($row,"seo-name")?>" class="item">
            <div class="overlay"></div>
            <div class="overlay-text high-color"><?=$ent->meta($row,"label")?></div>
            <div class="back" style="<?=$poster?>"></div>
</a> <?php 
        if($idx++>$vidlim) break;
    }
?>      
        <a href="<?=VDIR?>#msection_<?=$data[1]?>1" class="arrow__btn">›</a>
    </section>
</div>
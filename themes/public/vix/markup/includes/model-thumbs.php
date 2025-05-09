<div class="wrapper wrapper-models">
    <section id="">                
    
<?php
$ent = new model(["where"=>"gender='Female'"]);
$list = $ent->fetch("array");

$vidlim = 3;
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
    $poster = $ent->meta($row, "background");
    if($idx>0 && $idx % $seclim==0) {  $section++;?>
        
    </section>    
    <section>                
<?php
    } ?>
        <a href="<?=app::asset("model")."?_model-name=".$ent->meta($row,"seo-name")?>" class="item">
            <div class="overlay"></div>
            
            <div class="back" style="<?=$poster?>"></div>
            <div class="text-center bottom-text"><?=$ent->meta($row,"label")?></div>
</a> <?php 
        if($idx++>$vidlim) break;
    }
?>      
        
    </section>
</div>
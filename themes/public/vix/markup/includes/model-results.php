<?php
$list = $this->pdata['list'];
$vidlim = $this->pdata['listsize'];
$cp = ($cp = app::request("p"))?$cp:"1"; 
$l = ($cp-1)*$vidlim;
$stop = $l+$vidlim;
if($stop>sizeof($list)) $stop = sizeof($list);

?>
<section class='model-results-<?=$data[1]?>'> <?php while($l<$stop) { ?>
    <a href="<?=app::asset("model")."?_model-name=".$ent->meta($list[$l],"seo-name")?>" class='wall-item' style="<?=$ent->meta($list[$l], "med-background")?>">
        <div class="overlay-text high-color"><?=$ent->meta($list[$l++],"label")?></div>
    </a>
<?php } ?>
</section>
{{pager|bottom}}
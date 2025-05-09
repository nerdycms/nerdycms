<?php
$ent = new model();
$list = $ent->fetch("array"); 
$l=0; ?>
<section class='model-results-<?=$data[1]?>'> <?php while($l<50 && $l<sizeof($list)) { ?>
    <a href="<?=app::asset("model")."?_model-name=".$ent->meta($list[$l],"seo-name")?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <div class="overlay-text high-color"><?=$ent->meta($list[$l++],"label")?></div>
    </a>
<?php } ?>
</section>
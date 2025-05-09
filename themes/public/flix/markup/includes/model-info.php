<?php
if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new model();
    $a = $ent->fetch("named",$rs);
} else app::redirect("/");
?>
<table class="model-info">
    <tr>
    <td class="pic no-mobile" style="<?=$ent->meta($a,"background")?>"></td>
    <td class="bio">
        <h1 class="ucase"><?=$a['model_name']?></h1>        
        <h5>Gender : <span class="high-color"><?=str_replace("â€™", "'", $a['gender'] ?? '')?></span></h5>
        <h5>Sexuality : <span class="high-color"><?=str_replace("â€™", "'", $a['sexuality'] ?? '')?></span></h5>
        <h5>Place of birth : <span class="high-color"><?=str_replace("â€™", "'", $a['place_of_birth'] ?? '')?></span></h5>
        <h1 class="ucase">Bio</h1>
        <h5><?=str_replace("â€™", "'", $a['description'] ?? '')?></h5>
        <br><br>
        {{big-scene}}        
    </td>
</tr>
</table>
<?php

if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new video(["where"=>"models LIKE '%$rs%' AND publish_status='Published'"]);
    $mode = "model";
} 
$list = $ent->fetch("array");
$scenes = [];
if(sizeof($list)>3) {
    do {    
        $a = $list[random_int(0, sizeof($list)-1)];        
    } while($ent->meta($a,"poster")=="https://new.nerdyvids.com" || !app::http_file_exists($ent->meta($a,"preview")));
} else {
    $a = $list[0];
    $ida = [];
    do {
        do {
            $idx = random_int(1, 7)*3;        
        } while (in_array($idx, $ida));
        $ida []= $idx;
        $ids = sprintf("%03d",$idx);
        $va = explode("/", explode("?", $a['video_url'])[0]);
        
        $scenes []= str_replace("compat_","",$va[sizeof($va)-1])."_$ids.jpg";        
    } while(sizeof($scenes)<4);
}
?>  
<table class="model-scenes">
    <tr> 
        <?php foreach($scenes as $i) { ?>
        <td data-zoom="<?="https://new.nerdyvids.com/storage/slides/large_".$i?>" class="scene" style="background-image:url('<?="https://new.nerdyvids.com/storage/slides/small_".$i?>')">
            
        </td> 
        <?php } ?>
    </tr>
</table>
<div class="modal-scene">
    <img id="msimg">
</div>
<script>
$(()=> {
    $('*[data-zoom]').on('click',()=> {
        $('#msimg').attr("src",$(event.target).attr('data-zoom'));
        $('.modal-scene').addClass("active");
    });
    
    $('.modal-scene,#msing').on('click',()=>$('.modal-scene').removeClass("active"));
});
</script>

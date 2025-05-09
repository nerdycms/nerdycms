<?php
if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new video(["where"=>"models LIKE '%$rs%' AND publish_status='Published'"]);
    $mode = "model";
} 
$list = $ent->fetch("array");
    $mas = [];
    $scols=2;
    foreach($list as $l) {
        $scenes = [];
        $this->pdata['video'] = $l;
        $gvl = @json_decode(@$l['image_gallery'],true);
        $att = json_decode($this->pdata['video']['attributes'],true);    
        $dur = $att['hours'] * 3600 + $att['mins']*60 + $att['secs'];
        $fr = 30;       
        if($dur<180) $fr = 10;
        if($dur>600) $fr = 60;

        $tslides = floor($dur/$fr);
        $step = floor($tslides/8);    
        if($step==0) $step = 1;
        /*for($idx=1;$idx<=$tslides;$idx+=$step) {
            $ids = sprintf("%03d",$idx);
            $va = explode("/", explode("?", $a['video_url'])[0]); 
            $file = urlencode($va[sizeof($va)-1]."__$ids.jpg");        
            if(sizeof($scenes) < 8) $scenes []= $file;//VDIR."serve?url=$file";        
        }
        if($gvl) {
            for($fi=0;$fi<8;$fi++) {
                if(!empty($gvl[$fi])) $scenes[$fi] = VDIR."serve?url=$gvl[$fi]";        
            }
        }*/
        
            for($idx=1;$idx<=$tslides;$idx+=$step) {
                /*$va = explode("/", explode("?", $a['video_url'])[0]); 
                $ids = sprintf("%03d",$idx);
                if(($sz = sizeof($va))>1) {        
                    $file = $va[$sz-2]."/slides/med_".urlencode($va[$sz-1]."__$ids.jpg");        
                    if(sizeof($scenes) < $scols*2) $scenes []= VDIR."serve?url=$file";        
                }*/
                if(sizeof($scenes) < $scols*2) {            
                    $sc = $ent->meta($a,"scene:$idx");
                    if($sc) $scenes []= $sc;
                    else break;
                } else break;
            }

            for($fi=0;$fi<8;$fi++) {
                $sc = $ent->meta($a,"gvl:$idx");
                if($sc) $scenes[$fi] = $sc;        
                else break;
            }

        
        $mas []= $scenes;
    }
    $ns = [];
    while(sizeof($mas)>0 && sizeof($ns) < 8) {
        $i1 = random_int(0, sizeof($mas)-1);
        $i2 = random_int(0, sizeof($mas[$i1])-1);
        $ns []= $mas[$i1][$i2];
    }
    $scenes = $ns;
?>  
<table class="model-scenes">
    <tr> 
        <?php foreach($scenes as $i) { ?>
        <td data-zoom="<?=$i?>" class="scene" style="background-image:url('<?=$i?>')">
            
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

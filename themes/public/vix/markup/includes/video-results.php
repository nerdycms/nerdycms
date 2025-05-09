<?php

if(!isset($this->pdata['list'])) {        
    if(!empty(@$data[1])) {
        $termt = $data[1];
        $terma = explode('|',$termt);
        foreach($terma as $term) {
            $st = '%'.app::slug($term," ").'%';
            $wh .= " OR (tags LIKE '$st' OR category LIKE '$st' OR title LIKE '$st' or models LIKE '$st')";
        }
        $wh = substr($wh,4);
        $wh = " AND ($wh)";                
    } else $wh = "";

    $ent = new video(["where"=>"casting_on is null AND sexuality='Straight' AND publish_status='Published' $wh"]);
    $list = $ent->fetch("valid");        
    $vidlim = empty(@$data[2])?12:$data[2];
    $standalone = true;
    $data[1] = "default";
} else {
    $ent = new video;    
    $list = $this->pdata['list'];
    $vidlim = $this->pdata['listsize'];
    $standalone = false;
}

$cp = ($cp = app::request("p"))?$cp:"1"; 
$l = ($cp-1)*$vidlim;
$stop = $l+$vidlim;
if($stop>sizeof($list)) $stop = sizeof($list);
if(!$standalone) {
    if($tagl = @$this->pdata['page_header']) {
        echo "<h1>$tagl</h1>";
    } else if(isset($termt)) {
        echo "<h1>Results for '$termt'</h1>";
    }
}

$wat = new walletTransaction;                    
?>

<section class='results-<?=$data[1]?>'> <?php while($l<$stop) { ?>
    <a  href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "med-background")?>"> 
        <?php if(isset($list[$l]['_tagline'])) { ?>
        <div class="overlay ovl-res">
            <button type='button' class="ucase hotbutton"><?=$list[$l]['_tagline']?> videos</button>
        </div>    
        <?php } else if($ent->meta($list[$l], "effprice")>0) { ?>
        <div class="overlay ovl-res">
            <?php $v = $ent->fetch("linked",$list[$l]['seo_url']);
                  if($v && $wat->fetch("own",'video',$v['id'],app::memberUser())) { ?>
            <button type='button' class="ucase hotbutton">Purchased!</button>
            <?php } else { ?>
            <button type='button' class="ucase hotbutton">Watch now <?="for $".number_format($ent->meta($list[$l], "effprice"),2)?></button>
            <?php } ?>
        </div>
        <?php } ?>
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video></a>
<?php } ?>
</section> 
<?php if(!$standalone) { ?>{{pager|bottom}}<?php } ?>
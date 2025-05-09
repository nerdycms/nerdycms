<?php
$wh = "";
$standalone = false;
switch(@$data[1]) {
    case "random":
        break;
    case "related":
        $tj = @json_decode($this->pdata['video']['tags'],true);
        if(!$tj || sizeof($tj)<2) {
            $data[1] = "random";
        } else {
            $whs = "";
            foreach ($tj as $t) {
                $whs .= " OR tags LIKE '%{$t['value']}%'";
            }
            $whs = substr($whs, 4);
            $wh = " AND ($whs)";
        }
        break;    
    default:
        if(empty($data[2])) $data[2] = 'h';
        if(!empty(@$data[1])) {
            $term = $data[1];
            $st = '%'.app::slug($term," ").'%';
            $wh = " AND (tags LIKE '$st' OR category LIKE '$st' OR title LIKE '$st' or models LIKE '$st')";
        } else $wh = "";                
        $standalone = true;
        break;
}
if(isset($this->pdata['video'])) {
    $ent = new video(["where"=>"id!={$this->pdata['video']['id']} AND sexuality='Straight' AND publish_status='Published' $wh"]);
} else {
    $ent = new video(["where"=>"casting_on is null AND sexuality='Straight' AND publish_status='Published' $wh"]);                
}
$list = $ent->fetch("valid");

$sm = @$this->pdata['wall-small']??false;
//if($data[1]=="random") {    
  /*  $nlist = [];
    $is = sizeof($list);
    do {
        do { $idx = random_int(0, $is-1); } while(!isset($list[$idx]));
    //    if(!app::http_file_exists($ent->meta($list[$idx],"preview"))) continue;
        $nlist []= $list[$idx];        
        unset($list[$idx]);
    } while(sizeof($nlist)<($vidlim+2));
    $list = $nlist;*/
//} 
$l=0; 

if($standalone) echo "<style>.wall-h { height: 15rem} </style>";

?>

<section class='wall-<?=$data[2]?>'>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video></a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>    
    <?php if($data[2]!="h" && !$sm) { ?>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>    
    <?php } ?>
</section>
<?php if($data[2]=="h") { ?>
<section class='wall-<?=$data[2]?>'>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>
    <a href="<?=app::asset("video")."?_video=".$list[$l]["seo_url"]?>" class='wall-item' style="<?=$ent->meta($list[$l], "small-background")?>">
        <video autoplay loop muted playsinline class="overlay hover-src" data-src="<?=$ent->meta($list[$l++], "preview")?>"></video>
    </a>    
</section> <?php } ?>
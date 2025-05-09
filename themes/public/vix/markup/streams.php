<?php
$wh = "";

if($term = app::request("_search")) {
    $st = '%'.app::slug($term," ").'%';
    $wh = " AND (tags LIKE '$st' OR category LIKE '$st' OR title LIKE '$st')";
}

$ent = new video(["where"=>"casting_on is not null AND sexuality='Straight' AND publish_status='Published' $wh"]);
$list = $ent->fetch($sort = app::request("_sort")??"popular");

$vidlim = 12;
/*if(@$data[1]=="random") {    
    $nlist = [];
    $is = sizeof($list);
    do {
        do { $idx = random_int(0, $is-1); } while(!isset($list[$idx]));
    //    if(!app::http_file_exists($ent->meta($list[$idx],"preview"))) continue;
        $nlist []= $list[$idx];        
        unset($list[$idx]);
    } while(sizeof($nlist)<($vidlim+2));
    $list = $nlist;
} */
$l=0; 

$this->pdata['list'] = $list;
$this->pdata['listsize'] = $vidlim;

$hascats = @$this->pdata['cst']['hide_video_categories']!="on";
$tagl = @$this->pdata['cst']['video_list_tagline'];
    
?>

{{doc}}
    <head>
        {{head-main}}
    </head>
    <body class="nav-offset">       
        {{back-to-top}}
        {{nav}}        
        <?=!empty($tagl)?"<h2 class='ucase text-center'>$tagl</h2>":""?>        
        <a href="<?=$this->hook?>?_sort=popular" class='<?=$sort=="popular"?"btn-prim":"btn-sec"?> btn-rounded'>Popular</a><a href="<?=$this->hook?>?_sort=newest" class='<?=$sort=="newest"?"btn-prim":"btn-sec"?> btn-rounded'>Newest first</a><a href="<?=$this->hook?>?_sort=oldest" class='<?=$sort=="oldest"?"btn-prim":"btn-sec"?> btn-rounded'>Oldest first</a>
        <div class="clearfix"></div>
        <div class='row'>
            <?php if($hascats) { ?>
            <div class='col-md-2 no-mobile'>{{video-cats|cats}}</div>
            <div class='col-md-10'>
                {{pager|top}}
                <div id='mobcats_t' style='display: none'>
                {{video-cats|cats p50}}
                </div>
                {{video-results|default}}
            </div>
            <?php } else { ?>
            <div class='col-md-12'>
                {{pager|top}}                
                {{video-results|default}}
            </div>
            <?php } ?>
        </div>        
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
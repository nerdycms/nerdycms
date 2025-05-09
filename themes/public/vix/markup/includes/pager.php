<?php
    $grp = app::request("_group");
    $gs = empty($grp)?"":"&_group=$grp";
    $qual = ($qual = app::request("q"))?$qual:"all"; 
    $cp = ($cp = app::request("p"))?$cp:"1"; 
    $maxp = ceil(sizeof($this->pdata['list'])/$this->pdata['listsize']);
    
    $hasqual = @$this->pdata['cst']['hide_video_quality_selector']!="on";
    $hidetop = @$this->pdata['cst']['hide_top_pagination']=="on";
    if(!($hidetop && $data[1]=="top")) { ?>

<div class="pagination-wrapper <?=$data[1]?>">
    <?php if($hasqual && $this->hook!="/blog" && $this->hook!="/models" && $grp!="models") { ?>
  <div class="pagination no-mobile">
    <a class="prev page-numbers<?=$qual=="all"?" current":""?>" href="<?=$this->hook."?p=$cp".$gs?>&q=All">All</a>
    <a class="page-numbers<?=$qual=="4k"?" current":""?>" href="<?=$this->hook."?p=$cp".$gs?>&q=4K">4K</a>
    <a class="page-numbers<?=$qual=="hd"?" current":""?>"  href="<?=$this->hook."?p=$cp".$gs?>&q=HD">HD</a>    
    <a class="next page-numbers<?=$qual=="sd"?" current":""?>"  href="<?=$this->hook."?p=$cp".$gs?>&q=SD">SD</a>
  </div> 
      <div class='pagination no-desktop filter'>
        <a onclick="$('#mobcats_t').slideToggle()" href="javascript:;"><i class='fa fa-filter'></i></a>
    </div>  
    <?php } ?>
  <div class="pagination">
      <a class="prev page-numbers <?=$cp==1?"disabled":""?>" <?php if($cp>1) echo "href='$this->hook?q=$qual&p=".($cp-1).$gs."'"; ?>>prev</a>
            <?php
            if($maxp < 10) { 
                for($pg=1;$pg<=$maxp;$pg++) { ?>                     
                    <a class="page-numbers<?=$cp==$pg?" current":""?>" href="<?=$this->hook."?q=$qual&p=$pg".$gs?>"><?=$pg?></a>
                <?php } ?>           
            <?php } else if($cp>4 && $cp<$maxp-3) { ?>
                <a class="page-numbers" href="<?=$this->hook."?q=$qual&p=1".$gs?>">1</a>
                <a class="page-numbers">...</a>
                <?php 
                for($pg=$cp-2;$pg<$cp+4;$pg++) { ?>                     
                    <a class="page-numbers<?=$cp==$pg?" current":""?>" href="<?=$this->hook."?q=$qual&p=$pg".$gs?>"><?=$pg?></a>
                <?php } ?>           
                <a class="page-numbers">...</a>
                <a class="page-numbers" href="<?=$this->hook."?q=$qual&p=$maxp".$gs?>"><?=$maxp?></a>
            <?php } else {
                for($pg=1;$pg<5;$pg++) { ?>                     
                    <a class="page-numbers<?=$cp==$pg?" current":""?>" href="<?=$this->hook."?q=$qual&p=$pg".$gs?>"><?=$pg?></a>
                <?php } ?>
                    <a class="page-numbers">...</a>
                <?php
                for($pg=$maxp-3;$pg<=$maxp;$pg++) { ?>                     
                    <a class="page-numbers<?=$cp==$pg?" current":""?>" href="<?=$this->hook."?q=$qual&p=$pg".$gs?>"><?=$pg?></a>
                <?php } } ?>
      <a class="next page-numbers <?=$cp==$maxp?"disabled":""?> " <?php if($cp<$maxp) echo "href='$this->hook?q=$qual&p=".($cp+1).$gs."'"; ?>>next</a>                
  </div>    
</div>
    <?php } ?><div></div>
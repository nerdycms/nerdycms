<?php 
    $ent = new blog();
    $arr = $ent->fetch("array");
    foreach($arr as $a) {
        ?> 
<div class="container mt-5">
  <div class="row">
    <div class="col-12">
      <article class="blog-card">
        <div class="blog-card__background">
          <div class="card__background--wrapper">
            <div class="card__background--main" style="background-image: url('<?=$ent->meta($a,"poster")?>');">
              <div class="card__background--layer"></div>
            </div>
          </div>
        </div>
        <div class="blog-card__head">
          <span class="date__box">            
            <span class="date__month"><?=$a['updated']?></span>
          </span>
        </div>
        <div class="blog-card__info">
          <h5 class="ucase"><?=$a['title']?></h5>
          <p>
            <a href="#" class="icon-link mr-3"><i class="fa fa-pencil-square"></i> <?=$ent->meta($a,'creator')?></a>
            <a href="#" class="icon-link"><i class="fa fa-comments"></i> 150</a>
          </p>
          
          <p><div class="clip"><?=$a['body']?></div></p>
          <a href="<?=$ent->meta($a,'link')?>" class="btn btn--with-icon"><i class="btn-icon fa fa-long-arrow-right"></i>READ MORE</a>
          TAGS: <a class='tag ucase'><?=implode('</a> <a class="tag ucase">',explode(",",$a['tags']))?></a>
        </div>
      </article>
    </div>
  </div>
</div>            
            <?php
    }
<?php 
    $mnu = new customMenuItem;    
    $arr = $mnu->fetch("array"); ?>
<div class="join-container">
     
    <?php if($mid = app::memberUser()) { 
        $ann = new announce(["where"=>"target_id=$mid AND IFNULL(been_read,'')!='Yes'"]);
        $numa = sizeof($ann->fetch("array"));        
        ?>    
    <button onclick="window.location.href='<?=app::asset("profile")?>'" class='nav-lg with-sub'><i class='fa fa-user'></i><?=$numa>0?"<span class='sub'>$numa</span>":""?></button>
    <button onclick="window.location.href='<?=app::asset("sign-out")?>'" class='nav-lg'><i class='fa fa-sign-out'></i></button>
    <?php } else { ?>
    
    <button onclick="$('#signin').modal();sshow('login')" class='nav-lg'>Sign in</button>
    <button onclick="$('#signup').modal();aspo();sshow('create')" class="large nav-lg">Get access!</button>
    <?php } ?>
    <div class="nav-sm">        
        <nav class="menu">
            {{auth|signup}}
            <?php if(!app::memberUser()) { ?>
            <a onclick="$('#signup').modal();aspo();sshow('create')" class="access-label ucase">Get access!</a> 
            <?php } ?>
            <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open"/>
            <label class="menu-open-button" for="menu-open">
              <span class="hamburger hamburger-1"></span>
              <span class="hamburger hamburger-2"></span>
              <span class="hamburger hamburger-3"></span>
            </label>

            <a href="<?=app::asset("videos")?>" class="menu-item"> <i class="fa fa-tv"></i> <span class="float-label ucase">Videos</span> </a>
            <!--<a href="<?=app::asset("categories")?>" class="menu-item"> <i class="fa fa-list"></i> <span class="float-label ucase">Categories</span> </a>-->
            <a href="<?=app::asset("models")?>" class="menu-item"> <i class="fa fa-users"></i> <span class="float-label ucase">Models</span> </a>
            <a href="<?=app::asset("blog")?>" class="menu-item"> <i class="fa fa-random"></i> <span class="float-label ucase">Blog</span> </a>
            <a href="<?=app::asset("video-chat")?>" class="menu-item"> <i class="fa fa-sms"></i> <span class="float-label ucase">Videochat</span> </a>            
            <?php if(!app::memberUser()) { ?>
            <a onclick="$('#signin').modal();sshow('login')" class="menu-item"> <i class="fa fa-sign-in-alt"></i> <span class="float-label ucase">Sign in</span> </a>            
            <?php } else { ?>
            <a href="<?=app::asset("profile")?>" class="menu-item"> <i class="fa fa-user"></i> <span class="float-label ucase">Profile</span> </a>            
            <a href="<?=VDIR."logout.php"?>" class="menu-item"> <i class="fa fa-sign-out-alt"></i> <span class="float-label ucase">Sign out</span> </a>            
            <?php } ?>
            <?php     
                if(sizeof($arr)>0) {
            ?>
                <a onclick="$('#rsMoreMenu').addClass('in')" class="menu-item"> <i class="fa fa-ellipsis-v"></i> <span class="float-label ucase">More</span> </a>            
            <?php   } ?>
          </nav>
        
    </div>
</div>
<div class="overlay-logo">        
    <a href="<?=app::asset("/")?>"><h2><span class='high-color ucase'>NERDY<span class="text-color">CMS</span></span></h2></a>        
</div>
<div class="links-container nav-sm" style="height: 113.59px">
    
</div>
<div class="links-container nav-lg">    
    <a href="<?=app::asset("videos")?>">Videos</a>
    <!--<a href="<?=app::asset("categories")?>">Categories</a>-->
    <a href="<?=app::asset("models")?>">Models</a>
    <a href="<?=app::asset("blog")?>">Blog</a>
    <a href="<?=app::asset("video-chat")?>">Videochat</a>
    
    <?php     
    if(sizeof($arr)>0) {
    ?>
  
    <div class="dropdown d-inline-block">
        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          More
        </a>

        <ul class="dropdown-menu bg-transparent"> <?php foreach ($arr as $a) { ?>
          <li><a class="dropdown-item" href="<?=$a['url']?>"><?=$a['title']?></a></li>
          <?php }  ?>
        </ul>
    </div>    
</div>
<div id="rsMoreMenu" class="right-slider">
    <span onclick="$('.right-slider').removeClass('in')" class="close">X</span>
    <?php foreach ($arr as $a) { ?>
          <a class="ucase" href="<?=$a['url']?>"><?=$a['title']?></a>
    <?php }  ?>
</div>
<?php } else { echo "</div>"; } ?>
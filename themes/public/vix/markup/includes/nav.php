    <?php     
    $mnu = new customMenuItem;    
    $arr = $mnu->fetch("array"); 
    
    $hidecats = @$this->pdata['cst']['hide_categories']=="on";
    $hidetags = @$this->pdata['cst']['hide_tags']=="on";
    $hideblog = @$this->pdata['cst']['hide_blog']=="on";
    $hidechat = @$this->pdata['cst']['hide_chat']=="on";
    $hidelive = false;//true;//@$this->pdata['cst']['hide_live']=="on";
        
    if(!app::memberUser()) { ?>
    {{auth|signup}}
    <?php } else { ?>
    {{auth|wallet}}
    <?php } ?>
            
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar links-container">
      <div class="container">
          <a class="navbar-brand logo" href="/"><?=is_file(COM_CONTENT_DIR."/dark_logo.png")?"<img class='dark-only' style='height:45px' src='".VDIR."content/common/dark_logo.png'><img class='light-only' style='height:45px' src='".VDIR."content/common/light_logo.png'>":'<span class="high-color">'.BRAND_NAME.'</span>'?></a>
          <?php 
          if(!app::memberUser()) { ?>
            <ul class="navbar-nav d-lg-none custom-nav right-nav">            
            <li class="nav-item">
              <a class="nav-link join pull-left" onclick="sshow('create')">GET ACCESS <i class="fas fa-angle-double-right fa-1x"></i></a>              
            </li>
          </ul>
          <a class="nav-link d-lg-none" onclick="sshow('login')">&nbsp;&nbsp;<i class="fa fa-sign-in-alt"></i></a>
        <?php } ?>
          
        <button onclick="$('.navbar-collapse').toggleClass('show')" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7"
          aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
          <i class="nbt fa fa-bars"></i>
        </button>
          
          <div class="collapse navbar-collapse" id="navbarSupportedContent-7" style="width: 100%">
          <ul class="navbar-nav custom-nav mr-auto" >
            <li class="nav-item">
              <a class="nav-link" href="/videos">VIDEOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/models">MODELS</a>
            </li>
            <?php if(!$hidecats) { ?>
            <li class="nav-item">
              <a class="nav-link" href="/categories">CATEGORIES</a>
            </li>
            <?php } ?>
            <?php if(!$hidetags) { ?>
            <li class="nav-item">
              <a class="nav-link" href="/video-tags">TAGS</a>
            </li>
            <?php } ?>
            
            <?php if(@$this->pdata['cst']['hide_about']!="on") { ?>
            <li class="nav-item">
              <a class="nav-link" href="/page/about">ABOUT</a>
            </li>
            <?php } ?>
            <?php if(@$this->pdata['cst']['hide_merch']!="on") { ?>
            <li class="nav-item">
              <a class="nav-link" href="/page/merch">MERCH</a>
            </li>
            <?php } ?>
            <?php if(@$this->pdata['cst']['hide_contact']!="on") { ?>
            <li class="nav-item">
              <a class="nav-link" href="/customer-service">CONTACT</a>
            </li>
            <?php } ?>
            <?php if(!$hideblog) { ?>
            <li class="nav-item">
              <a class="nav-link" href="/blog">BLOG</a>
            </li>
            <?php } if(!$hidechat && app::memberUser()) { ?>
            <li class="nav-item">
              <a class="nav-link" href="/video-chat">CHAT</a>
            </li>
            <?php } if(!$hidelive && app::memberUser()) { ?>
            <li class="nav-item">
              <a class="nav-link" href="/live">LIVE STREAMS</a>
            </li>
            <?php } ?>            
            <li class="nav-item">
                <a class="nav-link" onclick="if(!$('#search').is(':visible')) $('#search').slideToggle()"><?php if(@$this->pdata['cst']['hide_nav_icon_text']!="on") { ?> SEARCH <?php } ?><i class="fas fa-search"></i> <input onkeyup="searchKey()" name="_search" placeholder="Press enter to search..." id="search" class="shadow-none" style="display: none"></a>              
            </li>
            <?php if(sizeof($arr)>0) { ?>
            <li class="nav-item">
                <a class="nav-link" onclick="$('#rsMoreMenu').addClass('in')"><?php if(@$this->pdata['cst']['hide_nav_icon_text']!="on") { ?> MORE <?php } ?><i class="fas fa-ellipsis-v"> </i> </a>
            </li>          
          <?php }          
          if(!app::memberUser()) { ?>
            </ul>
            <ul class="navbar-nav custom-nav right-nav d-none d-lg-inline-flex">
            <li class="nav-item">
              <a class="nav-link" onclick="sshow('login');">LOGIN</a>
            </li>
            <li class="nav-item">
              <a class="nav-link join" onclick="$('#signup').modal();aspo();">GET ACCESS <i class="fas fa-angle-double-right fa-1x"></i></a>
            </li>
          </ul>
            <?php } else { ?>
              </ul>
          <ul class="navbar-nav custom-nav right-nav">
            <li class="nav-item">
              <a class="nav-link" href="/logout.php">LOGOUT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link join" href="/profile">PROFILE <i class="fas fa-angle-double-right fa-1x"></i></a>
            </li>
          </ul>
          <?php } ?>
        </div>
      </div>
    </nav>
    
    <div id="rsMoreMenu" class="right-slider">
        <span onclick="$('.right-slider').removeClass('in')" class="close">X</span>
        <?php foreach ($arr as $a) { ?>
              <a class="ucase" href="<?=$a['url']?>"><?=$a['title']?></a>
        <?php }  ?>
    </div>
    
    <script>
        function searchKey() {
            if(event.which==13) {
                window.location.href = '<?=VDIR?>videos?_search=' + encodeURIComponent($('#search').val());
            }
        }
    </script>
    
    
    
<?php
$ent = new member;
$u = $ent->fetch("id",app::memberUser());
?>
<div class="container bootstrap snippets bootdey">
    <div class="row">
      <div class="profile-nav col-md-3">
          <div class="panel">
              <div class="user-heading round">
                  <a href="#">
                      <img src="<?=$ent->meta($u,'avatar')?>" alt="">
                  </a>
                  <h1><?=$u['username']?></h1>
                  <p><?=$u['email']?></p>
              </div>
              <div class="panel-body">
                <ul class="nav nav-pills-vertical nav-stacked">
                    <li><a href="<?=app::currentUrl()?>?_group=dash"> <i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=announcements"> <i class="fa fa-fw fa-message"></i> Announcements</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=about"> <i class="fa fa-fw fa-question"></i> About me</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=purchased"> <i class="fa fa-fw fa-money-check"></i> Purchased videos</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=videos"> <i class="fa fa-fw fa-star"></i> Favourite videos</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=models"> <i class="fa fa-fw fa-heart"></i> Favourite models</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=upgrade"> <i class="fa fa-fw fa-arrow-up"></i> Upgrade account</a></li>                    
                    <li><a href="<?=app::currentUrl()?>?_group=wallet"> <i class="fa fa-fw fa-dollar"></i> Wallet balance</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=referrals"> <i class="fa fa-fw fa-link"></i> Referrals</a></li>
                    <li><a href="<?=app::currentUrl()?>?_group=support"> <i class="fa fa-fw fa-life-ring"></i> Support</a></li>                    
                </ul>
              </div>
          </div>
      </div>      
          <?php 
            $grp = app::request("_group");
            $grp = !$grp?"dash":$grp;
            echo "{{grp-$grp}}"; 
          ?>      
    </div>
</div>
<script>
    $(()=> $('a[href="?_group=<?=$grp?>"]').addClass("active") );
</script>
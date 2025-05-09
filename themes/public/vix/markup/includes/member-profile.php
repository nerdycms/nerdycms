<?php
$ent = new member;
$u = $ent->fetch("id",app::memberUser());
$this->pdata['u'] = $u;
$cset = (new option("optcns","appearance"))->fetch("vals");
?>
<div class="container bootstrap snippets bootdey">
    <div class="row">
      <div class="profile-nav col-md-3">
          <div class="panel">
              <div class="user-heading round">
                  <a href="<?=VDIR?>profile">
                      <img src="<?=$ent->meta($u,'avatar')?>" alt="">
                  </a>
                  <h1><?=$u['username']?></h1>
                  <p><?=$u['email']?></p>
              </div>
              <div class="panel-body">
                <ul class="nav nav-pills-vertical nav-stacked">
                    <li><a href="<?=app::currentUrl()?>?_group=dash"> <i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                    <?php if(@$cset['hide_profile_announcements']!="on") { ?>
                    <li><a href="<?=app::currentUrl()?>?_group=announcements"> <i class="fa fa-fw fa-message"></i> Announcements</a></li>
                    <?php } ?>
                    <li><a href="<?=app::currentUrl()?>?_group=about"> <i class="fa fa-fw fa-question"></i> About me</a></li>
                    <?php if(@$cset['hide_profile_purchases']!="on") { ?>
                    <li><a href="<?=app::currentUrl()?>?_group=purchased"> <i class="fa fa-fw fa-money-check"></i> Purchased videos</a></li>
                    <?php } if(@$cset['hide_profile_favorite_videos']!="on") {?>
                    <li><a href="<?=app::currentUrl()?>?_group=videos"> <i class="fa fa-fw fa-star"></i> Liked videos</a></li>
                    <?php } if(@$cset['hide_profile_favorite_models']!="on") {?>
                    <li><a href="<?=app::currentUrl()?>?_group=models"> <i class="fa fa-fw fa-heart"></i> Liked models</a></li>
                    <?php } if(@$cset['hide_upgrade_account']!="on") {?>
                    <?php if(app::memberRole()=="Free") { ?>
                    <li><a href="<?=app::currentUrl()?>?_group=upgrade"> <i class="fa fa-fw fa-arrow-up"></i> Upgrade account</a></li>                    
                    <?php }  } if(app::memberRole()=="Premium") {?>
                    <li><a href="<?=app::currentUrl()?>?_group=status"> <i class="fa fa-fw fa-question"></i> Account status</a></li>                    
                    <?php }  if(@$cset['hide_wallet']!="on") {?>
                    <li><a href="<?=app::currentUrl()?>?_group=wallet"> <i class="fa fa-fw fa-dollar"></i> Wallet balance</a></li>
                    <?php } if(@$cset['hide_referrals']!="on") {?>
                    <li><a href="<?=app::currentUrl()?>?_group=referrals"> <i class="fa fa-fw fa-link"></i> Referrals</a></li>
                    <?php } ?>
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
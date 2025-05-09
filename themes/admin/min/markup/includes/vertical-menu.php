<?php
$aid = app::adminUser();
$aent = new adm;
$adm = $aid<0?["username"=>"ADMIN","access"=>""]:$aent->fetch("id",$aid);
if($aid>0) $adm['access'] .= ",system->admin users";
?>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/nerdycms-logo-green-square-2.png" alt="" height="23">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/nerdycms-logo-green-square-2.png" alt="" height="24"> <span class="logo-txt">NerdyCMS</span>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/nerdycms-logo-green-square-2.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/nerdycms-logo-green-square-2.png" alt="" height="24"> <span class="logo-txt">NerdyCMS</span>
                    </span>
                </a>
            </div>

            <button onclick="$('.vertical-menu').toggle()" type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <!--<form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="<?=_l("search")?>">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>-->
        </div>

        <div class="d-flex">
            <div class="d-inline-block p-4"> 
                <b>Support at: <a target="_blank" href='https://support.nerdycms.com'>support.nerdycms.com</a></b>
            </div>
            <div class="d-inline-block p-4"> 
                <b><?=number_format(disk_free_space(MEM_CONTENT_DIR)/(1024*1024*1024),2)?> Gb free</b>
            </div>
            <div class="d-inline-block p-4"> 
                <span onclick="$.ajax({url:'/admin/reset-cache'})" class="btn-sm btn-primary"><i class='fa fa-history'></i> Reset Asset Cache</span>
            </div>
            <!--<div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
        
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?=@_l("search")?>" aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <?php if ($allLang == 'en') { ?>
                        <img class="me-2" src="assets/images/flags/us.jpg" alt="Header Language" height="16"> 
                    <?php } ?>
                    <?php if ($allLang == 'es') { ?>
                        <img class="me-2" src="assets/images/flags/spain.jpg" alt="Header Language" height="16"> 
                    <?php } ?>
                    <?php if ($allLang == 'de') { ?>
                        <img class="me-2" src="assets/images/flags/germany.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($allLang == 'it') { ?>
                        <img class="me-2" src="assets/images/flags/italy.jpg" alt="Header Language" height="16"> 
                    <?php } ?>
                    <?php if ($allLang == 'ru') { ?>
                        <img class="me-2" src="assets/images/flags/russia.jpg" alt="Header Language" height="16"> 
                    <?php } ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    
                    <a href="?lang=en" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> English </span>
                    </a>
                    
                    
                    <a href="?lang=de" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> German </span>
                    </a>

                    
                    <a href="?lang=it" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Italian </span>
                    </a>

                    
                    <a href="?lang=es" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Spanish </span>
                    </a>

                    
                     <a href="?lang=ru" class="dropdown-item notify-item language">
                        <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Russian </span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="dropdown d-inline-block">
                <!--<button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">5</span>
                </button> 
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?=_l("Notifications")?> </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> <?=_l("unread")?> (3)</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?=_l("James Lemire")?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?=_l("It will seem like simplified English")?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?=_l("1 hours ago")?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?=_l("Your_order_is_placed")?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?=_l("If_several_languages_coalesce_the_grammar")?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?=_l("3_min_ago")?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?=_l("Your_item_is_shipped")?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?=_l("If_several_languages_coalesce_the_grammar")?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?=_l("3_min_ago")?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?=_l("Salena_Layfield")?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">???.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?=_l("1_hours_ago")?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span><?=_l("view more")?></span> 
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?=VDIR?>themes/common/avatar-admin.png"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?=$adm['username']?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- 
                    <a class="dropdown-item" href="apps-contacts-profile.php"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> <?=_l("profile")?></a>
                    <a class="dropdown-item" href="auth-lock-screen.php"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> <?=_l("lock screen")?> </a>
                    <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="<?=VDIR?>admin-logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> <?=_l("logout")?></a>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?=_l("menu")?></li>
                
                <?php                    
                foreach (app::$mainNav->items(app::adminRole()) as $value) { 
                    
                    if(sizeof($ia = explode('|',$value))===1) {                    
                        if(strpos($adm['access'].",",$ia[0].",")!==false)                            continue;                        
                ?>
                    <li>
                        <a href="<?=app::asset("admin/".$value)?>">
                            <i data-feather="<?=app::$mainNav->icon($value)?>"></i>
                            <span data-key="t-<?=$value?>"><?=app::$mainNav->label($value)?></span>
                        </a>
                    </li>
                <?php } else { 
                    if(strpos($adm['access'].",",$ia[0].",")!==false)                            continue; ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="<?=app::$mainNav->icon($ia[0])?>"></i>
                            <span data-key="t-<?=$ia[0]?>"><?=app::$mainNav->label($ia[0])?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false"><?php for($i=1;$i<sizeof($ia);$i++) { 
                            if(strpos($adm['access'].",",$ia[0]."->".$ia[$i].",")!==false) continue;
                            ?>
                            <li>
                                <a href="<?=app::asset("admin/".$ia[$i])?>">
                                    <span data-key="t-<?=$ia[$i]?>"><?=app::$mainNav->label($ia[$i])?></span>
                                </a>
                            </li><?php } ?>
                        </ul>
                    </li>    
                <?php                 
                } }?>                                
        </div>
        <?php if($v = update::available()) { ?>
        <!-- Sidebar -->
        <div class="text-center">
            <p>Version <?="$v[0]$v[1]-$v[2]$v[3]-$v[4]$v[5]"?> is available!</p>
            <button id='dup' onclick="$('#dup').html('Working...');window.location.href='<?=VDIR?>admin/do-update';" class="btn btn-danger">Update now</button>
                        
        </div>
        <?php } ?>
    </div>
</div>
<!-- Left Sidebar End -->
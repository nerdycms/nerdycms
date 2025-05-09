<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Minia</span>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Minia</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="<?php echo $language["Search"]; ?>">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo $language["Search"]; ?>" aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if ($lang == 'en') { ?>
                        <img class="me-2" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($lang == 'es') { ?>
                        <img class="me-2" src="assets/images/flags/spain.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($lang == 'de') { ?>
                        <img class="me-2" src="assets/images/flags/germany.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($lang == 'it') { ?>
                        <img class="me-2" src="assets/images/flags/italy.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($lang == 'ru') { ?>
                        <img class="me-2" src="assets/images/flags/russia.jpg" alt="Header Language" height="16">
                    <?php } ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                   <!-- item-->
                   <a href="?lang=en" class="dropdown-item notify-item">
                        <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> English </span>
                    </a>
                    
                    <!-- item-->
                    <a href="?lang=de" class="dropdown-item notify-item">
                        <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> German </span>
                    </a>

                    <!-- item-->
                    <a href="?lang=it" class="dropdown-item notify-item">
                        <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Italian </span>
                    </a>

                    <!-- item-->
                    <a href="?lang=es" class="dropdown-item notify-item">
                        <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Spanish </span>
                    </a>

                     <!-- item-->
                     <a href="?lang=ru" class="dropdown-item notify-item">
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
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">5</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?php echo $language["Notifications"]; ?> </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> <?php echo $language["Unread"]; ?> (3)</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["James_Lemire"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["It_will_seem_like_simplified_English"]; ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["1_hours_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-sm me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Your_order_is_placed"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["If_several_languages_coalesce_the_grammar"]; ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["3_min_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-sm me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Your_item_is_shipped"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["If_several_languages_coalesce_the_grammar"]; ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["3_min_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="assets/images/users/avatar-6.jpg" class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Salena_Layfield"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["As_a_skeptical_Cambridge_friend_of_mine_occidental"]; ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["1_hours_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span><?php echo $language["View_More"]; ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?php echo $language["Shawn_L"]; ?>.</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="apps-contacts-profile.php"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> <?php echo $language["Profile"]; ?></a>
                   <a class="dropdown-item" href="auth-lock-screen.php"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> <?php echo $language["Lock_screen"]; ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> <?php echo $language["Logout"]; ?></a>
                </div>
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="index.php" id="topnav-dashboard" role="button">
                            <i data-feather="home"></i><span data-key="t-dashboards"><?php echo $language["Dashboard"]; ?></span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button">
                            <i data-feather="briefcase"></i>
                            <span data-key="t-components"><?php echo $language["Elements"]; ?></span>
                            <div class="arrow-down"></div>
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-uielement">
                            <div class="ps-2 p-lg-0">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div>
                                            <div class="menu-title"><?php echo $language["Components"]; ?></div>
                                            <div class="row g-0">
                                                <div class="col-lg-5">
                                                    <div>
                                                        <a href="ui-alerts.php" class="dropdown-item" data-key="t-alerts"><?php echo $language["Alerts"]; ?></a>
                                                        <a href="ui-buttons.php" class="dropdown-item" data-key="t-buttons"><?php echo $language["Buttons"]; ?></a>
                                                        <a href="ui-cards.php" class="dropdown-item" data-key="t-cards"><?php echo $language["Cards"]; ?></a>
                                                        <a href="ui-carousel.php" class="dropdown-item" data-key="t-carousel"><?php echo $language["Carousel"]; ?></a>
                                                        <a href="ui-dropdowns.php" class="dropdown-item" data-key="t-dropdowns"><?php echo $language["Dropdowns"]; ?></a>
                                                        <a href="ui-grid.php" class="dropdown-item" data-key="t-grid"><?php echo $language["Grid"]; ?></a>
                                                        <a href="ui-images.php" class="dropdown-item" data-key="t-images"><?php echo $language["Images"]; ?></a>
                                                        <a href="ui-modals.php" class="dropdown-item" data-key="t-modals"><?php echo $language["Modals"]; ?></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div>
                                                        <a href="ui-offcanvas.php" class="dropdown-item" data-key="t-offcanvas"><?php echo $language["Offcanvas"]; ?></a>
                                                        <a href="ui-progressbars.php" class="dropdown-item" data-key="t-progress-bars"><?php echo $language["Progress_Bars"]; ?></a>
                                                        <a href="ui-tabs-accordions.php" class="dropdown-item" data-key="t-tabs-accordions"><?php echo $language["Tabs_n_Accordions"]; ?></a>
                                                        <a href="ui-typography.php" class="dropdown-item" data-key="t-typography"><?php echo $language["Typography"]; ?></a>
                                                        <a href="ui-video.php" class="dropdown-item" data-key="t-video"><?php echo $language["Video"]; ?></a>
                                                        <a href="ui-general.php" class="dropdown-item" data-key="t-general"><?php echo $language["General"]; ?></a>
                                                        <a href="ui-colors.php" class="dropdown-item" data-key="t-colors"><?php echo $language["Colors"]; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div>
                                            <div class="menu-title"><?php echo $language["Extended"]; ?></div>
                                            <div>
                                                <a href="extended-lightbox.php" class="dropdown-item" data-key="t-lightbox"><?php echo $language["Lightbox"]; ?></a>
                                                <a href="extended-rangeslider.php" class="dropdown-item" data-key="t-range-slider"><?php echo $language["Range_Slider"]; ?></a>
                                                <a href="extended-sweet-alert.php" class="dropdown-item" data-key="t-sweet-alert"><?php echo $language["SweetAlert_2"]; ?></a>
                                                <a href="extended-session-timeout.php" class="dropdown-item" data-key="t-session-timeout"><?php echo $language["Session_Timeout"]; ?></a>
                                                <a href="extended-rating.php" class="dropdown-item" data-key="t-rating"><?php echo $language["Rating"]; ?></a>
                                                <a href="extended-notifications.php" class="dropdown-item" data-key="t-notifications"><?php echo $language["Notifications"]; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                            <i data-feather="grid"></i><span data-key="t-apps"><?php echo $language["Apps"]; ?></span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                            <a href="apps-calendar.php" class="dropdown-item" data-key="t-calendar"><?php echo $language["Calendar"]; ?></a>
                            <a href="apps-chat.php" class="dropdown-item" data-key="t-chat"><?php echo $language["Chat"]; ?></a>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button">
                                    <span data-key="t-email"><?php echo $language["Email"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="apps-email-inbox.php" class="dropdown-item" data-key="t-inbox"><?php echo $language["Inbox"]; ?></a>
                                    <a href="apps-email-read.php" class="dropdown-item" data-key="t-read-email"><?php echo $language["Read_Email"]; ?></a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-invoice" role="button">
                                    <span data-key="t-invoices"><?php echo $language["Invoices"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-invoice">
                                    <a href="apps-invoices-list.php" class="dropdown-item" data-key="t-invoice-list"><?php echo $language["Invoice_List"]; ?></a>
                                    <a href="apps-invoices-detail.php" class="dropdown-item" data-key="t-invoice-detail"><?php echo $language["Invoice_Detail"]; ?></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact" role="button">
                                    <span data-key="t-contacts"><?php echo $language["Contacts"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="apps-contacts-grid.php" class="dropdown-item" data-key="t-user-grid"><?php echo $language["User_Grid"]; ?></a>
                                    <a href="apps-contacts-list.php" class="dropdown-item" data-key="t-user-list"><?php echo $language["User_List"]; ?></a>
                                    <a href="apps-contacts-profile.php" class="dropdown-item" data-key="t-profile"><?php echo $language["Profile"]; ?></a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button">
                            <i data-feather="box"></i><span data-key="t-components"><?php echo $language["Components"]; ?></span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-components">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form" role="button">
                                    <span data-key="t-forms"><?php echo $language["Forms"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-form">
                                    <a href="form-elements.php" class="dropdown-item" data-key="t-form-elements"><?php echo $language["Basic_Elements"]; ?></a>
                                    <a href="form-validation.php" class="dropdown-item" data-key="t-form-validation"><?php echo $language["Validation"]; ?></a>
                                    <a href="form-advanced.php" class="dropdown-item" data-key="t-form-advanced"><?php echo $language["Advanced_Plugins"]; ?></a>
                                    <a href="form-editors.php" class="dropdown-item" data-key="t-form-editors"><?php echo $language["Editors"]; ?></a>
                                    <a href="form-uploads.php" class="dropdown-item" data-key="t-form-upload"><?php echo $language["File_Upload"]; ?></a>
                                    <a href="form-wizard.php" class="dropdown-item" data-key="t-form-wizard"><?php echo $language["Wizard"]; ?></a>
                                    <a href="form-mask.php" class="dropdown-item" data-key="t-form-mask"><?php echo $language["Mask"]; ?></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table" role="button">
                                    <span data-key="t-tables"><?php echo $language["Tables"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-table">
                                    <a href="tables-basic.php" class="dropdown-item" data-key="t-basic-tables"><?php echo $language["Bootstrap_Basic"]; ?></a>
                                    <a href="tables-datatable.php" class="dropdown-item" data-key="t-data-tables"><?php echo $language["DataTables"]; ?></a>
                                    <a href="tables-responsive.php" class="dropdown-item" data-key="t-responsive-table"><?php echo $language["Responsive"]; ?></a>
                                    <a href="tables-editable.php" class="dropdown-item" data-key="t-editable-table"><?php echo $language["Editable"]; ?></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts" role="button">
                                    <span data-key="t-charts"><?php echo $language["Charts"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                    <a href="charts-apex.php" class="dropdown-item" data-key="t-apex-charts"><?php echo $language["Apexcharts"]; ?></a>
                                    <a href="charts-echart.php" class="dropdown-item" data-key="t-e-charts"><?php echo $language["Echarts"]; ?></a>
                                    <a href="charts-chartjs.php" class="dropdown-item" data-key="t-chartjs-charts"><?php echo $language["Chartjs"]; ?></a>
                                    <a href="charts-knob.php" class="dropdown-item" data-key="t-knob-charts"><?php echo $language["Jquery_Knob"]; ?></a>
                                    <a href="charts-sparkline.php" class="dropdown-item" data-key="t-sparkline-charts"><?php echo $language["Sparkline"]; ?></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons" role="button">
                                    <span data-key="t-icons"><?php echo $language["Icons"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                    <a href="icons-boxicons.php" class="dropdown-item" data-key="t-boxicons"><?php echo $language["Boxicons"]; ?></a>
                                    <a href="icons-materialdesign.php" class="dropdown-item" data-key="t-material-design"><?php echo $language["Material_Design"]; ?></a>
                                    <a href="icons-dripicons.php" class="dropdown-item" data-key="t-dripicons"><?php echo $language["Dripicons"]; ?></a>
                                    <a href="icons-fontawesome.php" class="dropdown-item" data-key="t-font-awesome"><?php echo $language["Font_Awesome_5"]; ?></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map" role="button">
                                    <span data-key="t-maps"><?php echo $language["Maps"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-map">
                                    <a href="maps-google.php" class="dropdown-item" data-key="t-g-maps"><?php echo $language["Google"]; ?></a>
                                    <a href="maps-vector.php" class="dropdown-item" data-key="t-v-maps"><?php echo $language["Vector"]; ?></a>
                                    <a href="maps-leaflet.php" class="dropdown-item" data-key="t-l-maps"><?php echo $language["Leaflet"]; ?></a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button">
                            <i data-feather="file-text"></i><span data-key="t-extra-pages"><?php echo $language["Extra_pages"]; ?> </span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-more">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth" role="button">
                                    <span data-key="t-authentication"><?php echo $language["Authentication"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                    <a href="pages-login.php" class="dropdown-item" data-key="t-login"><?php echo $language["Login"]; ?></a>
                                    <a href="pages-register.php" class="dropdown-item" data-key="t-register"><?php echo $language["Register"]; ?></a>
                                    <a href="pages-recoverpw.php" class="dropdown-item" data-key="t-recover-password"><?php echo $language["Recover_Password"]; ?></a>
                                    <a href="auth-lock-screen.php" class="dropdown-item" data-key="t-lock-screen"><?php echo $language["Lock_Screen"]; ?></a>
                                    <a href="auth-confirm-mail.php" class="dropdown-item" data-key="t-confirm-mail"><?php echo $language["Confirm_Mail"]; ?></a>
                                    <a href="auth-email-verification.php" class="dropdown-item" data-key="t-email-verification"><?php echo $language["Email_Verification"]; ?></a>
                                    <a href="auth-two-step-verification.php" class="dropdown-item" data-key="t-two-step-verification"><?php echo $language["Two_Step_Verification"]; ?></a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility" role="button">
                                    <span data-key="t-utility"><?php echo $language["Utility"]; ?></span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                    <a href="pages-starter.php" class="dropdown-item" data-key="t-starter-page"><?php echo $language["Starter_Page"]; ?></a>
                                    <a href="pages-maintenance.php" class="dropdown-item" data-key="t-maintenance"><?php echo $language["Maintenance"]; ?></a>
                                    <a href="pages-comingsoon.php" class="dropdown-item" data-key="t-coming-soon"><?php echo $language["Coming_Soon"]; ?></a>
                                    <a href="pages-timeline.php" class="dropdown-item" data-key="t-timeline"><?php echo $language["Timeline"]; ?></a>
                                    <a href="pages-faqs.php" class="dropdown-item" data-key="t-faqs"><?php echo $language["FAQs"]; ?></a>
                                    <a href="pages-pricing.php" class="dropdown-item" data-key="t-pricing"><?php echo $language["Pricing"]; ?></a>
                                    <a href="pages-404.php" class="dropdown-item" data-key="t-error-404"><?php echo $language["Error_404"]; ?></a>
                                    <a href="pages-500.php" class="dropdown-item" data-key="t-error-500"><?php echo $language["Error_500"]; ?></a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="layouts-horizontal.php" role="button">
                            <i data-feather="layout"></i><span data-key="t-horizontal"><?php echo $language["Horizontal"]; ?></span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
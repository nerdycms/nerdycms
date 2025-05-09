<?php include 'includes/session.php'; ?>
<?php include 'includes/head-main.php'; ?>

<head>
    <title><?=$this->pageTitle()?></title>

    <?php include 'includes/head.php'; ?>

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    
    <?php include 'includes/head-style.php'; 
    
    
    
    $stats = app::stats();
    
    ?>
</head>  

<?php include 'includes/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'includes/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">NerdyCMS</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate"><?=$stats['count1']['label']?></span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?=$stats['count1']['value']?>">0</span>
                                                </h4>
                                            </div>
        
                                            <div class="col-6">
                                                <div id="mini-chart1" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>                                        
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
        
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate"><?=$stats['count2']['label']?></span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?=$stats['count2']['value']?>">0</span>
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>                                        
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col-->
        
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate"><?=$stats['count3']['label']?></span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?=$stats['count3']['value']?>">0</span>
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>                                        
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
        
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate"><?=$stats['count4']['label']?></span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?=$stats['count4']['value']?>">0</span>
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>                                        
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->    
                        </div><!-- end row-->

                        <div class="row">
                            <div class="col-xl-5">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <h5 class="card-title me-2">Membership Breakdown</h5>
                                            <div class="ms-auto">
                                                <div>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        ALL
                                                    </button>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm active">
                                                        1Y
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-sm">
                                                <div id="pie1" data-colors='["#777aca", "#5156be", "#a8aada"]' class="apex-charts"></div>
                                            </div>
                                            <div class="col-sm align-self-center">
                                                <div class="mt-4 mt-sm-0">
                                                    <div>
                                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i> Subscribers</p>
                                                        <h6><?=$stats['perc1']['s1']?> = <span class="text-muted font-size-14 fw-normal"><?=$stats['perc1']['s1']?> %</span></h6>
                                                    </div>
    
                                                    <div class="mt-4 pt-2">
                                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i> Premium</p>
                                                        <h6><?=$stats['perc1']['s2']?> = <span class="text-muted font-size-14 fw-normal"><?=$stats['perc1']['s2']?> %</span></h6>
                                                    </div>                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-xl-8">
                                        <!-- card -->
                                        <div class="card card-h-100">
                                            <!-- card body -->
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center mb-4">
                                                    <h5 class="card-title me-2">Membership Overview</h5>
                                                    <div class="ms-auto">
                                                        <select class="form-select form-select-sm">
                                                            <option value="MAY" selected="">May</option>
                                                            <option value="AP">April</option>
                                                            <option value="MA">March</option>
                                                            <option value="FE">February</option>
                                                            <option value="JA">January</option>
                                                            <option value="DE">December</option>
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="row align-items-center">
                                                    <div class="col-sm">
                                                        <div id="invested-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
                                                    </div>
                                                    <div class="col-sm align-self-center">
                                                        <div class="mt-4 mt-sm-0">
                                                            <p class="mb-1">Total Members</p>
                                                            <h4><?=$stats['perc1']['s1']+$stats['perc1']['s2']?></h4>

                                                            <p class="text-muted mb-4"> + 0.0012.23 ( 0.2 % ) <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>

                                                            <div class="row g-0">
                                                                <div class="col-6">
                                                                    <div>
                                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Subscribers</p>
                                                                        <h5 class="fw-medium"><?=$stats['perc1']['s1']?></h5>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div>
                                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Free members</p>
                                                                        <h5 class="fw-medium"><?=$stats['perc1']['s2']?></h5>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mt-2">
                                                                <a href="#" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
        
                                    <div class="col-xl-4">
                                        <!-- card -->
                                        <div class="card bg-primary text-white shadow-primary card-h-100">
                                            <!-- card body -->
                                            <div class="card-body p-0">
                                                <div id="carouselExampleCaptions" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">                                                   
                                                    <div class="carousel-inner">
                                                        <?php $first = true; foreach($stats['ticker1'] as $t) { ?>                                                                                                                
                                                        <div class="carousel-item <?=$first?"active":""?>">
                                                            <div class="text-center p-4 text-white">
                                                                <i class="mdi mdi-ethereum widget-box-1-icon"></i>
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle bg-soft-light text-white font-size-24">
                                                                        <i class="mdi mdi-alert"></i>
                                                                    </span>
                                                                </div>
                                                                <h4 class="mt-3 lh-base fw-normal text-white"><?=$t['body']?></h4>
                                                                <p class="text-white-50 font-size-13"> <?=$t['sub']?></p>                                                                
                                                                <?=@$t['action']?>
                                                            </div>
                                                        </div> <?php $first=false; } ?>
                                                        <!-- 
                                                        <div class="carousel-item">
                                                            <div class="text-center p-4">
                                                                <i class="mdi mdi-ethereum widget-box-1-icon"></i>
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle bg-soft-light text-white font-size-24">
                                                                        <i class="mdi mdi-ethereum"></i>
                                                                    </span>
                                                                </div>
                                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>ETH</b> News</h4>
                                                                <p class="text-white-50 font-size-13"> Bitcoin prices fell sharply amid the global sell-off in
                                                                    equities. Negative news over the past week has dampened sentiment for bitcoin. </p>
                                                                <button type="button" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></button>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="carousel-item">
                                                            <div class="text-center p-4">
                                                                <i class="mdi mdi-litecoin widget-box-1-icon"></i>
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle bg-soft-light text-white font-size-24">
                                                                        <i class="mdi mdi-litecoin"></i>
                                                                    </span>
                                                                </div>
                                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>Litecoin</b> News</h4>
                                                                <p class="text-white-50 font-size-13"> Bitcoin prices fell sharply amid the global sell-off in
                                                                    equities. Negative news over the past week has dampened sentiment for bitcoin. </p>
                                                                <button type="button" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></button>
                                                            </div>
                                                        </div>
                                                        -->
                                                    </div>
                                                    <!-- end carousel-inner -->
                                                    
                                                    <div class="carousel-indicators carousel-indicators-rounded">
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                                                            aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <!-- end carousel-indicators -->
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end col -->
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-12">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <h5 class="card-title me-2">Membership History</h5>
                                            <div class="ms-auto">
                                                <div>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        ALL
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm active">
                                                        1Y
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-xl-8">
                                                <div>
                                                    <div id="market-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="p-4">
                                                    <div class="mt-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-soft-light text-dark font-size-16">
                                                                    1
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Signups</span>
                                                            </div>
        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill badge-soft-success font-size-12 fw-medium">+2.5%</span>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-soft-light text-dark font-size-16">
                                                                    2
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Subscriptions</span>
                                                            </div>
        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill badge-soft-success font-size-12 fw-medium">+8.3%</span>
                                                            </div>
                                                        </div>
                                                    </div>                                                           
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row-->
        
                           <!-- <div class="col-xl-4">
                               
                                <div class="card">
                               
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <h5 class="card-title me-2">Sales by Locations</h5>
                                            <div class="ms-auto">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">World<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                                        <a class="dropdown-item" href="#">USA</a>
                                                        <a class="dropdown-item" href="#">Russia</a>
                                                        <a class="dropdown-item" href="#">Australia</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="sales-by-locations" data-colors='["#5156be"]' style="height: 250px"></div>

                                        <div class="px-2 py-2">
                                            <p class="mb-1">USA <span class="float-end">75%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                                    style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="75">
                                                </div>
                                            </div>

                                            <p class="mt-3 mb-1">Russia <span class="float-end">55%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                                    style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="55">
                                                </div>
                                            </div>

                                            <p class="mt-3 mb-1">Australia <span class="float-end">85%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar"
                                                    style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="85">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
                                </div>
                               
                            </div>
                            -->
                        </div>
                        <!-- end row-->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Quick actions</h4>
                                        <div class="flex-shrink-0">
                                            <ul class="nav nav-tabs-custom card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#buy-tab" role="tab">ADD</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#sell-tab" role="tab">TODO</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="buy-tab" role="tabpanel">                                                
                                                <div class="p-5">
                                                    <div class="text-center m-2">
                                                        <button type="button" class="btn btn-success w-md">Add Video</button>
                                                    </div>
                                                    
                                                    <div class="text-center m-2">
                                                        <button type="button" class="btn btn-success w-md">Add Model</button>
                                                    </div>

                                                    <div class="text-center m-2">
                                                        <button type="button" class="btn btn-success w-md">Add Blog Post</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                            <div class="tab-pane" id="sell-tab" role="tabpanel">
                                                <div class="text-center m-2 p-5">
                                                    <h5>Coming soon</h5>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                        </div>
                                        <!-- end tab content -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Latest Additions</h4>
                                        <div class="flex-shrink-0">
                                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab" role="tab">
                                                        Members
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">
                                                        Videos
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-sell-tab" role="tab">
                                                        Transactions
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- end nav tabs -->
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body px-0">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                                    <table class="table align-middle table-nowrap table-borderless"> <?php foreach($stats['list1']['rows'] as $r) { if($r['email']=="") continue; ?>
                                                        
                                                        <tr>
                                                                <td style="width: 50px;">
                                                                    <div class="font-size-22 text-success">
                                                                        <i class="bx bx-user-plus d-block"></i>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div>
                                                                        <h5 class="font-size-14 mb-1"><?=$r['username']." (".$r['urole'].")"?></h5>
                                                                        <p class="text-muted mb-0 font-size-12">#<?=$r['id']?></p>
                                                                    </div>
                                                                </td>
                                                                
                                                                <td>
                                                                    <div class="text-end">
                                                                        <h5 class="font-size-14 mb-0"><?=$r['email']?></h5>
                                                                        <p class="text-muted mb-0 font-size-12"><?=$r['last_login_country']?></p>
                                                                    </div>
                                                                </td>
                                                                 
                                                            </tr>
                                                        
                                                    <?php } ?>
                                                        <tbody></tbody></table>                                                    
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                            <div class="tab-pane" id="transactions-buy-tab" role="tabpanel">
                                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                                    <table class="table align-middle table-nowrap table-borderless"> <?php foreach($stats['list2']['rows'] as $r) { if($r['title']=="") continue; ?>
                                                        
                                                        <tr>
                                                                <td style="width: 50px;">
                                                                    <div class="font-size-22 text-success">
                                                                        <i class="bx bx-video-plus d-block"></i>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div>
                                                                        <h5 class="font-size-14 mb-1"><?=$r['title']?></h5>
                                                                        <p class="text-muted mb-0 font-size-12"><?=$r['models']?></p>
                                                                    </div>
                                                                </td>                                                                                                                                
                                                                 
                                                            </tr>
                                                        
                                                    <?php } ?>
                                                        <tbody></tbody></table>        
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                            <div class="tab-pane" id="transactions-sell-tab" role="tabpanel">
                                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                                    <table class="table align-middle table-nowrap table-borderless"> <?php foreach($stats['list3']['rows'] as $r) { if(@$r['title']=="") continue; ?>
                                                        
                                                        <tr>
                                                                <td style="width: 50px;">
                                                                    <div class="font-size-22 text-success">
                                                                        <i class="bx bx-video-plus d-block"></i>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div>
                                                                        <h5 class="font-size-14 mb-1"><?=$r['tdatetime']?></h5>
                                                                        <p class="text-muted mb-0 font-size-12"><?=$r['ttype']?></p>
                                                                    </div>
                                                                </td>                                                                                                                                
                                                                 
                                                            </tr>
                                                        
                                                    <?php } ?>
                                                        <tbody></tbody></table> 
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                        </div>
                                        <!-- end tab content -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Recent Activity</h4>
                                        <div class="flex-shrink-0">
                                            <select class="form-select form-select-sm mb-0 my-n1">
                                                <option value="Today" selected="">Today</option>
                                                <option value="Yesterday">Yesterday</option>
                                                <option value="Week">Last Week</option>
                                                <option value="Month">Last Month</option>
                                            </select>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body px-0">
                                        <div class="px-3" data-simplebar style="max-height: 352px;">
                                            <ul class="list-unstyled activity-wid mb-0">

                                                <li class="activity-list activity-border">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                        <i class="bx bx-plus-circle font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">nerdymedia.net</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">ADMIN</h6>
                                                                <div class="font-size-13">Logged in</div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div> 
                                                </li>
                                        </ul>
                                            <!--<ul class="list-unstyled activity-wid mb-0">

                                                <li class="activity-list activity-border">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                        <i class="bx bx-bitcoin font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">0xb77ad0099e21d4fca87fa4ca92dda1a40af9e05d205e53f38bf026196fa2e431</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">+0.5 BTC</h6>
                                                                <div class="font-size-13">$178.53</div>
                                                            </div>

                                                            <div class="flex-shrink-0 text-end">
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </li>

                                                <li class="activity-list activity-border">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="mdi mdi-ethereum font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">0xb77ad0099e21d4fca87fa4ca92dda1a40af9e05d205e53f38bf026196fa2e431</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">-20.5 ETH</h6>
                                                                <div class="font-size-13">$3541.45</div>
                                                            </div>

                                                            <div class="flex-shrink-0 text-end">
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </li>

                                                <li class="activity-list activity-border">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                        <i class="bx bx-bitcoin font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">0xb77ad0099e21d4fca87fa4ca92dda1a40af9e05d205e53f38bf026196fa2e431</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">+0.5 BTC</h6>
                                                                <div class="font-size-13">$5791.45</div>
                                                            </div>

                                                            <div class="flex-shrink-0 text-end">
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </li>
            
                                                <li class="activity-list activity-border">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="mdi mdi-litecoin font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">0xb77ad0099e21d4fca87fa4ca92dda1a40af9e05d205e53f38bf026196fa2e431</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">-1.5 LTC</h6>
                                                                <div class="font-size-13">$5791.45</div>
                                                            </div>

                                                            <div class="flex-shrink-0 text-end">
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </li>


                                                <li class="activity-list activity-border">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                        <i class="bx bx-bitcoin font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">0xb77ad0099e21d4fca87fa4ca92dda1a40af9e05d205e53f38bf026196fa2e431</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">+0.5 BTC</h6>
                                                                <div class="font-size-13">$5791.45</div>
                                                            </div>

                                                            <div class="flex-shrink-0 text-end">
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </li>

                                                <li class="activity-list">
                                                    <div class="activity-icon avatar-md">
                                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="mdi mdi-litecoin font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <div class="timeline-list-item">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 overflow-hidden me-4">
                                                                <h5 class="font-size-14 mb-1">24/05/2021, 18:24:56</h5>
                                                                <p class="text-truncate text-muted font-size-13">0xb77ad0099e21d4fca87fa4ca92dda1a40af9e05d205e53f38bf026196fa2e431</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end me-3">
                                                                <h6 class="mb-1">+.55 LTC</h6>
                                                                <div class="font-size-13">$91.45</div>
                                                            </div>

                                                            <div class="flex-shrink-0 text-end">
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="mdi mdi-dots-vertical"></i>
                                                                    </a>
                
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </li>
                                            </ul>-->
                                        </div>    
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'includes/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php include 'includes/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'includes/vendor-scripts.php'; ?>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Plugins js-->
<script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

<script>
            // get colors array from the string
            function getChartColorsArray(chartId) {
                var colors = $(chartId).attr('data-colors');
                var colors = JSON.parse(colors);
                return colors.map(function(value){
                    var newValue = value.replace(' ', '');
                    if(newValue.indexOf('--') != -1) {
                        var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                        if(color) return color;
                    } else {
                        return newValue;
                    }
                })
            }
    
    
            $data = $.ajax({
                url: window.location.href + "?_action=stat",
                success: function (rt) {                   
                    dta = JSON.parse(rt);                    
                    
                    var piechartColors = getChartColorsArray("#pie1");
                    var options = {
                        series: dta['ratio1']['series'],
                        chart: {
                            width: 227,
                            height: 227,
                            type: 'pie',
                        },
                        labels: dta['ratio1']['labels'],
                        colors: piechartColors,
                        stroke: {
                            width: 0,
                        },
                        legend: {
                            show: false
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                            }
                        }]
                    };

                    var chart = new ApexCharts(document.querySelector("#pie1"), options);
                    chart.render();
                    
                    //
                    // Invested Overview
                    //

                    var radialchartColors = getChartColorsArray("#invested-overview");
                    var options = {
                        chart: {
                            height: 270,
                            type: 'radialBar',
                            offsetY: -10
                        },
                        plotOptions: {
                            radialBar: {
                                startAngle: -130,
                                endAngle: 130,
                                dataLabels: {
                                    name: {
                                        show: false
                                    },
                                    value: {
                                        offsetY: 10,
                                        fontSize: '18px',
                                        color: undefined,
                                        formatter: function (val) {
                                            return val + "%";
                                        }
                                    }
                                }
                            }
                        },
                        colors: [radialchartColors[0]],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: 'horizontal',
                                gradientToColors: [radialchartColors[1]],
                                shadeIntensity: 0.15,
                                inverseColors: false,
                                opacityFrom: 1,
                                opacityTo: 1,
                                stops: [20, 60]
                            },
                        },
                        stroke: {
                            dashArray: 4,
                        },
                        legend: {
                            show: false
                        },
                        series: [dta['perc1']['value']],
                        labels: [dta['perc1']['label']],
                    }

                    var chart = new ApexCharts(
                        document.querySelector("#invested-overview"),
                        options
                    );

                    chart.render();

                    //
                    // Market Overview
                    //
                    var barchartColors = getChartColorsArray("#market-overview");
                    var options = {
                        series: [{
                            name: 'Signups',
                            data: dta['signups']['series']
                        }, {
                            name: 'Subscribers',
                            data: dta['subscribers']['series']
                        }],
                        chart: {
                            type: 'bar',
                            height: 400,
                            stacked: true,
                            toolbar: {
                                show: false
                            },
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '20%',
                            },
                        },
                        colors: barchartColors,
                        fill: {
                            opacity: 1
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: false,
                        },
                        yaxis: {
                            labels: {
                                formatter: function (y) {
                                    return y.toFixed(0) + "%";
                                }
                            }
                        },
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            labels: {
                                rotate: -90
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#market-overview"), options);
                    chart.render();
                    
                    
                    
                    //  MINI CHART
                    // mini-1
                    var minichart1Colors = getChartColorsArray("#mini-chart1");
                    var options = {
                        series: [{
                            data: [2, 10, 18, 22, 36, 15, 47, 75, 65, 19, 14, 2, 47, 42, 15, ]
                        }],
                        chart: {
                            type: 'line',
                            height: 50,
                            sparkline: {
                                enabled: true
                            }
                        },
                        colors: minichart1Colors,
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        tooltip: {
                            fixed: {
                                enabled: false
                            },
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function (seriesName) {
                                        return ''
                                    }
                                }
                            },
                            marker: {
                                show: false
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#mini-chart1"), options);
                    chart.render();

                    // mini-2
                    var minichart2Colors = getChartColorsArray("#mini-chart2");
                    var options = {
                        series: [{
                            data: [15, 42, 47, 2, 14, 19, 65, 75, 47, 15, 42, 47, 2, 14, 12, ]
                        }],
                        chart: {
                            type: 'line',
                            height: 50,
                            sparkline: {
                                enabled: true
                            }
                        },
                        colors: minichart2Colors,
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        tooltip: {
                            fixed: {
                                enabled: false
                            },
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function (seriesName) {
                                        return ''
                                    }
                                }
                            },
                            marker: {
                                show: false
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#mini-chart2"), options);
                    chart.render();

                    // mini-3
                    var minichart3Colors = getChartColorsArray("#mini-chart3");
                    var options = {
                        series: [{
                            data: [47, 15, 2, 67, 22, 20, 36, 60, 60, 30, 50, 11, 12, 3, 8, ]
                        }],
                        chart: {
                            type: 'line',
                            height: 50,
                            sparkline: {
                                enabled: true
                            }
                        },
                        colors: minichart3Colors,
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        tooltip: {
                            fixed: {
                                enabled: false
                            },
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function (seriesName) {
                                        return ''
                                    }
                                }
                            },
                            marker: {
                                show: false
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#mini-chart3"), options);
                    chart.render();

                    // mini-4
                    var minichart4Colors = getChartColorsArray("#mini-chart4");
                    var options = {
                        series: [{
                            data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14, 2, 47, 42, 15, ]
                        }],
                        chart: {
                            type: 'line',
                            height: 50,
                            sparkline: {
                                enabled: true
                            }
                        },
                        colors: minichart4Colors,
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        tooltip: {
                            fixed: {
                                enabled: false
                            },
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: function (seriesName) {
                                        return ''
                                    }
                                }
                            },
                            marker: {
                                show: false
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#mini-chart4"), options);
                    chart.render();
                    
                }        
            });
            
            
        </script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>
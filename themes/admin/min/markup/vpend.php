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
                            <h4 class="mb-sm-0 font-size-18">Verification pending</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">NerdyCMS</a></li>
                                    <li class="breadcrumb-item active">Verification pending</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <h1>Please wait for verifcation</h1>
                </div>
        </div>
    </div>
</body>

</html>
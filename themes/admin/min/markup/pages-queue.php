<?php include 'includes/session.php'; ?>
<?php include 'includes/head-main.php'; ?>

<head>

    <title><?=$this->pageTitle()?></title>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/head-style.php'; ?>

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
                            <h4 class="mb-sm-0 font-size-18"><?=$this->title()?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">                                    
                                    <li class="breadcrumb-item active"><?=$this->title()?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div id="qview">
                    
                </div>

            </div> <!-- container-fluid -->
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
<script>
    var getQ = ()=>{
        $.ajax({ url: window.location.href + "?_action=vqueue",complete: (r) => {
            $('#qview')[0].innerHTML = r.responseText;
        }});
    };
    $(()=> {
        window.setInterval(() => {
            getQ();    
        },500);
        getQ();
    });
</script>
<script src="assets/js/app.js"></script>

</body>

</html>
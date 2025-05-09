<?php include 'includes/session.php'; ?>
<?php include 'includes/head-main.php'; ?>

<head>

    <title><?=$this->pageTitle()?></title>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/head-style.php'; ?>
    <?=app::asset("/assets/libs/choices.js/public/assets/styles/choices.min.css")?>
</head>

<?php include 'includes/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'includes/menu.php';    
    ?>

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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?=_l("members")?></a></li>
                                    <li class="breadcrumb-item active"><?=$this->title()?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->            
                <form method="post">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">                                                                                                
                                <h4 class="card-title"><?=_l("accouncements")?></h4>
                                <p class="card-title-desc"><?=_l("accouncement help")?></p>
                            </div>                            
                                <div class="card-body p-4"><div class="row">                                     
                                    <div class="col-md-12">
                                        <div>
                                            <div class="mb-3">                                                
                                                <label for="target" class="form-label"><?=_l("target")?></label>                                                
                                                <select name="target" class="form-control" id="target">
                                                    <option value="all">All members</option>
                                                    <option value="premium">Premium members</option>
                                                    <option value="free">Free members</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-12">
                                        <div>
                                            <div class="mb-3">                                                
                                                <label for="message" class="form-label"><?=_l("message")?></label>      
                                                <textarea maxlength='160' class='form-control' name='message'></textarea>
                                            </div>
                                        </div>
                                    </div>    
                                </div>                                
                                <div class="mt-4">
                                    <button onclick="cusSubmit()" type="submit" class="btn btn-primary w-md"><?=_l("send now")?></button>
                                </div>                                                                 
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->                
                </form>
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

function tplLoad(idx) {
    $('#preview').html(allTpl[idx].body);
}

tplLoad(0);

</script>    

<script src="assets/js/app.js"></script>

</body>

</html>
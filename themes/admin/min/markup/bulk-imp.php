<?php include 'includes/session.php'; ?>
<?php include 'includes/head-main.php'; ?>

<head>

    <title><?=$this->pageTitle()?></title>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/head-style.php'; ?>
    <script>
        var __sysUplPre = '<?=app::homeDir()?>';
    </script>
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
                            <h4 class="mb-sm-0 font-size-18">Bulk upload</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Video</a></li>
                                    <li class="breadcrumb-item active">Bulk upload</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                
                <?php if(defined("BULK_UPLOAD_DIR")) { ?>
                <table style="width:100%"><tr><td style="width:20%">
                    <div class="files-wrap">
                        <div id="files"></div>
                    </div>
                    <form method="post">
                        <input name="_action" type="hidden" value="go">
                        <button id="process" class="btn btn-primary">Process all</button>
                    </form>
                </td><td>            
                    <div class="bg-soft-dark">                    
                    <iframe style="height:47rem;width:100%" src="/admin/bulk.txt"></iframe>
                    </div>
                </td></tr></table>    
                <?php } else { ?>
                <div class="bulk-u-wrap">
                    <style>
                                    .myProgress {
                                        position: absolute;
                                        top: 18px;
                                        left: 350px;
                                        right: 200px;
                                        width: unset;
                                    }
                                    .plupload_container {
                                        min-height: 80px;
                                    }
                                    .plupload_file_name {
                                        width: auto!important;
                                    }
                                    .plupload_file_size {
                                        display: none;
                                    }
                                    .plupload_file_status {
                                        font-size: 3rem;
                                        width: 300px!important;
                                        position: absolute;
                                        right: 20px; top: 20px;
                                    }
                                    .plupload_button {
                                        background: #2ab57d;
                                        font-family: 'IBM Plex Sans';
                                        padding: 0.75rem 1rem;     
                                        color: #fff;     
                                        border-radius: .3rem;
                                    }
                                    .plupload_header {
                                        display: none;
                                    }
                                    .plupload_filelist_footer {
                                        position: absolute;
                                        top: 0;
                                        padding: .5rem;
                                        background: #fff;                                        
                                    }
                                    .plupload_filelist_header { display: none }
                                </style>
                                
                                            <div data-key="bulk" class="uploader">
                                                    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                                            </div>
                                            <div id="myProgress">
                                                <div id="myBar"></div>
                                            </div>                                             
                                
                </div>
                <div class="bg-soft-dark">                    
                    <iframe style="height:47rem;width:100%" src="/admin/bulk.txt"></iframe>
                </div>
                <?php } ?>

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
$('iframe').on('load',function () {
  var $contents = $('iframe').contents();
  $contents.scrollTop($contents.height());
});

window.setInterval(function () {
    var r = Math.random();
    $('iframe').attr('src','/admin/bulk.txt?_rnd=' + r);
    var u = window.location.href + "?_action=refresh";
    $.ajax({url: u,complete: function (r) {
            console.log(u);
    }});
},5000);
$(()=> {
    $.ajax({url: window.location.href + "?_action=refresh",complete: function (r) {
            $('#files').html(r.responseText);
    }});
});
</script>
<script src="assets/js/app.js"></script>
<script src="assets/js/upl.js"></script>

</body>

</html>
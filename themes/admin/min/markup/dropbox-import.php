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
                            <h4 class="mb-sm-0 font-size-18">Dropbox import</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Video</a></li>
                                    <li class="breadcrumb-item active">Dropbox import</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                
                
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
                    <iframe style="height:47rem;width:100%" src="/admin/drop.txt"></iframe>
                    </div>
                </td></tr></table>    
                
                

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
    $('iframe').attr('src','/admin/drop.txt?_rnd=' + r);
    var u = '<?=DOM?>/drop-refresh';
    $.ajax({url: u,complete: function (r) {
            $('#files').html(r.responseText);
           // console.log(r.responseText);
    }});
},15000);
$(()=> {
    $.ajax({url: u,complete: function (r) {
            $('#files').html(r.responseText);
            //console.log(r.responseText);
    }});
});
</script>
<script src="assets/js/app.js"></script>
<script src="assets/js/upl.js"></script>

</body>

</html>
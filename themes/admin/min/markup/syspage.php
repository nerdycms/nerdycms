<?php include 'includes/session.php'; ?>
<?php include 'includes/head-main.php'; ?>

<head>

    <title><?=$this->pageTitle()?></title>
    <?php include 'includes/head.php'; ?>
    <?php include 'includes/head-style.php'; ?>
    <style type="text/css" media="screen">
    #editor { 
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;      
        color: #fff;
        width: 100%;
        height: calc(100vh - 12rem);
    }
</style>
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
                <form>
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18"><?=$this->title()?></h4>

                                <select name="_" class="form-control " onchange="$('form')[0].submit()">
                                <?php 
                                $cur = urldecode($_GET["_"]);
                                $GLOBALS['cnt'] = null;

                                function _scan($path,$cur) {                                
                                    $files = scandir($path);
                                    foreach($files as $f) {
                                        if($f[0]==".") continue;
                                        if(is_dir($path."/".$f)) {
                                            _scan($path."/".$f,$cur);
                                        } else {
                                            $nme = basename($f);
                                            $dir = basename($path);
                                            $dir2 = basename(dirname($path));                                        
                                            if(!$cur && !$GLOBALS['cnt']) {
                                                $GLOBALS['cnt'] = file_get_contents($path."/".$f);
                                            }
                                            if($cur && $cur == "$dir2/$dir/$nme") {
                                                   $GLOBALS['cnt'] = file_get_contents($path."/".$f);
                                                echo "<option selected value='".urlencode("$dir2/$dir/$nme")."'>$dir2 - $dir - $nme</option>";
                                            } else {
                                                echo "<option value='".urlencode("$dir2/$dir/$nme")."'>$dir2 - $dir - $nme</option>";
                                            }
                                        }
                                    }    
                                }
                                _scan(THEME_DIR,$cur);

                                ?>
                                </select>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">System</a></li>
                                        <li class="breadcrumb-item active"><?=$this->title()?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="bg-soft-dark2">
                        <div id="editor"><?php 

                        echo htmlentities($GLOBALS['cnt']);

                        ?>
                        </div>

                    </div>
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
<script src="assets/libs/ace/ace.js"></script>
<script>
    //ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.9.6');
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/php");
</script>
<script src="assets/js/app.js"></script>

</body>

</html>
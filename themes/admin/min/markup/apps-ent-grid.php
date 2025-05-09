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
    <div class="main-content content-<?=str_replace([" ","/"],"-",$this->title())?>">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18"><?=$this->title()?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?=$this->ent->group?></a></li>
                                    <li class="breadcrumb-item active"><?=$this->title()?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title"><?=$this->ent->singular?> List <span class="text-muted fw-normal ms-2">(<?=$this->ent->count()?>)</span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">                            
                            <div>
                                <a href="<?=$this->hook?>?_id=" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                            </div>

                            <!--<div class="dropdown">
                                <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>-->
                        </div>

                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <?php 
                    $pagesize = 12;
                    $maxpage = ceil($this->ent->count()/$pagesize);
                    $res = $this->ent->fetch('all');
                    $limit = 6400;
                    $idx = 0;
                    while($a = $res->fetch_array()) {
                        if(!$limit--) break;
                        //if($limit%5==0) $res->data_seek(0);
                    ?>                    
                    <div id="item_<?=$idx?>" class="grid-item col-xl-3 col-sm-6 <?=$idx++>=$pagesize?'d-none':''?>">
                        <div class="card text-center">
                            <div class="card-body" style="<?=$this->ent->meta($a,"background")?>">
                                <div class="dropdown text-end">
                                    <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Mark available</a>
                                        <a class="dropdown-item" href="#">Mark unavailable</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                                <?php if($ava = $this->ent->meta($a,"avatar")) { ?>
                                    <div class="mx-auto mb-4">
                                        <img src="<?=$ava?>" alt="" class="avatar-xl rounded-circle img-thumbnail">
                                    </div>
                                <?php } else { ?>
                                    <div class="mx-auto mb-4" style="visibility:hidden">
                                        <img src="" alt="" class="avatar-xl rounded-circle img-thumbnail">
                                    </div>
                                <?php } ?>
                                <h5 style="padding: .1rem .5rem;display:inline-block;width:auto;background: rgba(255,255,255,.7);border-radius: .5rem" class="font-size-16 mb-1"><a class="text-dark"><?=$this->ent->meta($a,"label")?></a></h5>
                                <p class="text-muted mb-2"><?=$this->ent->meta($a,"tag")?></p>

                            </div>

                            <div class="btn-group" role="group">
                                <a class="btn btn-outline-light text-truncate" href="<?=$this->ent->meta($a,'link')?>"><i class="uil uil-user me-1"></i> Edit</a>
                                <a type="button" class="btn btn-outline-light text-truncate" href="<?=$this->ent->meta($a,'link')?>" target="_blank"><i class="uil uil-envelope-alt me-1"></i> Open in new window</a>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <?php } ?>    
                </div>
                <!-- end row -->

                <div class="row g-0 align-items-center mb-4">
                    <div class="col-sm-6">
                        <div>
                            <p class="mb-sm-0">Showing <span id="showing">1 to 12</span> of <?=$this->ent->count()?> entries</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-end">
                            <ul class="pagination mb-sm-0">
                                <li class="page-item">
                                    <a onclick="pprev()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                </li>
                                <?php for($p=1;$p<=$maxpage;$p++) { ?>
                                <li class="page-item">
                                    <a onclick="pgoto(<?=$p?>)" class="page-link"><?=$p?></a>
                                </li>
                                <?php } ?>
                                <li class="page-item">
                                    <a onclick="pnext()" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end row -->

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

<script src="assets/js/app.js"></script>
<script>
    var psize = <?=$pagesize?>;
    var page = 0;
    
    function pprev() {
        page -=1;        
        var ofs = page*psize;
        if(ofs<0) return;
        if(ofs>=$('.grid-item').length) return;
        
        updshow();
    }
    function pgoto(v) {
        page = v-1;        
        var ofs = page*psize;
        if(ofs<0) return;
        if(ofs>=$('.grid-item').length) return;
        
        updshow();
    }
    function pnext() {
        page +=1;        
        var ofs = page*psize;
        if(ofs<0) return;
        if(ofs>=$('.grid-item').length) return;
                
        updshow();
    }
    function updshow() {
        var ofs = page*psize;
        $('.grid-item').addClass('d-none');
        for(var i=0;i<psize;i++) {
            $('#item_'+(i+ofs)).removeClass('d-none');
        }
        $('#showing').html((ofs+1) + " to " + (ofs + psize));
    }
</script>    
</body>

</html>
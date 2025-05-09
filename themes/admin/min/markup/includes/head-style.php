<meta name="robots" content="noindex" />
<base href="<?=VDIR?>themes/admin/min/" />

<!-- preloader css -->
<link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />
<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css?v=1.3" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

<link href="assets/libs/plupload/dist/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/plupload/dist/js/jquery.ui.plupload/css/jquery.ui.plupload.css" rel="stylesheet" type="text/css" />

<!-- App Css-->
<link href="assets/css/app.css?v=1.6" id="app-style" rel="stylesheet" type="text/css" />

<link href="assets/css/bootstrap.min.css?v=1.0" rel="stylesheet" type="text/css" />

<script src="assets/libs/jquery/jquery.min.js"></script> 
<script src="assets/js/cms.js?v=0.31"></script> 

<style>    
    .grp-optional .grp-title {
        background: rgba(0,0,0,.025);
        margin: .25rem 0;
        padding-top: .25rem;
        border-radius: 1rem;
    }
    .grp-optional a {        
        text-transform: uppercase;
        font-size: .75rem;
    }    
    .grp-optional h5 {
        opacity: .75;        
        width: auto!important;
        display: inline-block;
    }
    .grp-optional:not(.option-active) .mb-3 {
        display: none!important;               
    }    
    .grp-link {
        margin-left: .5rem;        
    }    
    .grp-indent {
        padding-left: 2rem;
    }
    .grp-optional svg {
        transform: scale(.667)!important;   
    }
    .float-end {
        float:right!important;   
        position:unset!important;        
        width:auto!important;   
        margin-left:auto!important;           
    }    
    .grp-option-ctl {
        display:none!important;               
    }
    .grp-option-ctl.option-active {
        display:unset!important;               
    }    
    .first {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .middle {
        border-radius: 0;
    }
    .last {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .tab-passive {
        opacity: .5;
    }
    .tab-controls {
        padding: .25rem;
        float: right;
    }    
    .ck-source-editing-button {
        display: none!important;
    }    
    .q-group {
        padding: 1rem;
        background-color: #efefef;
        margin: .5rem;
        border-radius: .75rem;
    }
    .q-group h3,.q-group h5 {
        text-transform: capitalize;
    }
    .q-right {
        float: right;
        height: 1.5rem;            
    }
    .q-status {
        width: 6rem;
        font-weight: bold;         
        text-transform: capitalize;
        display: inline-block;                
        text-align: center;
        transform: translateY(-.5rem);
    }
    .qst-finished {
        color: #8D8;
    }
    .qst-queued {
        color: #888;
    }
    .qst-running {
        color: #D8D;
    }
    .q-prog,.q-prog-myst {        
        display: inline-block;
        width: 20vw;
        background-color: #999;
        height: 1.5rem;
        border-radius: .25rem;
    }
    .q-prog-myst {
        opacity: .5;
    }
    .q-progi {
        display: inline-block;
        height: 1.5rem;
    }    
    .qpr-finished {
        background-color: #8D8;
    }
    .qpr-queued {
        background-color: #888;
    }
    .qpr-running {
        background-color: #D8D;
    }
    .q-tools {
        text-align: right;
        padding: .5rem;
    }
    .q-tools button {
        margin-left: 2rem;
    }
    .q-tools input {
        transform: translate(-.5rem,.5rem) scale(1.25,1.25);        
    }
</style>
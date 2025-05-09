<?php if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new model();
    $a = $ent->fetch("named",$rs);
} else app::redirect("/"); ?>
{{doc}}
    <head>
        {{head-main}}
    </head>
    <body class="model-page <?=@$this->pdata['cst']['hide_model_banner']=="on"?"nav-offset":""?>">       
        {{back-to-top}}
        {{nav}}      
        <?php if(@$this->pdata['cst']['hide_model_banner']!="on") { ?>
        {{big-still}}
        <?php } ?>
        {{model-info}}        
        <?php if(@$this->pdata['cst']['hide_model_latest']!="on") { ?>
        <h2>LATEST <span class="high-color ucase"><?=$rs?></span> MOVIES</h2>
        {{video-thumbs|model}}
        <?php } ?>
        <h2><span class="high-color ucase"><?=$rs?></span> GALLERY</h2>
        {{model-scenes}}
        <h2>MORE <span class="high-color ucase">VIDEOS...</span></h2>
        {{video-thumbs|random}}        
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
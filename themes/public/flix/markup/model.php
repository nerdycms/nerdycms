<?php if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new model();
    $a = $ent->fetch("named",$rs);
} else app::redirect("/"); ?>
{{doc}}
    <head>
        {{head-main}}
    </head>
    <body>       
        {{back-to-top}}
        {{nav}}
        {{preview-banner}}
        {{model-info}}
        {{big-scene}}
        <h2>LATEST <span class="high-color ucase"><?=$rs?></span> MOVIES</h2>
        {{video-thumbs|model}}
        <h2><span class="high-color ucase"><?=$rs?></span> GALLERY</h2>
        {{model-scenes}}
        {{creative|last|400}}
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
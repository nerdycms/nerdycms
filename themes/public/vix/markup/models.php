<?php
$gen = app::request("gender"); 

switch($gen) {
    case "m":
        $gen = "Male";
        break;
    default:
        $gen = "Female";
        break;
}

$ent = new model(["where"=>"gender LIKE '$gen' "]);
$list = $ent->fetch("array"); 

$vidlim = 12;
$this->pdata['list'] = $list;
$this->pdata['listsize'] = $vidlim;

$hidetop = @$this->pdata['cst']['hide_models_top_preview']=="on";
$fonly = @$this->pdata['cst']['female_only_models_page']=="on";
?>
{{doc}}
    <head>
        {{head-main}}
    </head>
    <body class="nav-offset">       
        {{back-to-top}}
        {{nav}}                
        <?php if(!$hidetop) { ?> <h2>NEW <span class="high-color">MODELS</span> </h2>
        {{model-thumbs|new}}      <?php } ?>
        <div class="d-block">
            <?php if(!$fonly) { ?> <div class="float-right">
                <form id="filter" action="<?=$this->hook?>" method="get">
                    <?php $gen = app::request("gender"); $gen=$gen?$gen:"f";?>
                    <select name="gender" class="filter" oninput="$('#filter').submit()">
                        <option <?=$gen=="f"?"selected":""?> value="f">Gender: Female</option>
                        <option <?=$gen=="m"?"selected":""?> value="m">Gender: Male</option>
                    </select>
                    <!--<select class="filter">
                        <option>Sort: Name</option>
                        <option>Sort: Popularity</option>
                    </select>-->
                </form>
            </div>
            <?php } if(!$hidetop) { ?> <h2 class="float-left">AND <span class="high-color">MORE</span> </h2> <?php } else { ?>
            <h2><span class="high-color">MODELS</span> </h2>
            <?php } ?>
        </div><br>
        {{pager|top}}
        {{model-results|list}}
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
{{doc}}
    <head>
        {{head-main}}
    </head>
    <body class="nav-offset">       
        {{back-to-top}}
        {{nav}}
        <div class="container">
            <?php if(app::request("_id")) { ?>
            {{blog-view}}    
            <?php } else { ?>
            {{blog-list}}
            <?php } ?>
            {{pager|bottom}}
        </div>        
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
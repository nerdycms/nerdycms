{{doc}}
    <head>
        {{head-main}}
    </head>
    <body>                
        {{back-to-top}}
        {{nav}}
        {{preview-banner}}
        <h2><span class="high-color">NEWEST</span> MOVIES</h2>
        {{video-thumbs|new}}
        <h2><span class="high-color">SEXY</span> THREESOMES</h2>
        {{video-thumbs|threesome}}
        <?php if(!app::memberUser()) { ?>
        {{creative|straight|533}}         
        <?php } ?>
        <h2>THE <span class="high-color">HOTTEST</span> MODELS</h2>
        {{model-thumbs|random}}                                             
        {{creative|countdown|400}}
        <h2><span class="high-color">BABES</span></h2>
        {{video-thumbs|babe|0}}        
        <h2><span class="high-color">MUCH MUCH</span> MORE...</h2>
        {{video-thumbs|random|0}}        
        <?php if(!app::memberUser()) { ?>
        {{creative|last|400}}
        <?php } ?>        
        {{footer}}
        {{util-scripts}}
    </body>
</html>
  
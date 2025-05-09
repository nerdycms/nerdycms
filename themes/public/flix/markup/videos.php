{{doc}}
    <head>
        {{head-main}}
    </head>
    <body class="nav-offset">       
        {{back-to-top}}
        {{nav}}
        <div class='row'>
            <div class='col-md-2 no-mobile'>{{video-cats|cats}}</div>
            <div class='col-md-10'>
                {{pager|top}}
                <div id='mobcats_t' style='display: none'>
                {{video-cats|cats p50}}
                </div>
                {{video-results|default}}
            </div>
        </div>        
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
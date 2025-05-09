{{doc}}
    <head>
        {{head-main}}
    </head>
    <body>       
        {{back-to-top}}
        {{nav}}        
        {{preview-banner}}
        <h2>NEW <span class="high-color">MODELS</span> </h2>
        {{model-thumbs|new}}     
        <div class="d-block">
            <div class="float-right">
                <select class="filter">
                    <option>Gender: Female</option>
                    <option>Gender: Male</option>
                </select>
                <select class="filter">
                    <option>Sort: Name</option>
                    <option>Sort: Popularity</option>
                </select>
            </div>
            <h2 class="float-left">AND <span class="high-color">MORE</span> </h2>
        </div><br>
        {{model-results|list}}
        {{footer}}
        {{util-scripts}}
    </body>
</html>    
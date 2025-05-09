{{doc}}
    <head>
        {{head-main}}
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.css" integrity="sha512-7uSoC3grlnRktCWoO4LjHMjotq8gf9XDFQerPuaph+cqR7JC9XKGdvN+UwZMC14aAaBDItdRj3DcSDs4kMWUgg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="nav-offset text-center"> 
        {{back-to-top}}        
        {{nav}}        
        <div class="widget" id="report">                    
            <iframe src="https://nerdycms.com/tengine/report.php?site={{data|domain_name}}&notify={{data|report_content_email}}&style=<?=app::asset("styles",true)."?_theme=vix"?>&theme={{data|theme-class}}"></iframe>                           
        </div>
        {{footer}}        
        {{util-scripts}}
    </body>
</html>   
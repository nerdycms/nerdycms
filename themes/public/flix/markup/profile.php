{{doc}}
    <head>
        {{head-main}}
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.css" integrity="sha512-7uSoC3grlnRktCWoO4LjHMjotq8gf9XDFQerPuaph+cqR7JC9XKGdvN+UwZMC14aAaBDItdRj3DcSDs4kMWUgg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="nav-offset member-profile"> 
        {{back-to-top}}        
        {{nav}}        
        {{member-profile}} 
        <br>
        {{footer}}
        <script>
            window.addEventListener("load",()=> {
                
                $('*[data-count]').each((i,o)=> {
                    var $o=$(o);
                    $o.timer = window.setInterval(function () {
                        var n = parseInt($o.html());
                        var nf = parseInt($o.attr("data-float"));
                        if(!nf) nf = n;
                        var l = parseInt($o.attr("data-count"));
                        if(nf<l) {
                            nf += l*0.1;
                            $o.attr("data-float",nf);
                            $o.html(parseInt(nf));
                        } else {
                            $o.html(l);
                            window.clearInterval($o.timer);
                        }                        
                    },75);
                });
            });
        </script>    
        {{util-scripts}}
    </body>
</html>   
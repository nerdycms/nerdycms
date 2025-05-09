<script>
    var $lastr  = null;
    function scrollFixup() {
        if(document.documentElement.scrollTop>50) {
            $('.overlay-more').addClass('hidden');
            $('.overlay-back').removeClass('hidden');
            $('.links-container').addClass('scrolled');
        } else {
            $('.overlay-more').removeClass('hidden');
            $('.overlay-back').addClass('hidden');
            $('.links-container').removeClass('scrolled');
        }

        if(window.innerWidth <= 600) {
            var $r = null;
            $('section').filter(":visible").each((i,o)=> {
                var $t = $(o);
                var ofs = $t.offset().top + $t.height()+50;  
                var scr = 100+window.innerHeight + document.documentElement.scrollTop;                        
                if($t.offset().left == 0 && ofs<=scr) {
                    $r = $t.find(".hover-src").last();
                }
            });
            if($r && $r.length > 0 && !$r.first().hasClass("playing")) {
                if($lastr) {
                    $lastr.each((i,l)=>{
                        $(l).removeClass("playing");
                        $(l).removeAttr("src");                                
                    });
                } 
                $r.each((i,c)=>{
                    if(!$(c).hasClass("playing")) {
                        $(c).addClass("playing");
                        $(c).attr("src",$(c).attr("data-src"));
                        var prom = c.load();
                        if(prom!=undefined) {
                            prom.then(function() {
                                c.play(); 
                            }).catch(function(error) { });
                        } else {
                            c.play();
                        }
                    }                   
                });

                $lastr = $r;
            } 
        }
    }
    
    var wall_h;
    var wall_elems = <?=@$this->pdata['wall-small']?6:9?>;
    function wallFixup() {           
        $('.wall-v').height(1);
        wall_h = ($('#nd-main').height()-$('#desk_title').height())/wall_elems;        
        //$('.wall-v .wall-item').height(wall_h);
        $('.wall-h .wall-item').height(wall_h);
        $('.wall-v').height(wall_h*wall_elems-20);        
    }
    
    function ageOK() {
        window.localStorage.ageVerify="true";
        var b = document.querySelector("body");
        b.className = b.className.replace("blur","");
    }
    
    window.addEventListener("DOMContentLoaded",()=> {
        wallFixup();
        window.addEventListener("resize",()=>wallFixup() );        
        $('.wall-item').addClass("loaded");
    });
    
    <?php
    if(@$this->pdata['cst']['require_age_verification']=="on") {
        echo 'if(window.localStorage.ageVerify!="true") document.querySelector("body").className += " blur";';
    }
    ?>

    $(() => {
        <?php
        if(@$this->pdata['cst']['require_age_verification']=="on") {
            echo 'if(window.localStorage.ageVerify!="true") {'
            . '$("#agev").modal({  escapeClose: false,  clickClose: false,  showClose: false });'
            .' }';
        }
        ?>
        $('.overlay-more').on('mousedown',()=> window.scrollBy(0,window.innerHeight));
        $('.overlay-back').on('mousedown',()=> window.scrollTo(0,0));
        window.addEventListener('scroll', () => scrollFixup() );   

        $('.hover-src').on('mouseenter',function () {
           $(this).attr("src",$(this).attr("data-src"));
        });
        var $allr;
        $('.arrow__btn').on('click',(o)=> { 
            if(window.innerWidth <= 600) {                        
                $allr = $(o.target).parents("section").first().siblings().find("video");                        
                window.setTimeout(()=>{
                    $allr.each((i,p)=>{ 
                        var $p = $(p);
                        if((i==9 || i==4) && !$p.hasClass("playing")) {                                
                            $p.addClass("playing");                                    
                            $p.attr("src",$p.attr("data-src"));                                    
                            var prom = p.load();
                            if(prom!=undefined) {
                                prom.then(function() {
                                    p.play(); 
                                }).catch(function(error) { });
                            } else {
                                p.play();
                            }
                        }
                    });   
                    $lastr = $allr;
                },100);                        
            }
        });
        $('.arrow__btn').on('click',()=> window.setTimeout(()=>{ window.scrollBy(0,1) },1200) );                
        scrollFixup();            
    });
</script>
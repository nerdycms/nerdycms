<div class="overlay-back hidden">
    <div class="arrow-container animate__animated animate__fadeInDown">
        <div class="arrow-2">
          <i class="fa fa-angle-up"></i>
        </div>
        <div class="arrow-1 animate__animated animate__hinge animate__infinite animate__zoomIn"></div>
    </div>
</div>
<?php $noswitch = @$this->pdata['cst']['prevent_theme_mode_switch']=="on"; if(!$noswitch) { ?>
<div class="overlay-sel">
    <div class="arrow-container animate__animated animate__fadeInDown">
        <div class="arrow-2" onclick="lightTog()">
            <script>
                var mde = window.localStorage['ui-mode'];
                if(!mde) mde = '<?=$this->pdata['theme-class']?>';
                if(mde=="theme-dark") {
                       document.write("<i id='uii' class='fa fa-sun'></i>");
                } else {
                    document.write("<i id='uii' class='fa fa-moon'></i>");
                }
            </script>
          
        </div>
        <div class="arrow-1 animate__animated animate__hinge animate__infinite animate__zoomIn"></div>
    </div>
</div>
<?php } ?>
<script>
    function lightTog() {
        var mde = window.localStorage['ui-mode'];
        if(mde!="theme-dark") {
            $('html').removeClass("theme-light").addClass("theme-dark");
            $('#uii').removeClass("fa-moon").addClass("fa-sun");
            window.localStorage['ui-mode'] = "theme-dark";            
        } else {
            $('html').removeClass("theme-dark").addClass("theme-light");
            $('#uii').removeClass("fa-sun").addClass("fa-moon");
            window.localStorage['ui-mode'] = "theme-light";
        }
    }
</script>
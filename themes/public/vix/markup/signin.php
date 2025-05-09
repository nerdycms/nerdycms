{{doc}}
    <head>
        {{head-main}}                
    </head>
    <body class="auth"> 
        {{back-to-top}}        
        {{nav}}        
        {{preview-banner|signin}}        
        {{footer}}      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
        <script>                                          
          $(function () {
            var $a = $('input[type=radio]');
            $a[0].checked = true;
            $($($a[0]).parents('.v-radio')[0]).addClass('select');

            var $c=$('input[checked]');
            $c.each(function () {
              $($(this).parents('.v-radio')[0]).addClass('select');
            });
            $('.v-radio').on('click',function () {
              var $t=$(this);
              if(!$t.hasClass('select')) {
                var $o=$($t.parents('.widget')[0]).find('.v-radio');
                $o.removeClass('select');
                $t.addClass('select');
              }
            });
        //	    $('.flex-h').matchHeight();
            $('.widget').matchHeight();

          });
        </script>
        {{util-scripts}}
    </body>
</html>   
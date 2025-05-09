                                               
        <div class="modal" id="forgot">
            <div class="widget"> 
                <h2>Password reset</h2>                
                <form method="post" id="fgform" action="<?=$this->hook?>?_action=forgot">
                    <div class="flex-h2">
                        <table width="100%">                                           
                          <tbody><tr>
                            <td>
                              <input type="email" name="email" placeholder="account email" required="">                      
                            </td>                                            
                          </tr>                                                                                      
                        </tbody></table>
                        <div class="v-submit text-center">
                           <button id="fgbut" type="button" class="ucase">Reset now</button><br>                         
                        </div>                            
                    </div>
                </form>
            </div>            
            
            <div id='done' class="widget d-none"> 
                <h2>Password reset sent!</h2>                                
            </div>            
        </div>

        <div class="modal" id="signin">
            <div id='login' class="widget"> 
                <h2>Member sign in</h2>
                <?php if(isset($this->pdata['error'])) echo "<div class='error'>{$this->pdata['error']}</div>"; ?>
                <form id="siform" method="post" action="<?=$this->hook?>?_action=signin">
                <div class="flex-h2">
                    <div id="sierr" class="error"></div>
                <table width="100%">                                           
                  <tbody><tr>
                    <td>
                      <input type="email" name="email" placeholder="email" required="">                      
                    </td>                                            
                  </tr>                                                                    
                  <tr>
                    <td>
                      <input type="password" name="password" placeholder="password" required="">                      
                    </td>                                            
                  </tr>                    
                </tbody></table>
                    <div class="v-submit text-center">
                        <button id="bsignin"  type="button" class="btn-signup button-background">Sign in now</button><br>
                         <a onclick="$('#forgot').modal()">forgot password?</a>
                     </div>                            
                </div>
                </form>
            </div>            
        </div>

        <div class="modal" id="topup">            
            <div id='wallet' class="d-none widget widget-mem" style="height: 504.609px;">
                <h2>Add funds to wallet</h2>
                
                <div class="flex-h">


                        <div class="v-radio select" onclick="$('#op_1').prop('checked',true);pobj.set('price_point','P1')">
                          <span class="save">$1.00</span>                  
                          <input id="op_1" type="radio" name="member" value="P1" checked=""> 
                          <span class="name">
                              Top up $50    </span>                                            
                          <span class="desc">Recurring Charge / Billed as $9.99</span>                                                        
                        </div>



                        <div class="v-radio" onclick="$('#op_2').prop('checked',true);pobj.set('price_point','2')">
                          <span class="save">$9.99</span>                  
                          <input id="op_2" type="radio" name="member" value="2"> 
                          <span class="name">
                              Top up $100 </span>
                          <span class="desc">Recurring Charge / Billed as $9.99</span>                                                        
                        </div>



                        <div class="v-radio" onclick="$('#op_3').prop('checked',true);pobj.set('price_point','3')">
                          <span class="save">$8.99</span>                  
                          <input id="op_3" type="radio" name="member" value="3"> 
                          <span class="name">
                              Top up $200                                                     </span>                                            
                          <span class="desc">Recurring Charge / Billed as $26.97</span>                                                        
                        </div>



                        <div class="v-radio" onclick="$('#op_4').prop('checked',true);pobj.set('price_point','4')">
                          <span class="save">$7.99</span>                  
                          <input id="op_4" type="radio" name="member" value="4"> 
                          <span class="name">
                              Top up $250 </span>                                            
                          <span class="desc">Recurring Charge / Billed as $47.94</span>                                                        
                        </div>                    


                <button onclick="sshow('pay')" type="button" class="btn-prim ucase">Pay now</button>                
                </div>
                
            </div>
     
        <div class="modal" id="signup">            
            <div id='sub' class="d-none widget widget-mem" style="height: 504.609px;">
                <h2>Your subscription</h2>
                
                <div class="flex-h">
                        <?php $eci = new catalog;
                              $earr = $eci->fetch("array");
                              $idx = 0;
                              foreach($earr as $ea) { $idx++; ?>

                        <div class="v-radio select" onclick="$('#op_<?=$idx?>').prop('checked',true);pobj.set('price_point','<?=$ea['aquete_code']?>')">
                          <span class="save"><?=$ea['item_tip']?></span>                  
                          <input id="op_<?=$idx?>" type="radio" name="member" value="<?=$ea['aquete_code']?>" <?=$idx==1?"checked":""?>> 
                          <span class="name">
                              <?=$ea['item_name']?>            
                          <span class="desc"><?=$ea['item_desc']?></span>                                                        
                        </div>
                    
                              <?php } ?>


                <button onclick="sshow('pay')" type="button" class="btn-prim ucase">Subscribe</button>
                <button onclick="createFree()" type="button" class="pass ucase">No thanks</button>
                </div>
                
            </div>
            <div id='create' class="widget widget-acc" style="height: 404.609px;">
                <h2 class="button-color">Create account</h2>
                
                <div class="flex-h">

                <table width="100%">                                           
                  <tbody><tr>
                    <td>
                      <input id='rusr' type="text" name="username" placeholder="username" required="">                      
                    </td>                                            
                  </tr>                                          
                  <tr>                                            
                    <td>
                      <input id="remail" type="email" name="email" placeholder="email" required="">                      
                    </td>
                  </tr>                                          
                  <tr>
                    <td>
                      <input id="rpass" type="password" name="password" placeholder="password" required="">                      
                    </td>                                            
                  </tr>                    
                </tbody></table>
                    <button onclick="sshow('sub')" type="button" class="ucase">Register</button>

                </div>
                
            </div>
                
            <div id='pay' class="d-none widget widget-pay" style="height: 504.609px;">
                <h2>Payment</h2>                        
                <div style="margin-top: 40px" id="pembed" class="col-md-12">

                </div>                        
            </div>
            
            <div id='adone' class="d-none widget widget-done">
                <h2>Account created</h2>                     
                <button onclick="$('#signin').modal();sshow('login')" type="button" class="ucase">Sign in</button>
            </div>
        </div>        

        <script src="https://dev.aquete.com/aquete-pay.js?v=0-10"></script>        
        <script>
            function createFree() {
                var dta = {
                    username: $('#rusr').val(),
                    password: $('#rpass').val(),
                    email: $('#remail').val()                    
                };
                
                $.post("<?=$this->hook?>?_action=create-free", dta, function(data){                                                
                    sshow('adone');
                });               
            }

            function sshow(k) {
                   $('.widget').addClass('d-none');
                   $('#' + k).removeClass('d-none');
            }
               
            var pobj = null; 
            function aspo() {
                if(pobj) return;
                
                window.setTimeout(function () {
                    var mde = window.localStorage['ui-mode'];
                    if(!mde) mde = '<?=$this->pdata['theme-class']?>';
            
                    pobj = newAquetePay("#pembed",{
                                                termsUrl: '<?=app::asset("terms-conditions",true)?>', 
                                                stylesUrl: '<?=app::asset("styles",true)."?_theme=flix"?>',
                                                embedToken: '<?=$_SESSION['aqu_embed']?>',
                                                theme: mde
                                                });
                    pobj.set("price_point","P1");                                
                    <?php                
                    if(isset($_SESSION['ref_from'])) echo "pobj.set('ref_from','".$_SESSION['ref_from']."');\n";               
                    ?>
                    
                },1);                
            }
            $(()=>{               
               $('.widget input[type=radio]').on('input',()=>{
                  aspo();
                  pobj.set("price_point",$(event.target).attr('value'));                   
               });
               
               $('.widget input[type=text],.widget input[type=email],.widget input[type=password]').on('input',()=>{
                   aspo();
                   pobj.set($(event.target).attr('name'),$(event.target).val()); 
               });
               
               window.setInterval(()=>{
                  if($('#rusr').val()!='') {
                      aspo();
                      if(rd = pobj.redirectUrl()) window.location.href = rd;
                  }
               },5000);
               
               $('#fgbut').on('click',()=>{                
                    var formValues = $('#fgform').serialize();
                    $.post("<?=$this->hook?>?_action=forgot", formValues, function(data){                                                
			console.log(data);
                        sshow('done');
                    });               
                });
                
                $('#bsignin').on('click',()=>{                
                    var formValues = $('#siform').serialize();
                    $.post("<?=$this->hook?>?_action=signin", formValues, function(data){                                                
                        if(data=="OK") {
                            window.location.href = "<?=VDIR?>";
                        } else {
                            $('#sierr').html(data);
                        }
                    });               
                });
            });
        </script>        
    
</div>

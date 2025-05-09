<?php 
      $rnd = substr(md5("hjdfhkjdf".mt_rand()),0,10);
      $mem = app::memberUser();      
      $sys = (new option("optSYS","system"))->fetch("vals");      
      $main = @$sys['maintenance_mode']=="Yes";
      
      $google = @(new option("optLGOOG","social-login"))->fetch("vals")["enabled"]=="Yes";
      $twitter = @(new option("optLTWIT","social-login"))->fetch("vals")["enabled"]=="Yes";
?>
<script src="https://dev.aquete.com/aquete-pay.js?v=0-66"></script>        

<div class="modal" id="agev">
    <div class="widget text-left"> 
        
        <h2>Adults only website!</h2>                       
        <hr>    
        
        <p>You must be at least 18 years old to enter this site!</p>

        <p>{{data|domain_name}} is strictly limited to those over 18 or of legal age in your jurisdiction, whichever is greater.<p>

        <p>One of our core goals is to help parents restrict access to {{data|domain_name}} for minors, so we have ensured that {{data|domain_name}} is, and remains, fully compliant with the RTA (Restricted to Adults) code. This means that all access to the site can be blocked by simple parental control tools.</p>
                <hr>
                <div class="v-submit text-right">
                    <a class='btn-sec' href="https://google.co.uk">I'm under 18 LEAVE SITE</a>
                    <a rel='modal:close' onclick='ageOK()' id="agevbutt" class="btn-prim">I'm 18+ ENTER SITE</a><br>
                    <img src="assets/rta.gif" style="margin:1rem;height: 30px">
                </div>                            
            
        
    </div>            
</div>

<div class="modal" id="forgot">
    <div id='wforgot' class="widget"> 
        <h2>Password reset</h2>                
        <form method="post" id="fgform" action="<?=VDIR?>?_action=forgot">
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
        <form id="siform" method="post" action="<?=VDIR?>?_action=signin">
        <div class="flex-h2">
            <div id="sierr" class="error"></div>
            <?php if(!$main) { ?>
            <div class="v-submit text-center">
                <?php if($google) { ?> <button id="goog"  type="button" class="btn-signup button-background"><i class='float-left fa-brands fa-google'> </i> Login with Google</button><br><?php } ?>
                <?php if($twitter) { ?> <button id="twit"  type="button" class="btn-signup button-background"><i class='float-left fa-brands fa-twitter'> </i> Login with Twitter</button><br><?php } ?>
             </div>                           
            <hr>
            <?php } ?>
            <h5>Login with email</h5>
        <table width="100%">                                           
          <tbody><tr>
            <td>
              <input type="email" name="email" placeholder="email" required="" onkeyup="if(event.which==13) $('#bsignin').trigger('click')">                      
            </td>                                            
          </tr>                                                                    
          <tr>
            <td>
              <input type="password" name="password" placeholder="password" required="" onkeyup="if(event.which==13) $('#bsignin').trigger('click')">                      
            </td>                                            
          </tr>                    
        </tbody></table>
            <div class="v-submit text-center">
                <button id="bsignin" type="button" class="btn-signup button-background">Sign in now</button><br>
                <a class="high-color" onclick="sshow('wforgot')">forgot password?</a><br><br>
                 No account? <a class="high-color" onclick="sshow('create')">Sign up</a> now!
             </div>                       
        </div>
        </form>
    </div>            
</div>

<div class="modal" id="topup">            
    <div id='wallet' class="d-none widget widget-mem">
        <h2>Your wallet</h2>
        <br><br>
        <div class="flex-h">

            <?php
                $ment = new member;
                $ma = $ment->fetch("id",$mem);
                echo "<h4>Wallet balance $".(empty($amt = @$ma['wallet_balance'])?"0.00":$amt)."</h4><div id='wterr' class='error'></div><button type='button' id='usebal' class='btn-prim ucase mt-2'>Use balance</button><hr><h4>Top up</h4><br>";
                $eci = new catalog(["where"=>"item_type='Wallet'"]);
                $earr = $eci->fetch("array");
                $idx = 0;
                foreach($earr as $ea) { $idx++; ?>

                <div class="v-radio select" onclick="$('#op_<?=$idx?>').prop('checked',true);pobj.set('price_point','<?=$ea['aquete_code']?>')" value="<?=$ea['aquete_code']?>">
                  <span class="save"><?=$ea['item_tip']?></span>                  
                  <input id="op_<?=$idx?>" type="radio" name="wallet" value="<?=$ea['aquete_code']?>" <?=$idx==1?"checked":""?>> 
                  <span class="name">
                      <?=$ea['item_name']?>            
                  <span class="desc"><?=$ea['item_desc']?></span>                                                        
                </div>

                <?php } ?>


            <br><br>
        <button onclick="sshow('pay')" type="button" class="btn-prim ucase">Top up now</button>                
        <br><br><br>
        <table class='pp-icons'>
            <tr>
                <td>
                    <img src='assets/icons/calendar-256@green.png'>
                    Daily updates
                </td>
                <td>
                    <img src='assets/icons/customer service@green.png'>
                    24/7 Customer support
                </td>
            </tr>
            <tr>
                <td>
                    <img src='assets/icons/discreet@green.png'>
                    Discreet billing
                </td>            
                <td>
                    <img src='assets/icons/all devices@green.png'>
                    All devices
                </td>
            </tr>
            <tr>    
                <td>
                    <img src='assets/icons/secure@gree.png'>
                    Secure transactions
                </td>
                <td>
                    <img src='assets/icons/fast cdn@green.png'>
                    Blazing fast CDN
                </td>
            </tr>
        </table>
    </div>

<div class="modal" id="signup">            
    <div id='sub' class="d-none widget widget-mem">
        <h2>Your subscription</h2>
        <br><br>
        <div class="flex-h">
            <div id="suerr" class="error"></div>
                <?php $eci = new catalog(["where"=>"item_type='Membership'"]);
                      $earr = $eci->fetch("array");
                      $idx = 0;
                      foreach($earr as $ea) { $idx++; ?>

                <div class="v-radio select" onclick="$('#op_<?=$idx?>').prop('checked',true);pobj.set('price_point','<?=$ea['aquete_code']?>')">
                  <span class="save"><?=$ea['item_tip']?></span>                  
                  <input class='pop' id="op_<?=$idx?>" type="radio" name="member" value="<?=$ea['aquete_code']?>" <?=$idx==1?"checked":""?>> 
                  <span class="name">
                      <?=$ea['item_name']?>            
                  <span class="desc"><?=$ea['item_desc']?></span>                                                        
                </div>

                      <?php } ?>
        <div class="d-block">              
            <span id="card" onclick="setMeth('card')" class="pay-meth meth-active" style="background-image:url(assets/payMCard.png)">
                Card
            </span>
            <span id="crypto" onclick="setMeth('crypto')" class="pay-meth" style="background-image:url(assets/payMBTC.png)">
                Crypto
            </span>                              
        </div>
        <button onclick="doSub()" type="button" class="btn-prim ucase">Subscribe</button>
        <?php if(!app::memberUser()) { ?>
        <button onclick="createFree()" type="button" class="pass ucase">No thanks</button>
        <?php } ?>
        </div>
        
        <table class='pp-icons'>
            <tr>
                <td>
                    <img src='assets/icons/calendar-256@green.png'>
                    Daily updates
                </td>
                <td>
                    <img src='assets/icons/customer service@green.png'>
                    24/7 Customer support
                </td>
            </tr>
            <tr>
                <td>
                    <img src='assets/icons/discreet@green.png'>
                    Discreet billing
                </td>            
                <td>
                    <img src='assets/icons/all devices@green.png'>
                    All devices
                </td>
            </tr>
            <tr>    
                <td>
                    <img src='assets/icons/secure@gree.png'>
                    Secure transactions
                </td>
                <td>
                    <img src='assets/icons/fast cdn@green.png'>
                    Blazing fast CDN
                </td>
            </tr>
        </table>

    </div>
    <div id='create' class="widget widget-acc">
        <?php if($main) { ?>
        <h2 class="button-color">Service unavailable</h2>
        <div class="flex-h">

        <div class="v-submit text-center">
            <h5>Maintenance mode enabled</h5>    
        </div></div>
        <?php } else { ?>
        <h2 class="button-color">Create account</h2>

        <div class="flex-h">

        <div class="v-submit text-center">
            <?php if($google) { ?> <button id="goog2"  type="button" class="btn-signup button-background"><i class='float-left fa-brands fa-google'> </i> Login with Google</button><br> <?php } ?>
            <?php if($twitter) { ?> <button id="twit2"  type="button" class="btn-signup button-background"><i class='float-left fa-brands fa-twitter'> </i> Login with Twitter</button><br> <?php } ?>                       
             </div>                           
            <hr>
            <h5>Create email account</h5>    
        <table width="100%">                                           
          <tbody><tr>
            <td>
              <input id='rusr' type="text" name="username" placeholder="username" required="" <?=MODE=="super"?" value='$rnd'":""?>>                      
            </td>                                            
          </tr>                                          
          <tr>                                            
            <td>
              <input id="remail" type="email" name="email" placeholder="email" required="" <?=MODE=="super"?" value='$rnd@random.com'":""?>>                      
            </td>
          </tr>                                          
          <tr>
            <td>
              <input id="rpass" type="password" name="password" placeholder="password" required="" <?=MODE=="super"?" value='R4nd0M'":""?>>                      
            </td>                                            
          </tr>                    
        </tbody></table>
            <button onclick="sshow('sub')" type="button" class="ucase">Register</button><p>
            <div>Existing user? <a class="d-inline-block high-color" onclick="sshow('login')">Login</a> here</div></p>
        </div>
        <?php } ?>
    </div>

    <div id='pay' class="d-none widget widget-pay">
        <div id="pembed" class="col-md-12">

        </div>           
        <div class="text-center m-1 font-small">
            You must be at least 18 to join {{data|sitename}}
        </div>
    </div>

    <div id='adone' class="d-none widget widget-done">
        <h2>Account created</h2>                     
        <button onclick="$('#signin').modal();sshow('login')" type="button" class="ucase">Sign in</button>
    </div>
</div>        
<script>
    var meth = "card";
    var setMeth = (m) => {
        meth = m;        
        $('.pay-meth').removeClass("meth-active");   
        $('#' + m).addClass("meth-active");        
    }

    var doSub = ()=> {
         var dta = {
            username: $('#rusr').val(),
            password: $('#rpass').val(),
            email: $('#remail').val()                    
        };

        $.ajax({url:"<?=VDIR?>?_action=prem-check", data:dta, complete:function(data){  
            var r = data.responseText;
            switch(r) {
                 case 'BADE':
                    $('#suerr').html("Error creating account");
                    break;
                case 'UN':
                    $('#suerr').html("Username or Email already taken");
                    break;               
                case 'OK':
                    if(meth=="card") {
                        sshow('pay');
                    } else {
                        if(svalid('pay')) {
                            if(pobj) {
                                $('.jquery-modal').remove();
                                pobj.goCrypto();
                            }
                        }
                    }
                    break;
                default:
                    $('#suerr').html("Account created!");
                    break;
            }                
        }});
                    
    };

    function createFree() {
        var dta = {
            username: $('#rusr').val(),
            password: $('#rpass').val(),
            email: $('#remail').val()                    
        };

        $.post("<?=VDIR?>?_action=create-free", dta, function(data){                                                
            var t = data.split(':');
            if(t[0]=="OK") { 
                sshow('adone');
                window.setTimeout(()=>{ window.location.href = '/sso/'+t[1]; },2000);
            } else switch(data) {
                case 'BADE':
                    $('#suerr').html("Error creating account");
                    break;
                case 'UN':
                    $('#suerr').html("Username or Email already taken");
                    break;
                default:
                    $('#suerr').html("Account created!");
                    break;
            }
        });               
    }

    function svalid(k){ 
        console.log(k);
        try {            
           var $cur = $(event.target).parents(".widget");
           if($cur && $cur.is(":visible")) {
               var fail = false;
               $cur.find("input").each(function (i,o) {
                    switch($(o).attr('type')) {                        
                        case "radio":
                            break;
                        case "email":
                            if($(o).is(":visible") && $(o).val().indexOf("@")==-1) { $(o).addClass("required"); fail = true; console.log('bad-email',o);}
                            else $(o).removeClass("required");   
                            break;
                        default:
                            if($(o).is(":visible") && $(o).val()=="") { $(o).addClass("required"); fail = true; console.log('missing-required',o);}
                            else $(o).removeClass("required");   
                        break;
                    }
               });
               if(fail) {                   
                   return false;
               }
           }
       } catch (ex) {}
       
        aspo();
        var pp = $('#' + k).find("input[type=radio]").first().attr('value');
        if(pp!==undefined) pobj.set("price_point",pp);                   
        console.log(pp);
        
        return true;
    }

    function sshow(k) {        
        if(k=='wforgot'||k=="create" || k=="login" || svalid(k)) {
            $('#' + k).parents(".modal").first().modal();
            $('.widget').addClass('d-none');
            $('#' + k).removeClass('d-none');    
            $('#' + k).find("input[type=radio]").first().prop('checked',true); 
            if(k=="login") $('#bsignin').focus();
        }
    }

    var method = "card";
    var pobj = null; 
    function aspo() {
        if(pobj) return;

        //window.setImmediate(function () {                                        
            var mde = window.localStorage['ui-mode'];
            if(!mde) mde = '<?=$this->pdata['theme-class']?>';

            pobj = newAquetePay("#pembed",{
                                        termsUrl: '<?=app::asset("terms-conditions",true)?>', 
                                        stylesUrl: '<?=app::asset("styles",true)."?_theme=vix"?>',
                                        embedToken: '<?=@$_SESSION['aqu_embed']?>',
                                        theme: mde,
                                        clickID: '<?=@$_SESSION['clid_from']?>'
                                        });
            //pobj.set("price_point",$dpp);
            pobj.events = (m)=> { alert(m); };
            <?php 
            if(MODE=="super") { ?>
                $(()=>{
                    $('#create input').each((i,o)=>{
                        pobj.set($(o).attr('name'),$(o).val()); 
                    });
                });            
            <?php }               
            if(isset($_SESSION['ref_from'])) echo "pobj.set('ref_from','".$_SESSION['ref_from']."');\n";               
            if($mem) {
                $ment = new member;
                $ma = $ment->fetch("id",$mem);
                if($ma) {
                    echo "pobj.set('username','".$ma['username']."');\n";               
                    echo "pobj.set('email','".$ma['email']."');\n";               
                } 
            }                
            ?>

        //},1);                
    }
    $(()=>{               
       $('.widget input[type=radio]').on('input',()=>{
          aspo();
          var pp = $(event.target).attr('value');
          console.log(pp);
          pobj.set("price_point",pp);                   
       });

       $('.widget input[type=text],.widget input[type=email],.widget input[type=password]').on('input',()=>{
           aspo();
           pobj.set($(event.target).attr('name'),$(event.target).val()); 
       });

       window.setInterval(()=>{
          //var $ru = $('#rusr');  
          //if($ru.length>0 && $ru.val().length>0) {
              //aspo();
              if(pobj && ""!=(rd = pobj.redirectUrl())) {                  
                  if(rd!=undefined) window.location.href = rd;
              }
          //}
       },2000);
       
       $('#usebal').on('click',()=>{                            
            $.ajax({url: window.location.href + "&_action=usebal", complete: function(resp){                                                
                var data = resp.responseText;    
                console.log(data);
                if(data=="OK") {
                    window.location.reload();
                } else {
                    $('#wterr').html(data);
                }
            }});               
        });

       $('#fgbut').on('click',()=>{                
            var formValues = $('#fgform').serialize();
            $.post("<?=VDIR?>?_action=forgot", formValues, function(data){                                                
                sshow('done');
            });               
        });

        $('#bsignin').on('click',()=>{                
            var formValues = $('#siform').serialize();
            $.post("<?=VDIR?>?_action=signin", formValues, function(data){                                                
                console.log(data);
                if(data=="OK") {
                    window.location.reload();
                } else {
                    $('#sierr').html(data);
                }
            });               
        });

        $('#twit').on('click',()=>{                                    
            $('#siform').attr("action","<?=VDIR?>?_action=signin-twitter");
            $('#siform').submit();                    
        });

        $('#goog').on('click',()=>{                                    
            $('#siform').attr("action","<?=VDIR?>?_action=signin-google");
            $('#siform').submit();
        });

        $('#twit2').on('click',()=>{                                    
            $('#siform').attr("action","<?=VDIR?>?_action=signin-twitter");
            $('#siform').submit();                    
        });

        $('#goog2').on('click',()=>{                                    
            $('#siform').attr("action","<?=VDIR?>?_action=signin-google");
            $('#siform').submit();
        });
        
        <?php if($shw = @$_SESSION['auth_show']) { unset($_SESSION['auth_show']); ?>
        sshow('<?=$shw?>');
<?php   } else if($shw = app::request("_auto")) { ?>
        sshow('<?=$shw?>');
<?php } ?>
    });
</script>            
    </div></div>

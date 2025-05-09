<?php
$mode = isset($data[1])?$data[1]:"home";
if($name = app::request("_model-name")) {
    $rs = app::slug($name, " ");
    $ent = new video(["where"=>"models LIKE '%$rs%' AND publish_status='Published'"]);
    $mode = "model";
} else {
    $ent = new video(["where"=>"sexuality='Straight' AND show_on_homepage='Yes' AND publish_status='Published'"]);
}
$list = $ent->fetch("array");
if(sizeof($list)>4) {
    //do {    
        $a = $list[random_int(0, sizeof($list)-1)];        
    //} while($ent->meta($a,"poster")=="https://new.nerdyvids.com" || !app::http_file_exists($ent->meta($a,"preview")));
} else {
    $a = @$list[0];
}

if($mode=="home") {
    $ent2 = new trailer(["where"=>"enabled='Yes'"]);
    $list2 = $ent2->fetch("array");
    if(sizeof($list2)>4) {
        //do {    
            $a2 = $list2[random_int(0, sizeof($list2)-1)];        
        //} while($ent->meta($a,"poster")=="https://new.nerdyvids.com" || !app::http_file_exists($ent->meta($a,"preview")));
    } else {
        $a2 = @$list2[0];
    }
}

if(!($a||$a2) && $mode=="model") app::redirect("/bio-coming-soon"); 

$istrail = false;
if(isset($a2)) {
    $a3 = $a;
    $a = $a2;
    $a2 = $a3;
    $istrail = true;
} else {
    $ent2 = $ent;
}

?>  
<div class="preview <?=$mode?>">
    
    <div id="ovt" class="overlay-text <?=$istrail?"d-none":""?>">
        <?php if($mode=="home") { ?>
        <h1 class='high-color ucase'><?=@$a['title']?></h1>
        <?php } else if($mode=="model") { ?>
        <h1 class='high-color ucase'><?=$rs?></h1>
        <?php } else if($mode=="reset") { ?>
        
        <div class="widget widget-reset"> 
                <h2>Enter new password</h2> 
                <?=@$this->pdata['error']?"<div class='error'>{$this->pdata['error']}</div>":""?>
                <form method="post" id="rsform" action="<?=$this->hook?>?_action=reset">
                    <input type="hidden" name="_rtkn" value="<?=app::request("_rtkn")?>">
                    <div class="flex-h2">
                        <table width="100%">                                           
                          <tbody><tr>
                            <td>
                              <input type="password" name="password" placeholder="new password" required="">                      
                            </td>    
                              </tr><tr>
                            <td>
                              <input type="password" name="password_confirm" placeholder="confirm password" required="">                      
                            </td>                                            
                          </tr>                                                                                      
                        </tbody></table>
                        <div class="v-submit text-center">
                           <button type="submit" class="ucase">Reset now</button><br>                         
                        </div>                            
                    </div>
                </form>
            </div>
        <?php } else if($mode=='reset-ok') { ?>
        <div class="widget widget-reset"> 
            <h2>Reset complete!</h2>   <br><br>             
                <p>You can now login with your new password</p>                
            </div>
        <?php } else if($mode=='cust-service') { ?>
        <div class="widget widget-service"> 
                <h2>Customer service</h2> 
                <?=@$this->pdata['error']?"<div class='error'>{$this->pdata['error']}</div>":""?>
                <form method="post" id="rsform" action="<?=$this->hook?>?_action=service">
                    <input type="hidden" name="_rtkn" value="<?=app::request("_rtkn")?>">
                    <div class="flex-h2">
                        <table width="100%">                                           
                          <tbody><tr>
                            <td>
                              <input type="text" name="cs_funame" placeholder="full name" required="">                      
                            </td>    
                              </tr><tr>
                            <td>
                              <input name="cs_email" placeholder="email" required="" type="email">                      
                            </td>                                            
                            </tr><tr>
                            <td>
                              <input type="text" name="cs_subject" placeholder="subject" required="">                      
                            </td>    
                            </tr><tr>
                            <td>
                                <textarea name="cs_message" placeholder="message" required=""></textarea>
                            </td>    
                          </tr>                                                                                      
                        </tbody></table>
                        <div class="v-submit text-center">
                           <button type="submit" class="ucase">Send</button><br>                         
                        </div>                            
                    </div>
                </form>
            </div>
         <?php } else if($mode=='cust-sent') { ?>
        <div class="widget widget-sent"> 
            <h2>Message sent</h2>   <br><br>             
                <p>Please wait at least 48 hours for a response from our team</p>                
            </div>
        <?php } ?>
        
    </div>         
    <?php if($mode!="signup" && $mode!="signin") { ?>
    <div class="overlay-more">
        <div class="arrow-container animate__animated animate__fadeInDown">
            <div class="arrow-2">
              <i class="fa fa-angle-down"></i>
            </div>
            <div class="arrow-1 animate__animated animate__hinge animate__infinite animate__zoomIn"></div>
        </div>
    </div>         
    <?php } ?>    
    <video id="pvid" autoplay="" <?=$istrail?"":"loop=''"?> muted="" playsinline="" class="bkg" poster="<?=@$ent->meta($a,"poster")?>" src="<?=@$ent2->meta($a,$istrail?"video":"preview")?>"></video>        
</div>

<?php if($istrail) {    ?>
<script>
    document.getElementById('pvid').addEventListener('ended',handlePVE,false);
    function handlePVE(e) {
        e.target.src = '<?=$ent->meta($a2,'preview')?>';
        e.target.loop = '';
        $('#ovt').removeClass('d-none');
    }
</script>    
<?php }
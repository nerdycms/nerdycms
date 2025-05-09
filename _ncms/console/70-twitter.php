<?php
class twitter {                   
    function schedule() {     
    
    }
            
    function run($rkey,$arg) {        
        $sett = (new option("optLTWIT", "social-login"))->fetch("vals");
        if(@$sett['auto_post_enabled']=='Yes') {
            $tp = new twitPost($sett);
            $vid = new video;        
            if($vd = $vid->fetch("id",$arg['video'])) {
                $file = $vid->meta($vd,'preview');
                if(strpos($file,"://")!==false) {
                    $fdn = explode(".",substr(DOM, 8))[0];    
                    $nn = "/tmp/$fdn-twitter.mp4";
                    @unlink($nn);                    
                    copy($file, $nn);
                    $file = $nn;
                } else $file = ROOT.$file; 
                if(filesize($file)==0) {
                    runner::tailJob("twitter", $arg);
                    return;
                }                
                if(!$tp->postVideo($file,$arg['text'])) return "POSTFAIL";
            }            
        }        
    }    
}




<?php

// Author: Simon Newton
 
class referrals extends handler {
    static $hooks = ["*"];   
    
    function try($hook) {
        if($from = app::request("_from")) {
              $ent = new member;
              $fr = $ent->fetch("md5","mmm",$from);
              $_SESSION['ref_from'] = $fr['id'];
              app::redirect(app::currentUrl());        
              return "complete";
        }
        
        if($clid = app::request("_ncms_click_id")) {              
              $_SESSION['clid_from'] = $clid;
              app::redirect(app::currentUrl());        
              return "complete";
        }
    }
}

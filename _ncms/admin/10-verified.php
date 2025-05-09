<?php

// Author: Simon Newton

class verified extends handler {
    static $hooks = ["*"];
    
    function try($hook) {
        $aquv = @$_SESSION['aqu_v'];
        if(!$aquv) {
            $mer = new merchant;
            $all = $mer->fetch("array");                
            $_SESSION['aqu_v'] = $aquv = sizeof($all)>0 && $all[0][9]=='Verified';            
        }
        if(!$aquv) {
            app::$adminNav[11] = "billing|verification pending";            
        }      
    }
}
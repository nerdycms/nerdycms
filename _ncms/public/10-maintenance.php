<?php

// Author: Simon Newton

class maintenance extends handler {
    static $hooks = ["*"];    
    
    function try($hook) {
        $isint = $_SERVER['REMOTE_ADDR'] == PRIVATE_IP;        
        if($isint || app::memberUser() || MODE=="super") {
            $aquv=true;
        } else {    
            $aquv = @$_SESSION['aqu_v'];
            if(!$aquv) {
                $mer = new merchant;
                $all = $mer->fetch("array");                

                $_SESSION['aqu_v'] = $aquv = sizeof($all)>0 && $all[0][9]=='Verified';
            }
        }

        $sys = (new option("optSYS","system"))->fetch("vals");
        
        if(!$isint && (@$sys['maintenance_mode']=="Yes" || !$aquv) && !app::memberUser()) {
            //$portal->hook("styles",new styles());
            if(app::request("_action")=="signin") {                
                $post = app::post("?");

                $ent = new member;
                $m = $ent->fetch("by","email",$post['email']);  
                if($post['email']==ADMIN_USER && $post['password']==ADMIN_PASSWORD) {
                    app::memberLogin(-1,"Premium");                
                    echo "OK";
                } else {
                    $ent = new adm;
                    if($a = $ent->fetch("byci","username",$post['email'])) {
                        if(password_verify($post['password'], $a['password'])) {
                            app::memberLogin($a['id'],"Premium");                
                            echo "OK";
                            exit();
                        } 
                    } 
                    echo "Incorrect email / password";                        
                }
                exit();
            }
            $page = new bbPage("maintenance");
            $page->handle();
            return "complete";
        } else {
            if(!isset($_SESSION['aqu_embed'])) {
                //$sett = (new option("optAquete", "billing"))->fetch("vals");
                $_SESSION['aqu_embed'] = AQU_EMBED_TKN; //@$sett['embed_token'];
            } 
        }
    }
}
<?php

// Author: Simon Newton

class admin extends handler {
    static $hooks = ["admin/","admin"];
    
    function try($hook) {
        $page = new bbPage("auth-login",function ($pge) {                   
            if($post = app::post()) {                
                //$ent = new member;
                //$m = $ent->fetch("by","email",$post['email']);                
                //if($m && password_verify($post['password'], $m['password'])) { 
                if($post['username']==ADMIN_USER && $post['password']==ADMIN_PASSWORD) {
                    app::adminLogin(-1);
                    app::redirect("/admin/dashboard");        
                } else {
                    $ent = new adm;
                    if($a = $ent->fetch("byci","username",$post['username'])) {
                        if(password_verify($post['password'], $a['password'])) {
                            app::adminLogin($a['id']);
                            app::redirect("/admin/dashboard");        
                        }
                    }

                    $pge->pdata['error'] = "Incorrect username / password";
                }
            }
        });
        $page->handle();
        exit();
    }    
}
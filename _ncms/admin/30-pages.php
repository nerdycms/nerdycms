<?php

// Author: Simon Newton

class pages extends handler {
    static $hooks = ["*"];
    var $match;
    
    function maybe($try,$page) {                
        if($this->match == $try) {
            $page->handle();
            exit();
        }
    }
    
    function try($hook) {
        if(!app::adminUser()) die();               
        
        app::$mainNav = new labelledSet(app::$adminNav);
        $this->match = substr($hook,strlen("admin/"));
        
        if($hook == "admin/reset-cache") {
            app::$ctkn=app::newTkn();
            file_put_contents(SYS_CONTENT_DIR.'/asset-cache-tag.txt', app::$ctkn);
            exit();
        }
        
        if($hook == "do-update") {
            update::upgrade();
            app::redirect("/dashboard");
            exit();
        }

        if(app::request("_action")=="stat") {
            echo json_encode(app::stats());
            exit();
        }

        $this->maybe("dashboard",new page("dash"));            
        $this->maybe("video-queue",new queuePage("pages-queue","rt-process.json","ffmpeg"));                        
        //$this->maybe("quick-settings",new inpPage("pages-inp","main","inp-quick",new option("optQuick","main")));            
        $this->maybe("seo",new inpPage("pages-inp","seo-group","inp-seo",new option("optSEO","seo-group")));            

        $this->maybe("add-trailer",new inpPage("pages-inp","videos","inp-trail",new trailer));            
        $this->maybe("all-trailers",new entPage("apps-ent-grid|pages-inp","inp-trail",new trailer));            

        $this->maybe("add-video",new inpPage("pages-inp","videos","inp-video",new video));            
        $this->maybe("add-live-stream",new inpPage("pages-inp","videos","inp-lstream",new video));            
        $this->maybe("published-videos",new entPage("apps-ent-grid|pages-inp","inp-video",new video(["where"=>"casting_on is null AND publish_status='Published'"])));            
        $this->maybe("draft-videos",new entPage("apps-ent-grid|pages-inp","inp-video",new video(["where"=>"casting_on is null AND publish_status='Draft'"])));                        
        
        $this->maybe("post-to-twitter",new inpPage("pages-inp","videos","inp-ttwitter",null,function ($page) {
            if($st = @app::post("_submit_type")) {                
                $vid = app::request("_video");
                if($st=="submit") {                    
                    runner::tailJob("twitter", ["video"=>$vid,"text"=>app::post("post_body")]);
                }
                app::redirect("/admin/published-videos?_id=$vid");
            }
        }));            
        
        $this->maybe("live-streams",new entPage("apps-ent-grid|pages-inp","inp-lstream",new video(["where"=>"casting_on is not null"])));                        
        $this->maybe("tags",new inpPage("pages-inp","videos","inp-tags",new tag));            
        $this->maybe("categories",new inpPage("pages-inp","videos","inp-categories",new category));            

        $this->maybe("add-model",new inpPage("pages-inp","models","inp-model",new model));            
        $this->maybe("all-models",new entPage("apps-ent-grid|pages-inp","inp-model",new model));    

        $this->maybe("content-settings",new inpPage("pages-inp","content","inp-cntset",new option("optcns","appearance")));                       
        $this->maybe("system-pages",new sysPage("content"));            
        $this->maybe("add-page",new inpPage("pages-inp","content","inp-cpage",new customPage));            
        $this->maybe("all-pages",new entPage("apps-ent-list|pages-inp","inp-cpage",new customPage)); 

        $this->maybe("add-blog-post",new inpPage("pages-inp","blog","inp-blog",new blog));            
        $this->maybe("all-posts",new entPage("apps-ent-list|pages-inp","inp-blog",new blog));    

        $this->maybe("themes",new inpPage("pages-inp","appearance","inp-theme",new theme));           
        $this->maybe("general",new inpPage("pages-inp","appearance","inp-genapp",new option("optgap","appearance")));                       
        $this->maybe("custom-menu-items",new entPage("apps-ent-list|pages-inp","inp-cmitem",new customMenuItem));                

        $this->maybe("all-members",new entPage("apps-ent-list|pages-inp","inp-member",new member(["where"=>"banned='No' OR banned IS null"])));    
        $this->maybe("banned-members",new entPage("apps-ent-list|pages-inp","inp-member",new member(["where"=>"banned='Yes'"])));    
        $this->maybe("mass-email",new page("pages-mass",function () {
            if($post = app::post()) {
                $post['target'] = app::slug($post["target"]);                    
                $post['template'] = app::slug($post['template']);
                $lf = SYS_CONTENT_DIR."/message-log.txt";
                exec("nohup php index.php mass-message $post[target] $post[template] >> $lf &");
                app::redirect("/admin/message-log");                    
            }
        }));    
        $this->maybe("mass-sms",new page("pages-ann",function () {
            if($post = app::post()) {
                $post['target'] = app::slug($post["target"]);                                        
                $ent = new smsBody;
                $bid = $ent->action("assert",["body"=>$post['message']]);                    
                $lf = SYS_CONTENT_DIR."/message-log.txt";
                exec("nohup php index.php mass-sms $post[target] $bid >> $lf &");
                app::redirect("/admin/message-log");                    
            }
        }));
        $this->maybe("announcements",new page("pages-ann",function () {
            if($post = app::post()) {
                $post['target'] = app::slug($post["target"]);                                        
                $ent = new smsBody;
                $bid = $ent->action("assert",["body"=>$post['message']]);                    
                $lf = SYS_CONTENT_DIR."/message-log.txt";
                exec("nohup php index.php mass-ann $post[target] $bid >> $lf &");
                app::redirect("/admin/message-log");                    
            }
        }));
        $this->maybe("message-settings",new inpPage("pages-inp","messaging","inp-mess",new option("optMess","messaging")));    

        $this->maybe("referral-settings",new inpPage("pages-inp","storage","inp-ref",new option("optRef","members")));    
        $this->maybe("stats",new page("dash"));        
        
        $this->maybe("verification-pending",new page("vpend"));             

        //$this->maybe("billing-settings",new inpPage("pages-inp","billing","inp-aquete",new option("optAquete","storage")));    
        $this->maybe("pricing",new entPage("apps-ent-list|pages-inp","inp-pricing",new pricePoint()));    
        $this->maybe("payments",new entPage("apps-ent-list|pages-inp","inp-payout",new payout()));    
        //$this->maybe("vendo",new inpPage("pages-inp","storage","inp-vendo",new option("optVendo","storage")));    

        $this->maybe("google-settings",new inpPage("pages-inp","social-login","inp-lgoogle",new option("optLGOOG","social-login")));            
        $this->maybe("twitter-settings",new inpPage("pages-inp","social-login","inp-ltwitter",new option("optLTWIT","social-login")));            

        $this->maybe("bunny",new inpPage("pages-inp","storage","inp-bunny",new option("optBunny","storage")));    
        $this->maybe("amazon",new inpPage("pages-inp","storage","inp-amazon",new option("optAmazon","storage")));    
        $this->maybe("google",new inpPage("pages-inp","storage","inp-google",new option("optGoogle","storage")));    
        $this->maybe("ftp",new inpPage("pages-inp","storage","inp-ftp",new option("optFTP","storage")));    
        $this->maybe("dropbox",new inpPage("pages-inp","storage","inp-drop",new option("optDrop","storage")));    

        $this->maybe("running-tasks",new logPage("pages-log","lasttask.txt"));                        
        $this->maybe("message-log",new logPage("pages-log","message-log.txt"));                        

        $this->maybe("admin-users",new entPage("apps-ent-list|pages-inp","inp-adm",new adm));

        $this->maybe("system-settings",new inpPage("pages-inp","system","inp-sys",new option("optSYS","system")));    

        $this->maybe("catalog",new entPage("apps-ent-list|pages-inp","inp-catalog",new catalog));    
        $this->maybe("transactions",new entPage("apps-ent-list|pages-inp","inp-transaction",new transaction));    
        $this->maybe("email-templates",new entPage("apps-ent-list|pages-inp","inp-em-template",new emTemplate));    
        $this->maybe("domains",new entPage("apps-ent-list|pages-inp","inp-domain",new domain)); 
    }
}
<?php

// Author: Simon Newton
require_once ROOT.'/vendor/dropbox/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;


class drop {
    function schedule() {
        $aid = -1;
        $home = hash('sha256',"19sgh635t32$aid");            
        $_SESSION['homeDir'] = $home;
                
        if(disk_free_space(MEM_CONTENT_DIR)<20*1024*1024*1024) {
            app::log("Disk space low! suspended","debug","drop");                        
            return;
        }
        $queue = @json_decode(@file_get_contents(DROP_IMPORT_DIR."/queue.json"),true);
        if(!$queue) $queue = [];        
        if(sizeof($queue)>0) {
            $sett = (new option("optDrop", "storage"))->fetch("vals");                  
            if(empty($sett['key']) || empty($sett["secret"]) || empty($sett["access_token"])) return;
            //Configure Dropbox Application
            //$app = new DropboxApp($sett['key'], $sett["secret"], $sett["access_token"]);
            //Configure Dropbox service
            //$dropbox = new Dropbox($app);

            foreach($queue as $k=>$fp) {
                if(strpos($fp,":downloaded")!==false)                        return;
                runner::tailJob(get_class(),$fp);
            }
        }            
    }
    
    function run($rkey,$arg) {
        $sett = (new option("optDrop", "storage"))->fetch("vals");                  
        if(empty($sett['key']) || empty($sett["secret"]) || empty($sett["access_token"])) return;
        //Configure Dropbox Application
        $app = new DropboxApp($sett['key'], $sett["secret"], $sett["access_token"]);
        //Configure Dropbox service
        $dropbox = new Dropbox($app);
        $fp = $arg;    
        $f = str_replace("/","__",$fp);                    
        if($dropbox->download("/".$fp,DROP_IMPORT_DIR."/$f")) {                        
            app::log("$fp downloaded","debug","drop");                        
            $nn = md5($f.time()).".".pathinfo($f,PATHINFO_EXTENSION);                        
            $np = MEM_CONTENT_DIR.'/'.app::homeDir()."/temp/".$nn;      
            $path = app::homeDir()."/".$nn;      
            rename(DROP_IMPORT_DIR."/$f",$np);

            $attr = json_encode(app::get_video_attributes($np));
            $t = new task("slides","/usr/bin/php ".ROOT."/index.php slidemov $np");
            $t->run();

            $fa = explode("/", $fp);
            $fn = $fa[sizeof($fa)-1];

            $vent = new video();
            $title = ucwords(app::slug(str_replace("_","!",pathinfo($fn,PATHINFO_FILENAME))," "));
            $seo_url = app::slug(str_replace("_","!",pathinfo($fn,PATHINFO_FILENAME)),"-");
            $arr = ["seo_url"=>$seo_url,"title"=>$title,"publish_status"=>"Draft","video_url"=>$path,"poster_url"=>app::homeDir()."/slides/".$nn."__002.jpg","attributes"=>$attr ];

            //app::log(json_encode($arr),"debug","drop");
            $res = $vent->action("assert",$arr);
            //app::log("result:".json_encode($res),"debug","drop");                                                
            $queue[$k] .= ":downloaded";
            file_put_contents(DROP_IMPORT_DIR."/queue.json", json_encode($queue));
        } else return true;
    }
}
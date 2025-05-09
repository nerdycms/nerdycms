<?php

// Author: Simon Newton

class logs extends handler {
    static $hooks = ["*"];
    var $match;
    
    function feed($try,$fn) {
        if($this->match == $try) {
            header("Content-type: text/plain");
            $f = @fopen($fn,"r");
            if($f) {
                $sz = filesize($fn);
                $bs = 500*1024;
                if($sz > $bs) fseek($f, $sz-$bs);
                if($sz < $bs) $bs = $sz;
                if($bs>0) {
                    $data = explode("\n",fread($f, $bs));                    
                    foreach($data as $d) {
                        if(empty($d)) continue;                        
                        if(strpos($d,"\r")!==false) {
                            $da = explode("\r",$d);
                            echo $da[sizeof($da)-2]."\n";                            
                        } else {                            
                            echo $d."\n";                            
                        }
                    }
                }
                fclose($f);
            } else {
                echo "Empty...";
            }
            exit();
        }
    }
    
    function try($hook) {
        $this->match = substr($hook,strlen("admin/"));
        
        $this->feed("bulk.txt",SYS_CONTENT_DIR."/bulk.log");
        $this->feed("drop.txt",SYS_CONTENT_DIR."/drop.log");
        $this->feed("message-log.txt",SYS_CONTENT_DIR."/message-log.txt");
        $this->feed("lasttask.txt",SYS_CONTENT_DIR."/runner.log");                                                  
    }    
}
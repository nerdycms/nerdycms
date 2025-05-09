<?php
app::check();

class portal {
    var $hooks = [];  
    var $mainNav = null;
    var $view = null;
    var $pre = "";
    static $lang=null;
    
    function __construct($pre="/") {        
        $this->pre = $pre;
        
        if(!self::$lang) {
            $f = fopen(SYS_CONTENT_DIR."/lang-en.csv","r");
            while($r = fgetcsv($f)) {
                $allLang[strtolower($r[0])] = $r[1];
            }
            fclose($f);
        }
    }
    
    function hook($path,$handler) {
        $this->hooks[$path] = $handler;
    }   
    
    function handle() {      
        
        if(($aid = app::adminUser())!==null) {
            $aent = new adm;
            $adm = $aid<0?["username"=>"ADMIN","access"=>""]:$aent->fetch("id",$aid);
            if($aid>0) $adm['access'] .= ",system->admin users";
        }
        $url = app::currentUrl();          
        foreach ($this->hooks as $path=>$handler) {   
            $cn = null;                        
            if($aid!==null) {
                $epath = str_replace("-", " ", $path);
                foreach(app::$adminNav as $a) {
                    $ia = explode("|",$a);
                    if(sizeof($ia)==1 && $ia[0]==$epath) $cn = $ia;
                    else if(in_array($epath, $ia)) $cn = $ia;
                }
            }
            
            if($cn) {
                $skip = false;
                if(strpos($adm['access'].",",$cn[0].",")!==false) $skip = true;                        
                foreach($cn as $cp) if(strpos($adm['access'].",",$cn[0]."->".$cp.",")!==false) $skip = true;                        
                if($skip)                continue;
            }            
            
            $path = $this->pre?$this->pre.$path:$path;
            $idx = strpos($path,"/*");
            $epath = $idx!==false?substr($path, 0, $idx):$path;                        
            $eurl = $idx!==false?substr($url,0,$idx):$url;
            
            if($eurl==$epath || $epath=='*') {
                if(is_a($handler,"asset")) {
                    $handler->portal = $this;
                    $handler->hook = $path;
                    $handler->handle();
                } elseif(is_string($handler)) {
                    $page = new page($handler);
                    $page->portal = $this;
                    $page->hook = $path;
                    $page->handle();
                } else {
                    $handler($this);
                }
                exit();
            }
        }
    }
}

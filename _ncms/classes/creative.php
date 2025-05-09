<?php
class creative extends bbPage {
    public function __construct() {                
        parent::__construct(app::request("_file"));
    }
    
    function load($name) {        
        global $allLang;
        
        ob_start();
        $ifn = ROOT."/creatives/$name.html";
        if(!file_exists($ifn)) $ifn = ROOT."/creatives/$name/index.html";                    
        include $ifn;
        $raw = ob_get_contents();
        
        ob_end_clean();            

        $idx = strpos($raw,"{{");
        while($idx!==false) {
            $end = strpos($raw, "}}", $idx);
            $tag = substr($raw, $idx,$end-$idx+2);
            $data = explode('|',substr($tag, 2,-2));

            ob_start();
            include THEME_DIR."/".$GLOBALS['portal']."/".$GLOBALS['theme']."/markup/includes/$data[0].php";                    
            $blk = ob_get_contents();
            ob_end_clean();

            $raw = str_replace($tag, $blk, $raw);
            $idx = strpos($raw,"{{",$end);
        }

        echo $raw;
    }     
}

<?php
class bbAsset {
    var $pdata;
    
    function __construct() {
        $this->pdata = app::pageData();
    }
    
    function render($raw) {                
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

        return $raw;
    }               
}

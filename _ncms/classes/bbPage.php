<?php


class bbPage extends page {    
    function load($name) {        
        global $allLang;
        
        ob_start();
        include THEME_DIR."/".$GLOBALS['portal']."/".$GLOBALS['theme']."/markup/$name.php";                    
        $raw = ob_get_contents();
        ob_end_clean();            

        $ot = 10;
        $idx = strpos($raw,"{{");
        while($idx!==false && $ot--) {            
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
            $idx = strpos($raw,"{{");
        } 

        echo $raw;
    }        
}

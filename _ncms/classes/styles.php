<?php
class styles extends asset {
    function handle() {        
        header("Content-type: text/css");
        $cnt = file_get_contents(THEME_DIR."/".$GLOBALS['portal']."/".$GLOBALS['theme']."/assets/styles.css");
        echo $cnt;       
    }
}

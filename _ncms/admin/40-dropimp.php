<?php

// Author: Simon Newton

class dropimp extends handler {
    static $hooks = ["admin/dropbox-import","admin/drop-refresh"];
    
    function try($hook) {
        switch($hook) {
            case "admin/dropbox-import":
                $page = new page("dropbox-import");
                $page->handle();
                exit();
            case "admin/drop-refresh":
                self::dropImp();                                
                exit();
        }                   
    }
}
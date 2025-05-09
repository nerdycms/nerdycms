<?php

// Author: Simon Newton

class creatives extends handler {
    static $hooks= [
            "creative"
        ];    
    
    function try($hook) {
        $page = new creative();
        $page->handle();
        return "complete";
    }
}
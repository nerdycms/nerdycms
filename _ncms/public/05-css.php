<?php

// Author: Simon Newton

class css extends handler {
    static $hooks= [
            "styles"
        ];    
    
    function try($hook) {
        $page = new styles();
        $page->handle();
        return "complete";
    }
}
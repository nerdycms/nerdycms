<?php
class asset {
    var $hook;
    var $portal;
    
    public function __construct() {
        $this->hook = app::currentUrl();
    }
    
    function handle() {             
        echo "";
    }
}

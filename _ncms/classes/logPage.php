<?php
app::check();

class logPage extends page {    
    var $file;
    
    function __construct($name,$file) {
        parent::__construct($name);
        $this->file = $file;
    }
}
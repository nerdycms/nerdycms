<?php
app::check();

class labelledSet extends multiSet {
    var $labels = [];
    var $icons = [];
    
    function label($key) {    
        global $allLang;        
        $key = isset($this->labels[$key])?$this->labels[$key]:$key;        
        return isset($allLang[$key])?$allLang[$key]:ucfirst(str_replace(["-","_"]," ",$key));
    }
    
    function icon($key) {               
        global $allIcons;
        return isset($this->icons[$key])?$this->icons[$key]:(isset($allIcons[$key])?$allIcons[$key]:"grid");
    }
}
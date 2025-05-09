<?php
app::check();

class multiSet {
    var $items = [];    
    var $not = [];
           
    public function __construct($items) {
        $this->items = $items;
    }
            
    public function in($sel,$key) {
        return $key!="id" && !(@is_array($this->not[$sel]) && in_array($key, $this->not[$sel]));
    }
    
    function items($sel=null) {     
        foreach ($this->items as $key) {
            if(!$this->in($sel,$key)) continue;
            $ret []= $key;
        }                       
        return $ret;
    }
}
<?php
app::check();

class ent {
    var $pre="";
    var $key;    
    var $cols;
    var $plural,$singular,$group;
    
    static function newRef($seed = null, $len = 10) {
        if($seed) mt_srand($seed);
        
        $chars = "0123456789";
        $ret = "";
        $max = strlen($chars)-1;
        while(strlen($ret)<$len) {
            $ridx = $seed?mt_rand(0, $max):random_int(0, $max);
            $ret .= $chars[$ridx];
        }        
        if($seed) mt_srand();
        
        return $ret;
    }
    
    function __construct($key,$group) {
        $this->key = $key;                
        $this->group = ucfirst($group);          
        $this->plural = ucfirst($key."s"); //SN_TODO
        $this->singular = ucfirst($key);
    }   

    function cell($key,$a) {
        return $a[$this-> pre.$key];
    }
}
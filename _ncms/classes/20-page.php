<?php

class page extends asset {    
    var $name;    
    var $pfunc;
    var $pdata = [];
    var $view;
    
    function __construct($name,$pfunc=null) {
        parent::__construct();
        $this->pdata = app::pageData();        
        $this->name = $name;
        $this->pfunc = $pfunc;
    }
    
    function mergeData($data) {
        foreach($data as $k=>$v) $this->pdata[$k] = $v;
    }
    
    function pageTitle() {
        return $this->title()." | ".PAGE_TITLE_POST;
    }
    
    function title($arg=null) {
        global $allLang;
        $key = substr($this->hook,1);
        if($key=="") $key="404";
        return isset($allLang[$key])?$allLang[$key]:ucfirst(str_replace(["-","_"]," ",$key));
    }
    
    function load($name) {
        global $allLang;
       /* if($GLOBALS['portal']=="admin") {            
            ob_start();
            include THEME_DIR."/".$GLOBALS['portal']."/".$GLOBALS['theme']."/markup/$name.php";                    
            $this->content = ob_get_contents();
            ob_end_clean();            
            include THEME_DIR."/".$GLOBALS['portal']."/".$GLOBALS['theme']."/markup/$this->view.php";
        } else {*/
            include THEME_DIR."/".$GLOBALS['portal']."/".$GLOBALS['theme']."/markup/$name.php";                    
        //}        
    }
    
    function handle() {
        if($this->pfunc) {
            $func = $this->pfunc;
            $func($this);
        }
        
        $this->load($this->name);
    }
}

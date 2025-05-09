<?php
app::check();

class entPage extends inpPage {        
    function __construct($name,$def,$ent) {
        $na = explode("|",$name);                
        if(sizeof($na)>1) {
            $id = app::request("_id");
            parent::__construct($id!==null?$na[1]:$na[0],$ent->group,$def,$ent);   
        } else {
            parent::__construct($na[0],$ent->group,$def,$ent);   
        }
    }
    
    function title($arg=null) {
        global $allLang;
        if(!empty(app::request("_id"))) {
            $key = @$arg->submit=="none"?"viewing":"editing";
            return _l(str_replace(["-","_"]," ",$key)." ".$this->ent->singular);
        } else if(isset($_GET["_id"])) {
            $key = "adding";
            return _l(str_replace(["-","_"]," ",$key)." ".$this->ent->singular);
        } else {
            return parent::title();
        }        
    }    
}

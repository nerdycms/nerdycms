<?php

// Author: Simon Newton

class custom extends handler {
    static $hooks = ["*"];
    
    function try($hook) {
        $cpge = new customPage;
        $arr = $cpge->fetch("array");
        foreach($arr as $a) {
            if($hook==@$a["hook"]) {   
                if(!empty($a['alias_of'])) {
                    $cldr = new loader($a['alias_of'],['o_hook'=>explode("?",$a['alias_of'])[0],'page_header'=>$a['aliased_header'],'page_title'=>$a['page_title'],'page_description'=>$a['description'],'page_keywords_meta'=>$a['keywords']]);
                    exit();
                } else {
                    $page = new bbPage("custom",function ($pge) use($a) {
                        $pge->pdata['page_keywords_meta'] = $a['keywords'];                        
                        $pge->pdata['page_description'] = $a['description'];                        
                        $pge->pdata['page_title'] = $a['page_title'];                        
                        $pge->pdata["custom-body"] = str_replace(["[[","]]"],["<",">"],$a['body']);
                    }); 
                    $page->handle();
                    return "complete";
                }
            }            
        }
    }
}
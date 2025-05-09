<?php

define('TRYINT',60);

class redgifs {
    function schedule() {
        return;
        $last = @file_get_contents(SYS_CONTENT_DIR."/lastredgifs.txt");
        if(!$last || time()-$last >= TRYINT) {
            runner::tailJob("redgifs", null);
            file_put_contents(SYS_CONTENT_DIR."/lastredgifs.txt", time());
        }
    }
    
    function cget($url,$hdrs = null) {                
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Accept: application/json";
        if($hdrs) foreach($hdrs as $h) {
            $headers[] = $h;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'error:' . curl_error($ch);
        }
        curl_close ($ch);
        return $result;
    }
    
    function run($rkey,$arg) {
        $ctx = stream_context_create(['http'=>['timeout'=>10]]);
        $ar = $this->cget("https://api.redgifs.com/v2/oauth/login");
        app::log(var_export($ar,true),"debug","redgifs");                        
    }
}
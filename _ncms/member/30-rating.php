<?php

// Author: Simon Newton

class rating extends handler {
    static $hooks = ["*"];    
    
    function try($hook) {
        $mid = app::memberUser();
        if(app::request("_action")=="rate") {
            $vid = app::post("video");
            $rat = app::post("rating");
            if($rat<0) {
                $rv = -1;
            } else {
                $rv = 1;
            }                
            $rent = new urating;
            if($rp = $rent->fetch("existing",$vid,$mid)) {
                $rent->action("assert",["id"=>$rp['id'],"rating"=>$rv,"vid_id"=>$vid]);
                echo 'CHANGE';
            } else {                
                $rent->action("assert",["usr_id"=>$mid,"rating"=>$rv,"vid_id"=>$vid]);
                echo 'ADD';
            }

            return "complete";
        }

        if(app::request("_action")=="comment") {
            $vid = app::post("video");
            $com = app::post("comment");
            if(strlen($com)>250) $com = substr($com,0,247)."...";                
            $cent = new ucomment;
            if($cp = $cent->fetch("existing",$vid,$mid)) {
                $cent->action("assert",["id"=>$cp['id'],"comment"=>$com,"vid_id"=>$vid]);
                echo 'CHANGE';
            } else {                
                $cent->action("assert",["usr_id"=>$mid,"comment"=>$com,"vid_id"=>$vid]);
                echo 'ADD';
            }                
            return "complete";
        }    
    }
}
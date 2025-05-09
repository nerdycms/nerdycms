<?php

// Author: Simon Newton

class walTrans extends handler {
    static $hooks = ["*"];
    
    function try($hook) {
        if(app::request("_action")=="usebal") {          
            if(($mid = app::memberUser())<=0) echo "Error: 200";
            else if($name = app::request("_video")) {  
                $vid = new video;
                if(!($v = $vid->fetch("linked",$name))) echo "Error: 400";
                else {
                    $mem = new member;
                    $m = $mem->fetch("id",$mid);                    
                    $price = app::memberRole() != "Free"?$v['premium_member_view_price']:$v['free_member_view_price'];
                    if($price <=0) echo "Error: 600";
                    else if($price>$m['wallet_balance']) echo "Not enough funds in wallet!";
                    else {
                        $ref = "REF".ent::newRef();
                        $wat = new walletTransaction;                    
                        if(!$wat->action("assert",[
                            "tdatetime"=>date('Y-m-d H:i:s'),"tuser_id"=>$mid,"tref"=>$ref,"tamount"=>$price,"tstatus"=>"complete","ttype"=>"purchase","tinfo"=>app::clientIP() . " [" . app::clientCountry() . "]","pitem_id"=>$v['id'],"pitem_type"=>'video'
                        ])) echo "Error: 300";
                        else {
                            $mem->action("wallet_debit",$mid,$price);
                            echo "OK";
                        }
                    }     
                }
            } else echo "Error: 100";             
            exit();
        }
    }
}
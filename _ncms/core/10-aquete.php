<?php

// Author: Simon Newton

class aquete extends handler {
    static $hooks = ["aqu-hook"];    
    
    function try($hook) {   
        if($data = app::post()) {     
            $lf = SYS_CONTENT_DIR."/message-log.txt";
            $time = $data["time"];
            $secure = hash("sha256", AQU_API_KEY."$data[username]$data[email]$time");
            if($secure == $data['secure']) {
                switch($data['action']) {
                    case "suspend-member":
                        $ent = new member;
                        $e = $ent->fetch("by","email",$data["email"]);                    
                        if($e) { 
                            $ent->action("assert",[ "id"=>$e['id'],"urole"=>'Suspended']);                        
                        }
                        break;
                    case "cancel-member":
                        $ent = new member;
                        $e = $ent->fetch("by","email",$data["email"]);                    
                        if($e) { 
                            $ent->action("assert",[ "id"=>$e['id'],"urole"=>'Cancelled']);                        
                        }
                        break;
                    case "credit-member":
                        $ent = new member;
                        $e = $ent->fetch("by","email",$data["email"]);
                        $cent = new catalog;
                        $ci = $cent->fetch("by","aquete_code",$data["pcode"]);
                        if($e && $ci) { 
                            $ent->action("assert",[ "id"=>$e['id'],"wallet_balance"=>$e['wallet_balance']+$ci['wallet_value']]);

    /*                        if(isset($data["ref_from"])) {
                                $mr = new mref;
                                $mr->action("assert",["from_id"=>$data["ref_from"],"new_mem_id"=>$eid,"stamp"=>date('Y-m-d H:i:s')]);                            
                            }*/
                            $trn = new transaction;
                            $trn->action("assert",[ "tuser_id"=>$e['id'],"tref"=>$data["ref"],"tamount"=>$data['amount'],"tstatus"=>"Approved",
                                                    "citem_id"=>$ci['id'],"tdatetime"=>date('Y-m-d H:i:s'),"ttype"=>"Credit","tinfo"=>$data['pcode'],"prov"=>"Aquete","prov_json"=>json_encode($data)]);

                            exec("nohup php index.php auto-message $e[id] member-purchase >> $lf &");

                            echo "::reload::";                                     
                        }
                        break;
                    case "activate-member":
                        //"username","email","password","signup_domain","active","banned","urole","created"
                        $sso = hash("sha256","ghjdygSDSDSD".random_int(0,PHP_INT_MAX-1))."|".(time()+1800);
                        $ent = new member;
                        $e = $ent->fetch("by","email",$data["email"]);
                        $cent = new catalog;
                        if(!($ci = $cent->fetch("by","aquete_code",$data["pcode"]))) break;
                        $trn = new transaction;
                        if(!$e) { 
                            $eid = $ent->action("assert",["sso_token"=>$sso,"created_date"=>date('Y-m-d H:i:s'),"username"=>$data['username'],"email"=>$data['email'],
                                                    "password"=> $data['password'],"signup_domain"=>$_SERVER['HTTP_HOST'],
                                                    "active"=>"Yes","banned"=>"No","urole"=>"Premium"]);

                            if(isset($data["ref_from"])) {
                                $mr = new mref;
                                $mr->action("assert",["from_id"=>$data["ref_from"],"new_mem_id"=>$eid,"stamp"=>date('Y-m-d H:i:s')]);                            
                            }

                            $trn->action("assert",[ "tuser_id"=>$eid,"tref"=>@$data["ref"],"tamount"=>$data['amount'],"tstatus"=>"Approved",
                                                    "citem_id"=>$ci['id'],"tdatetime"=>date('Y-m-d H:i:s'),"ttype"=>"Create member","tinfo"=>$data['pcode'],"prov"=>"Aquete","prov_json"=>json_encode($data)]);

                            exec("nohup php index.php auto-message $eid new-subscription >> $lf &");

                            //echo VDIR."?_auto=login";                                     
                        } else {
                            //if(!empty(@$data['password'])) $ent->action("assert",["sso_token"=>$sso,"id"=>$e['id'],"urole"=>"Premium","password"=> password_hash($data['password'],PASSWORD_DEFAULT)]);
                            //else 
                            $ent->action("assert",["sso_token"=>$sso,"id"=>$e['id'],"urole"=>"Premium"]);
                            if(isset($data["ref_from"])) {
                                $mr = new mref;
                                $mr->action("assert",["from_id"=>$data["ref_from"],"new_mem_id"=>$e['id'],"stamp"=>date('Y-m-d H:i:s')]);                            
                            }

                            $trn->action("assert",[ "tuser_id"=>$e['id'],"tref"=>@$data["ref"],"tamount"=>$data['amount'],"tstatus"=>"Approved",
                                                    "citem_id"=>$ci['id'],"tdatetime"=>date('Y-m-d H:i:s'),"ttype"=>"Activate member","tinfo"=>$data['pcode'],"prov"=>"Aquete","prov_json"=>json_encode($data)]);

                            exec("nohup php index.php auto-message $e[id] member-upgrade >> $lf &");

                            //echo "::reload::";                                   
                        }
                        echo VDIR."sso/$sso";
                        break;
                    default:
                //        echo $data['action'];
                        break;
                }                
            } //else echo "INVALID";
            return "complete";
        }    
    }
}

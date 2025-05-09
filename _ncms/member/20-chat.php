<?php

// Author: Simon Newton

class chat extends handler {
    static $hooks = ["video-chat"];    
    
    function try($hook) {            
        if($act = app::request("_action")) {
            switch($act) {            
                case "insert-chat":
                    $outgoing_id = app::request("_other");
                    $incoming_id = @app::post('_incoming_id');
                    $message = $_POST['_message'];
                    if(!empty($message)){
                        $ent = new message;
                        if(!is_numeric($outgoing_id)) {
                            $ent2 = new video;
                            $a2 = $ent2->fetch("linked",$outgoing_id);
                            $outgoing_id = -1*$a2['id'];
                        }
                        $ent->action("assert",["msg"=>$message,"incoming_msg_id"=>$incoming_id,"outgoing_msg_id"=>$outgoing_id]);                            
                    }                        
                    break;
                case "get-chat":
                  //  echo "GET";
                    $outgoing_id = app::request("_other");
                    $all = true;
                     if(!is_numeric($outgoing_id)) {
                            $ent2 = new video;
                            $a2 = $ent2->fetch("linked",$outgoing_id);
                            $outgoing_id = -1*$a2['id'];
                            $all = true;
                        }
                    $incoming_id = app::post('_incoming_id');
                    $output = "";
                    if($all) {
                        $sql = "SELECT * FROM msg LEFT JOIN usr ON usr.id = msg.incoming_msg_id "
                            ."WHERE (outgoing_msg_id = {$outgoing_id}) "
                           ."ORDER BY msg.id ";
                    } else {
                        $sql = "SELECT * FROM msg LEFT JOIN usr ON usr.id = msg.outgoing_msg_id "
                            ."WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) "
                           ."OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg.id ";
                    }
                    $ent = new message;
                    $query = $ent->fetch("raw",$sql);
                    if(mysqli_num_rows($query) > 0){
                        while($row = mysqli_fetch_assoc($query)){
                            if($all) {
                                $cls = @$row['incoming_msg_id']?"outgoing":"incoming";
                                $name = @$row['username']??ADMIN_CAST_NAME;
                                $output .= '<div class="chat '.$cls.' chat_group">                                    
                                        <div class="details">
                                            <p>'. $row['msg'] .'</p>                                            
                                                <small>@'.$name.'</small>
                                        </div>

                                        </div>';
                            } else if($row['outgoing_msg_id'] === $outgoing_id) {
                                $output .= '<div class="chat outgoing">
                                            <div class="details">
                                                <p>'. $row['msg'] .'</p>
                                            </div>
                                            </div>';
                            } else {
                                $output .= '<div class="chat incoming">
                                            <img src="'.@$row['img'].'" alt="">
                                            <div class="details">
                                                <p>'. $row['msg'] .'</p>
                                            </div>
                                            </div>';
                            }
                        }
                    } else {
                        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
                    }
                    echo $output;                         
                break;
            }
        }
        return "complete";
    }
}

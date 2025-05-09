<?php

// Author: Simon Newton
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class profile extends handler {
    static $hooks = [   "file-upload",
                        "profile"   ];    
    
    function try($hook) {
        switch($hook) {
            case "file-upload":
                $ext = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);                
                if(in_array($ext,["jpg","bmp","png","gif","jpeg"])) {
                    @unlink(MEM_CONTENT_DIR."/".app::homeDir()."/profile.$ext");
                    move_uploaded_file($_FILES["file"]["tmp_name"],$file=MEM_CONTENT_DIR."/".app::homeDir()."/profile.$ext");                    
                    app::dealWithHEIC($file);
                    $ent = new member;
                    $ent->action("assert",["id"=>app::memberUser(),"profile_img"=>"profile.$ext"]);
                } else {                    
                    unlink($_FILES["file"]["tmp_name"]);
                    http_response_code(500);
                }
                break;
            case "profile":
                $mid = app::memberUser();
                $page = new bbPage("profile",function ($pge) use ($mid) {
                    $ent = new mref; //SN_TODO REWORK
                    $pge->pdata['list'] = $ent->fetch("for",$mid);

                    if($dis = app::request("did")) {
                        $ann = new announce;                    
                        $ann->action("assert",["id"=>app::request("did"),"been_read"=>'Yes']);
                    }

                    if(app::request("_action")=="about-save") {
                        $ent = new member;
                        $data = app::post(["first_name","last_name","country","date_of_birth","occupation","mobile","phone","bio"]);
                        $data['id'] = app::memberUser();
                        $ent->action("assert",$data);                    
                    }
                    
    
                    if(app::request("_action")=="support") {  
                        $sett = (new option("optMess","messaging"))->fetch("vals");
                        $data = app::post("?");

                        try {
                            $mail = new PHPMailer(true);
                            // Server settings
                            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
                            $mail->isSMTP();
                            $mail->Host = $sett['smtp_server'];
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = $sett['smtp_port'];

                            $mail->Username = $sett['smtp_username'];
                            $mail->Password = $sett['smtp_password'];

                            // Sender and recipient settings
                            $mail->setFrom($sett['smtp_username']);

                            //$mail->addAddress($o->email);
                            $mail->addAddress("simonnewt8@gmail.com");
                            $mail->addAddress("judd@aquete.com");
                            //$mail->addAddress("simonnewt@outlook.com");
                            //$mail->addReplyTo($gmailid, $gmailusername); // to set the reply to

                            // Setting the email content
                            $mail->IsHTML(true);
                            $mail->Subject = "Support request [{$u['username']}]";

                            $body = "";
                            foreach($data as $k=>$v) {
                                $body .= "$k:<br>$v<br><br>";
                            }

                            $mail->Body = $body;

                            if($mail->send()) {
                                app::redirect("/profile?_group=support-sent");
                            } else {
                                echo "FAIL";
                            }        
                        } catch (Exception $e) {
                            echo "ERROR";
                            //var_dump($e);
                        }    
                    }

                });
                $page->handle();
                break;
            }
        
        return "complete";                
    }
}
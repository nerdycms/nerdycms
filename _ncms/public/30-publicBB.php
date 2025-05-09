<?php

// Author: Simon Newton

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class publicBB extends handler {
    static $hooks= [
            ">landing",
            //"index.php>landing",
            "model>model",
            "bio-coming-soon>biocs",
            "models>models",
            "gallery>gallery",
            "video>video",
            "videos>videos",
            "categories>videos",
            "video-tags>videos",
            "blog>blog>handle_blog",
            "customer-service>cust-service>handle_service",
            "message-sent>cust-sent",
            "report>report",
        ];    
    
    static function handle_blog($page) {
        if($id=app::request("_id")) {
            $ent = new blog;
            $a = $ent->fetch("id",$id);
            $page->pdata['page_title'] = $a['title'];
            $page->pdata['page_keywords_meta'] = $a['keywords'];                        
            $page->pdata['page_description'] = $a['description'];                                    
        }
    }
    
    static function handle_service($page) {
        if(app::request("_action")=="service") {
                $syssett = (new option("optSYS","system"))->fetch("vals"); 
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

                    $mail->addAddress($syssett['support_request_email']);                    

                    // Setting the email content
                    $mail->IsHTML(true);
                    $mail->Subject = "Support request [{$data['cs_funame']}]";

                    $body = "";
                    foreach($data as $k=>$v) {
                        $body .= "$k:<br>$v<br><br>";
                    }

                    $mail->Body = $body;

                    if($mail->send()) {
                        app::redirect("/message-sent");
                    } else {
                        echo "FAIL";
                    }        
                } catch (Exception $e) {
                    echo "ERROR";
                    //var_dump($e);
                }    
            }
    }
    
}
<?php

// Author: Simon Newton
require_once ROOT . '/vendor/hybridauth/src/autoload.php';
require_once ROOT . '/vendor/hybridauth/src/Hybridauth.php';

use Hybridauth\Hybridauth;

require_once ROOT.'/vendor/phpmailer/src/Exception.php';
require_once ROOT.'/vendor/phpmailer/src/PHPMailer.php';
require_once ROOT.'/vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
        
class login extends handler {
    static $hooks = ["*"];   
    
    function try($hook) {
        $page = null;
        $sysSett = (new option("optSYS", "system"))->fetch("vals");
        if(app::request("_action")=="prem-check") {                       
            $ent = new member;
            
            $emailExists = $ent->fetch("by", "email", $_REQUEST["email"]);
            $usernameExists = $ent->fetch("by", "username", $_REQUEST["username"]);
            
            if($emailExists || $usernameExists) {
                echo "UN"; // Username or Email already taken
            } else {                        
                $evalid = true;
                $ea = @explode('@',$_REQUEST['email']);
                if(sizeof($ea)>1) {
                    $tea = explode('.',$ea[1]);
                    if(sizeof($tea)<2) $evalid = false;
                } else {
                    $evalid = false;
                }
                if($evalid) {                    
                    echo "OK";
                } else echo "BADE";
            }
            exit();
        } else if(app::request("_action")=="create-free") {                
            $lf = SYS_CONTENT_DIR."/message-log.txt";
            $sso = hash("sha256","ghjdygSDSDSD".random_int(0,PHP_INT_MAX-1))."|".(time()+1800);
            $data = app::post("?");
            $ent = new member;
            
            $emailExists = $ent->fetch("by", "email", $_REQUEST["email"]);
            $usernameExists = $ent->fetch("by", "username", $_REQUEST["username"]);
            
            if($emailExists || $usernameExists) {
                echo "UN"; // Username or Email already taken
            } else {                        
                $evalid = true;
                $ea = @explode('@',$data['email']);
                if(sizeof($ea)>1) {
                    $tea = explode('.',$ea[1]);
                    if(sizeof($tea)<2) $evalid = false;
                } else {
                    $evalid = false;
                }
                if($evalid) {
                    $eid = $ent->action("assert",[ "sso_token"=>$sso,"created_date"=>date('Y-m-d H:i:s'),"username"=>$data['username'],"email"=>$data['email'],
                                                        "password"=> $data['password'],"signup_domain"=>$_SERVER['HTTP_HOST'],
                                                        "active"=>"Yes","banned"=>"No","urole"=>"Free" ]);
                    exec("nohup php index.php auto-message $eid free-signup >> $lf &");
                    echo "OK:$sso";
                } else echo "BADE";
            }
            exit();
        } else if(strpos($hook,"sso/")===0) {
	    $sso = urldecode(app::urlTail());
            $soa = explode("|",$sso);
            $ent = new member;
            $m = $ent->fetch("by","sso_token",$sso);    

            if($m) {        
                $ent->action("assert",["id"=>$m['id'],"sso_token"=>""]);
                if($soa[1]>time()) {            
                   app::memberLogin($m['id'],$m['urole']);
                   app::redirect("/");        
	           		
                }
            } echo "SSO ERROR [$sso]$soa[1]-".time();	
            return "complete";		
        } else if($hook=="reset-complete") $page = new bbPage("reset-ok");
        elseif($hook=="password-reset") { $page = new bbPage("reset",function ($pge) {
            $rent = new resetIntent;        

            if(!($tok = app::request("_rtkn")) || !($rst = $rent->fetch("by","token",$tok))) app::redirect ("/reset-complete");                                

            if(app::request("_action")=="reset") {
                $pwd = app::post("password");
                $pwc = app::post("password_confirm");

                if($pwd!=$pwc) {
                    $pge->pdata['error'] = "Confirm does not match!";
                } else {
                    $ment = new member;                        
                    $ment->action("assert",["id"=>$rst['usr_id'],"password"=>$pwd]);
                    app::redirect("/reset-complete");                                
                }
            }
        }); } else if($hook=="signup") {
            if(!isset($_SESSION['auth_show'])) {
                $_SESSION['auth_show'] = "create";                
                app::redirect("/".@$sysSett['direct_signup_background_url']??"");
            }
        } else if($hook=="signin") {
            if(!isset($_SESSION['auth_show'])) {
                $_SESSION['auth_show'] = "login";
                app::redirect("/".@$sysSett['direct_signin_background_url']??"");
            }
        }
        if($page) {
            $page->handle();
            return "complete";
        }
        
        if(app::request("_action")=="signin-twitter") {                
            $sett = (new option("optLTWIT", "social-login"))->fetch("vals");
            $config = [ "callback"=>DOM.VDIR."social-auth",
                        'providers'=>[
                            'Twitter'=> [
                                'enabled'=>true,
                                'keys'=> [
                                    "key"=>$sett['consumer_key'],
                                    "secret"=>$sett['consumer_secret'] 
                                ]
                            ]
                        ] 
                    ];
            try {
                $hybridauth = new Hybridauth($config);

                $adapter = $hybridauth->authenticate('Twitter');

                //$adapter = new \Hybridauth\Provider\Twitter(app::$ha_config);

        //        $adapter->authenticate();//SN_NOTE is rqd?

                $tokens = $adapter->getAccessToken();
                $userProfile = $adapter->getUserProfile();

            // print_r($tokens);
            // print_r($userProfile);

                $adapter->disconnect();
                echo "OK";
            }
            catch (\Exception $e) {
                echo 'Oops, we ran into an issue! ' . $e->getMessage();
            }
            exit();
        }

        if(app::request("_action")=="signin-google") {                
            $sett = (new option("optLGOOG", "social-login"))->fetch("vals");
            $config = [ "callback"=>DOM.VDIR."social-auth",
                        'providers'=>[
                            'Google'=> [
                                'enabled'=>true,
                                'keys'=> [
                                    "key"=>$sett['client_id'],
                                    "secret"=>$sett['client_secret'] 
                                ]
                            ]
                        ] 
                    ];

            try {
                $hybridauth = new Hybridauth($config);

                $adapter = $hybridauth->authenticate('Google');

                $tokens = $adapter->getAccessToken();
                $userProfile = $adapter->getUserProfile();

            // print_r($tokens);
            // print_r($userProfile);

                $adapter->disconnect();
                echo "OK";
            }
            catch (\Exception $e) {
                echo 'Oops, we ran into an issue! ' . $e->getMessage();
            }
            exit();
        }

        if(app::request("_action")=="signin") {                
            $post = app::post("?");                        
            $ent = new member;
            $m = $ent->fetch("by","email",$post['email']);              
            if($post['email']==ADMIN_USER && $post['password']==ADMIN_PASSWORD) {
                app::memberLogin(-1,"Premium");                
                echo "OK";
            } else if($m && ((DEV && $post['password']==ADMIN_PASSWORD) || password_verify($post['password'], $m['password']))) { 
                app::memberLogin($m['id'],$m['urole']);        
                $_SESSION['member_username'] = $m['username'];
                $_SESSION['member_email'] = $m['email'];
                $_SESSION['member_membership'] = $m['urole'];
                $ent->action("assert",["id"=>$m['id'],"last_login_ip"=>app::clientIP(),"last_login_country"=> app::clientCountry(),"last_login_at"=>date('Y-m-d H:i:s')]);        
                echo "OK";
            } else {
                echo "Incorrect email / password";
            }
            exit();
        }
        
        if(app::request("_action")=="forgot") {                
            $tpl = new emTemplate;
            $trow = $tpl->fetch("by","tpl_key","password-reset");               
            if(!$trow) die("\nBad template");

            $ment = new member;
            $mem = $ment->fetch("by","email",strtolower(app::post("email")));
            if(!$mem) die("\nBad email");

            $rent = new resetIntent;
            $tkn = app::random(null, 120);
            $rent->action("assert",["usr_id"=>$mem['id'],"expires"=>time()+600,"token"=>$tkn]);

            $sett = (new option("optMess","messaging"))->fetch("vals");

            $body = $trow['body'];
            $subject = $trow['email_subject']; 
            try {
                $mail = new PHPMailer(true);
                // Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
                $mail->isSMTP();
                $mail->Host = $sett['smtp_server'];
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $sett['smtp_port'];

                $mail->Username = $sett['smtp_username'];
                $mail->Password = $sett['smtp_password'];

                // Sender and recipient settings
                $mail->setFrom($sett['smtp_username']);
                $mail->addAddress($mem['email']);
                //$mail->addAddress("simonnewt8@gmail.com");
                //$mail->addAddress("judd@aquete.com");
                //$mail->addAddress("simonnewt@outlook.com");
                //$mail->addReplyTo($gmailid, $gmailusername); // to set the reply to

                // Setting the email content
                $mail->IsHTML(true);
                $mail->Subject = $subject;

                $ass = new bbAsset();
                $ass->pdata['verification_url'] = "https://".$_SERVER['HTTP_HOST']."/password-reset?_rtkn=$tkn";

                $mail->Body = $ass->render($body);        

                if($mail->send()) {
                    echo "OK";
                } else {
                    echo "FAIL";
                }        
            } catch (Exception $e) {
                echo "ERROR";
            }
            exit();
        }
    }
}

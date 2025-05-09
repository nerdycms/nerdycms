<?php
@session_start();
// Author: Simon Newton

define("NROOT", __DIR__."/");
define("ROOT", dirname(NROOT));

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 

include 'config/config.php';

error_reporting(DEV_ERRLVL);

class loader {
    var $sets = ["public","core"];
    var $pdata;
    
    function __construct($url=null,$pdata=null) {
        if($url) {
            $hd = [];
            @parse_str(parse_url($url, PHP_URL_QUERY),$hd);            
            foreach($hd as $k=>$v) {
                $_REQUEST[$k]=$v;
                $_GET[$k]=$v;
            }
        }
        $this->pdata = $pdata;
        $page = null;          
        $url = substr(app::currentUrl($url),1);        
        if(app::memberUser()) $this->sets = ["member","public","core"];
        if(strpos($url,"admin/")===0 || $url=="admin") {            
            $GLOBALS['theme'] = "min";
            $resp = $this->run($url,"admin");       
        } else {
            $GLOBALS['theme'] = "vix";
            foreach($this->sets as $s) {
                $resp = $this->run($url,$s);
                if($resp=="complete") break;
            }
        }  
        if($resp!="complete") {
            $page = new bbPage("404");
            $page->handle();
        }
    }
    
    static function loadables($dir) {
        $files = scandir($dir);
        $ret = [];
        foreach ($files as $f) {
            if(pathinfo($ffn = "$dir/$f",PATHINFO_EXTENSION)=="php") $ret []= $ffn;
        }
        return $ret;
    }
    
    function inst($l) {
        $n = pathinfo($l,PATHINFO_FILENAME);
        return explode("-",$n)[1];
    }
    
    function run($url,$s) {       
        $GLOBALS['portal'] = $s=="admin"?"admin":"public";        
        $set = self::loadables(NROOT.$s);
        foreach($set as $l) {
            require_once $l;
            $cls = $this->inst($l);
            foreach(($cls)::$hooks as $h) {
                @list($hp,$bp,$fn) = explode(">",$h); 
                if($url==$hp || $hp=="*") {
                    //var_dump($url);
                    if($bp) {
                        $page = new bbPage($bp);                        
                        if($this->pdata) $page->mergeData($this->pdata);
                        if($fn) $page->pfunc = function() use ($fn,$cls,$page) { return call_user_func([$cls,$fn],$page); };                        
                        $page->handle();
                        return "complete";
                    } else {                        
                        $in = new $cls;
                        $resp = $in->try($url);
                        if($resp=="complete") return "complete";
                    }
                } 
            }            
        }
    }
}

require_once RESOURCE_DIR."/icons.php";

require_once ROOT.'/vendor/phpmailer/src/Exception.php';
require_once ROOT.'/vendor/phpmailer/src/PHPMailer.php';
require_once ROOT.'/vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$classes = loader::loadables(NROOT."classes");
foreach ($classes as $c) {
    include $c;
}

chdir(ROOT);

$sett = (new option("optBunny", "storage"))->fetch("vals");
$bon = @$sett['enabled']=="Yes";
if($bon) {
    app::$storage = "bunny";
    app::$assetPath = @$sett["http_url"];   
    if(app::$assetPath[strlen(app::$assetPath)-1]!="/") app::$assetPath .= "/";
}

if(isset($argv[1])) {            
    $GLOBALS['theme'] = "vix";
    $GLOBALS['portal'] = "public";        
    switch($act = $argv[1]) {
        case "runtask":
            $rnr = new runner($argv[2], @json_decode($argv[3]));            
            break;  
        case "zaprunner":            
            unlink(SYS_CONTENT_DIR."/runner.json");            
            break;
        case "echo":
            var_dump($argv);
            break;
        case "urlfix":
            $vent = new video();
            $all = $vent->fetch("all");
            foreach($all as $a) {
                $video = $a['video_url'];
                if(strpos($video,MEM_CONTENT_DIR)===0) {
                    $a['video_url'] = substr($video,strlen(MEM_CONTENT_DIR)+1);                        
                    echo "Fixing url: $video -> $a[video_url]\n";                    
                    //$vent->action("assert",$a);                    
                }                    
            }     
            break;
        case "attrfix":
            $vent = new video();
            $all = $vent->fetch("all");
            foreach($all as $a) {
                $json = @json_decode($a['attributes'],true);
                if(empty(@$json['width'])) {
                    //$video = DOM.VDIR."serve?url=".urlencode($vent->meta($a,"orig"))."__.mp4";    
                    $a['attributes'] = json_encode(app::get_video_attributes($vent->meta($a,"hd")));
                    echo "Fixing attrs: $a[title]\n";
                    var_dump($a['attributes']);
                    $vent->action("assert",$a);
                    echo "OK\n";                     
                }                
            }                
            break;
        case "createdfix":
            $vent = new video(["where"=>"created is null"]);
            $all = $vent->fetch("all");
            foreach($all as $a) {
                $a['created'] = strtotime("+".$a['id']." days",strtotime("2021-01-01"));
                echo "Fixing created: $a[title]\n";                    
                $vent->action("assert",$a);
            }                
            break;
        case "tidy":
            $homes = scandir(MEM_CONTENT_DIR);
            foreach($homes as $h) {                                
                if($h[0]==".") continue; 

                if(!($tfiles = @scandir(MEM_CONTENT_DIR."/$h/temp")))                        continue;
                foreach($tfiles as $t) {                              
                    if($t[0]==".") continue; 

                    $delta = time() - filemtime(MEM_CONTENT_DIR."/$h/temp/$t");
                    if($delta > 4*24*3600) unlink(MEM_CONTENT_DIR."/$h/temp/$t");
                }                      
            }                
            break;
        case "map":
            include ROOT.'/handlers/sitemap.php';
            break;
        case "slidemov":
            app::slides($argv);                
            $video = $argv[2];                              
            $video2 = str_replace("/temp/","/",$video);
            rename($video, $video2);                
            break;
        case "slides":
            app::slides($argv);
            break;
        /*case "cloud-loop":
            self::loopBunny();
            break;
        case "ff-loop":
            self::loopFF();
            break;*/
        case "drop-check":
            app::dropImp(true);
            break;
        /*case "drop-loop":
            self::loopDrop();
            break;*/
        case "auto-message":
        case "mass-ann":                           
        case "mass-message":                           
        case "mass-sms":                           
            switch ($argv[2]) {
                case "all":
                    $mem = new member;
                    break;
                case "premium":
                    $mem = new member(["where"=>"urole='Premium'"]);
                    break;
                case "free":
                    $mem = new member(["where"=>"urole LIKE 'Guest'"]);
                    break;
                default:
                    $mem = new member(["where"=>"id=$argv[2]"]);
                    break;
            }
            if(!$mem) die("\nBad target");
            $sett = (new option("optMess","messaging"))->fetch("vals");
            if($act=="mass-message") {                    
                $tpl = new emTemplate;
                $trow = $tpl->fetch("id",$argv[3]);               
                if(!$trow) die("\nBad template");

                echo date('Y-m-d H:i:s')." Mass send start\n";
                $body = $trow['body'];
                $subject = $trow['email_subject'];                               

                $q = $mem->fetch("all");
                while($o = $q->fetch_assoc()) {      
                    if(empty($o['email']))                            continue;
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
                        $mail->addAddress($o['email']);
                      //  $mail->addAddress("simonnewt8@gmail.com");
                        //$mail->addAddress("judd@aquete.com");
                        //$mail->addReplyTo($gmailid, $gmailusername); // to set the reply to

                        // Setting the email content
                        $mail->IsHTML(true);
                        $mail->Subject = $subject;

                        $ass = new bbAsset();                                                
                        $ass->pdata = array_merge($o,$ass->pdata);

                        $mail->Body = $ass->render($body);

                        $mail->send();
                        echo "$o[email] sent OK\n";
                        // header("location:auth-login.php");                        
                    } catch (Exception $e) {
                        echo "$o[email] send fail!\n";
                    }
                    //break;
                }     
                echo date('Y-m-d H:i:s')." Mass send complete\n";
            } else if($act=="mass-sms") {
                $tpl = new smsBody;                    
                $body = $tpl->fetch("id",$argv[3])['body'];               

                $q = $mem->fetch("all");
                $sid = $sett['twilo_sid'];
                $token = $sett['twilo_token'];
                $client = new Twilio\Rest\Client($sid, $token);
                while($o = $q->fetch_assoc()) {                    
                    try {                            
                        if(empty($o['mobile'])) continue;

                        $message = $client->messages->create(
                          $o['mobile'], // Text this number
                          [
                            'from' => $sett['twilo_phone_number'], // From a valid Twilio number 213-577-2188 
                            'body' => $body
                          ]
                        );
                        if($message->sid) {
                            echo "$o[mobile] SMS sent OK\n";
                        } else {
                            echo "$o[mobile] SMS NOT SENT\n";
                        }

                    } catch (Twilio\Exceptions\RestException $e) {
                        echo "$o[mobile] SMS send fail!\n";
                    }
                    break; //SN_TODO REMOVE
                }     
                echo date('Y-m-d H:i:s')." SMS send complete\n";
            } else {
                //$tpl = new smsBody;                    
                //$body = $tpl->fetch("id",)['body'];                                   
                $q = $mem->fetch("all");
                $tgt = new announce;
                while($o = $q->fetch_assoc()) {                    
                    $tgt->action("assert",["msg_id"=>$argv[3],"target_id"=>$o['id']]);
                    echo "$o[username] Announce ADDED\n";
                }
            }
            break;
    } 
} else if(isset($argv)) {
    $rnr = new runner();
} else {    
    $ldr = new loader();
}

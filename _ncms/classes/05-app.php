<?php
//include "content/system/config.php";
//include "handlers/WebPushKeyManager.php";

/*if(DEV) {
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1); 
    error_reporting(DEV_ERRLVL);
}
include "content/system/icons.php";*/

function _lcode() {
    return "en-GB";
}

function _lang() {
    return "en";
}

function _l($key) {
    $bgkey = (strpos($key,"sub")===0 && $key[4]==" ")?substr($key,5):$key;
    //$bgkey = (strpos($key,"admin/")===0)?substr($bgkey,6):$bgkey;
    if(sizeof(app::$lang)==0) {
        $data = app::pageData();
        $f = fopen(RESOURCE_DIR."/lang-"._lang().".csv","r");
        while($l = fgetcsv($f)) {
            $lv = $l[1];
            foreach($data as $k=>$v) {
                if(!is_string($v)) continue;
                $lv = str_replace("{{{$k}}}", $v, $lv);
            }
            app::$lang[$l[0]] = $lv;
        }
        fclose($f);
    }    
    return isset(app::$lang[$key])?app::$lang[$key]:ucfirst($bgkey);
}

class app {      
    static $ffcmd_common = "nohup ffmpeg -err_detect ignore_err -hide_banner -progress - -nostats -y ";
    static $ctkn = "";
    static $storage = "local";
    static $assetPath = VDIR."content/usr/"; 
    static $lang = [];
    static $mainNav;
    static $adminNav = [                        "dashboard",
                                                "video queue",
                                                "seo", 
                                                "trailers|add trailer|all trailers",
                                                "videos|dropbox import|bulk upload|add video|add live stream|published videos|draft videos|live streams|tags|categories",
                                                "models|add model|all models",
                                                "content|content-settings|system pages|add page|all pages|add blog post|all posts",
                                                "appearance|general|themes|custom menu items",
                                                "messaging|mass email|mass sms|announcements|message-settings",
                                                "members|all members|banned members",
                                                //"marketing-partnerships|vendor 1|vendor 2",                                                
                                                "sales|catalog|transactions",
                                                "referrals|referral settings",//|stats|payouts|invoice",
                                                "billing|pricing|payments",
                                                "storage|bunny|dropbox",//|amazon|ftp|google|dropbox",
                                                "social|google settings|twitter settings",
                                                "system|system settings|running tasks|message log|email templates|admin users"];
    
    static function stats() {        
        $ret = [];
        
        $rat []= $p1 = (new member(["where"=>'urole=\'Free\'']))->count();
        $rat []= $p2 = ($p = (new member(["where"=>'urole=\'Premium\'']))->count())?$p:0;

        $ret['count1']['label'] = "Total members";
        $ret['count1']['value'] = (new member)->count();
        $ret['count2']['label'] = "Total subscribers";
        $ret['count2']['value'] = $p2;
        $ret['count3']['label'] = "Total free";
        $ret['count3']['value'] = $p1;
        $ret['count4']['label'] = "Total transactions";
        $ret['count4']['value'] = (new transaction)->count();        

        
        
        
        $ret['ratio1']['series'] = $rat;
        $ret['ratio1']['labels'] = ["free","premium"];
        
        $ret['perc1']['label'] = "Premium";
        $ret['perc1']['value'] = $p2==0?100:$p1/$p2*100;
        $ret['perc1']['s1'] = $p2;
        $ret['perc1']['s2'] = $p1;
        
        $ret['list1']['rows'] = (new member(["limit"=>10]))->fetch("array");
        $ret['list2']['rows'] = (new video(["limit"=>10]))->fetch("array");
        $ret['list3']['rows'] = (new transaction(["limit"=>10]))->fetch("array");
        
        //|Net Earnings| High Risk Subscribers | Medium Risk Subscribers | Chargebacks |Refunds
        
        $ret['ticker1'] = [['body'=>"No new notifications","sub"=>"Check here for the latest notifications and updates."],['body'=>"No new notifications","sub"=>"Check here for the latest notifications and updates."],['body'=>"No new notifications","sub"=>"Check here for the latest notifications and updates."]];

        return $ret;        
    }
    
    
    public static function dealWithHEIC($file) {
        $mimeType = mime_content_type($file);
        if($mimeType=="image/heif" || $mimeType=="image/heic") {
            try {                
                $image = new \Imagick();
                $image->readImage($file);
                $image->setImageFormat("jpeg");
                $image->setImageCompressionQuality(100);
                unlink($file);
                $image->writeImage($file);

                return "OK";
            }
            catch (\ImagickException $ex) {
                return $ex->getMesssage();
            }
        }

        return $mimeType;
    }    
    
    static function ffmpeg_info($video) {
        $command = 'timeout -k 10 -s SIGTERM 10 ffprobe ' . $video . ' 2>&1';
        //echo $command."\n\n";
        $output = shell_exec($command);
        //var_dump($output);
        $ret = [];
        //$regex_sizes = "/Video: ([^,]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; 
        $regex_sizes = "/Video: ([^\r\n]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/";
        if (preg_match($regex_sizes, $output, $regs)) {
            $codec = $regs [1] ? $regs [1] : null;
            $ret['width'] = $regs [3] ? $regs [3] : null;
            $ret['height'] = $regs [4] ? $regs [4] : null;
        }

        $regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
        if (preg_match($regex_duration, $output, $regs)) {
            $hours = $regs [1] ? $regs [1] : null;
            $mins = $regs [2] ? $regs [2] : null;
            $secs = $regs [3] ? $regs [3] : null;
            $ms = $regs [4] ? $regs [4] : null;
            $ret['duration'] = $hours*3600+$mins*60+$secs;
        }
        
        return $ret;
    }
    
    static function media_info($file) {                
        $out = null;
        $cfile = str_replace("\"", "\\\"", $file);
        if(strpos($cfile,"https://")===false) $out = shell_exec("timeout -k 10 -s SIGTERM 10 ".ROOT."/bin/mediainfo-20.09.glibc2.3-x86_64.AppImage --Output=JSON \"$cfile\"");        
        if(!$out) $out = shell_exec("mediainfo --Output=JSON \"$cfile\"");        
        //var_dump($out);
        if($out) {
            $ret = [];
            $res = json_decode($out,true);            
            if(!$res || !isset($res['media']['track'])) {             
                //if(DEV) var_dump($out);
                return;//$ret;//self::ffmpeg_info($file);
            }
            
            foreach($res['media']['track'] as $t) {
                if(isset($t['Duration'])) $ret['duration'] = $t['Duration'];                                        
                if($t['@type']=='Video') {                    
                    $ret['width'] = $t['Width'];
                    $ret['height'] = $t['Height'];                                        
                }                
            }           
            /*if(!isset($ret['duration'])) {
                return self::ffmpeg_info($file);
            }*/
            return $ret;
        } //else return self::ffmpeg_info($file);        
    }
    
    static function video_frame_count($video) {        
        $ret = shell_exec("timeout -k 5 -s SIGTERM 5 mediainfo --Inform='Video;%FrameCount%' \"$video\"");
        return strlen($ret)>1?substr($ret,0,-1):$ret;
    }

    static function get_video_attributes($video, $ffmpeg="ffmpeg") {        
        var_dump($video,app::$storage);
        //$info = self::media_info($video[0]!='/'?ROOT.$video:$video);        
        $fv = strpos($video,"/content")===0?ROOT.$video:$video; 
        $info = self::media_info($fv); 
        
        if($info && isset($info['duration'])) {
            return array('codec' => 'unk',
                'width' => $info['width'],
                'height' => $info['height'],
                'hours' => sprintf("%02d",$h = floor($info['duration']/3600)),
                'mins' => sprintf("%02d",$m = floor(($info['duration']-$h*3600)/60)),
                'secs' => sprintf("%02d",floor(($info['duration']-$h*3600-$m*60))),
                'ms' => '00'
                );        
        } else {
            return array('codec' => '',
                'width' => '',
                'height' => '',
                'hours' => '00',
                'mins' => '01',
                'secs' => '30',
                'ms' => '00'
                );       
        }
    }
    
    static function human_readable($s) {
        return ucwords(str_replace("-"," ",$s));
    }

    static function human_filesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
                    
    static function slides($argv,$rkey=null) {
        $smd = explode(".",explode("//",DOM)[1])[0];
        
        $ffmpeg = self::$ffcmd_common;        
        $video = $argv[2];                      
        if(!is_file($video)) $video = str_replace("/temp/","/",$video);            
        
        $va = explode("/",str_replace("/temp/","/",$video));        
        
        $name = $va[sizeof($va)-1];
        $home = $va[sizeof($va)-2];
      
        $hpath = MEM_CONTENT_DIR."/$home/slides";
        if(!is_dir($hpath)) mkdir($hpath);
        $tpath = MEM_CONTENT_DIR."/$home/temp";
        if(!is_dir($tpath)) mkdir($tpath);
        
        if($video_attributes = self::get_video_attributes($video)) {
            $du = $video_attributes['hours'] * 3600 +  $video_attributes['mins'] * 60 + $video_attributes['secs'];
        } else {
            $du = 30;
        }
        $fr = '30';
        if($du<180) $fr = '10';
        if($du>600) $fr = '60';
                
      
        $pat = "{$name}__%03d.jpg";
        $slp = $tpath."/$pat";
        $command = $ffmpeg . ' -threads '.SLIDE_THREADS.' -loglevel panic -hide_banner -nostats -i ' . $video . ' -vf fps=1/'.$fr.' '.$slp;
        echo $command."\n";
      
        if($rkey) {
            $ent = new video;        
            $a = $ent->fetch("inprocess",$home,$name);                
            $output = runner::rt_exec($rkey,"slides",$command,"ffmpeg","ffmpeg_progress");
        } else $output = shell_exec($command);
        echo $output;            
        $idx  = 1;
        while(is_file($tfile = sprintf($slp,$idx++))) {
            $pname = basename($tfile);
            $ppath = dirname($tfile);
            app::imageProcess($ppath,$pname);            
            unlink($tfile);
        }
    }
    
    static function clientIP () {
        return $_SERVER['REMOTE_ADDR'];
    }
    
    static function clientCountry() {
        if(!($s = @file_get_contents('http://ip2c.org/'.app::clientIP()))) return null;
        switch($s[0])
        {
          case '0':
            return null;
          case '1':
            $reply = explode(';',$s);
            //echo '<br>Two-letter: '.$reply[1];
            //echo '<br>Three-letter: '.$reply[2];
            //echo '<br>Full name: '.$reply[3];
            //break;
            return $reply[1];
          default:
            return null;
        }
    }
    
    static function log($msg,$channel="debug",$file="system") {
        if(!DEV && $channel=="debug") return;
        
        $f = fopen(SYS_CONTENT_DIR."/$file.log","a");
        $line = date("Y-m-d H:i:s")."[$channel]$msg\n";
        fwrite($f, $line);
        fclose($f);
    }
    
    static function random($seed = null, $len = 32) {
        if($seed) mt_srand($seed);
        
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $ret = "";
        $max = strlen($chars)-1;
        while(strlen($ret)<$len) {
            $ridx = $seed?mt_rand(0, $max):random_int(0, $max);
            $ret .= $chars[$ridx];
        }        
        if($seed) mt_srand();
        
        return $ret;
    }
    
    static function pageData() {        
        $the = new theme;
        $a = $the->fetch("id",1);
        $sett = (new option("optSYS","system"))->fetch("vals"); //SN_OPTIMISE
        $cst = (new option("optcns","appearance"))->fetch("vals"); //SN_OPTIMISE
        $ret = ["support_request_email"=>@$sett['support_request_email'],"report_content_email"=>@$sett['report_content_email'],"cst"=>$cst,"vdir"=>VDIR,"brand_name"=>BRAND_NAME,"domain"=>DOM,"domain_name"=>substr(DOM,8),"theme-class"=>@$a['light_mode']=="Yes"?"theme-light":"theme-dark","custom_css"=>@$a['custom_css']];
        if(self::memberUser()) {
            $ret['member_username'] = @$_SESSION['member_username'];
            $ret['member_email'] = @$_SESSION['member_email'];
            $ret['member_membership'] = @$_SESSION['member_membership'];
        }
        return $ret;
    }
    
    static function bunnyToken(string $path, string $zone_url, int $expires_seconds = 3600) {        
        $sett = (new option('optBunny', "storage"))->fetch("vals");
        $bon = @$sett['enabled']=="Yes";
                
        if($bon && !empty($security_key = @$sett['url_token_security_key'])) {
            $expires = (time() + $expires_seconds);
            $hash_base = $security_key . $path . $expires;
            $token = md5($hash_base, true);
            $token = base64_encode($token);
            $token = strtr($token, '+/', '-_');
            $token = str_replace('=', '', $token);
            return "{$zone_url}{$path}?token={$token}&expires={$expires}&cacheTkn=".app::$ctkn;
        } else {            
            return "{$zone_url}{$path}?cacheTkn=".app::$ctkn;
        }
    }
    
    static function secure_asset($file) {
            if(app::$storage=="local") return $file;
            $info = parse_url($file);             
            
            $ret = ($bunt = self::bunnyToken(@$info['path'], @$info['scheme']."://".@$info['host']))?$bunt:$file;                    
            
            return $ret;
    }
    
    static function http_file_exists($file,$auth = true) {     
        //$hsh = md5($file.date('i'));        
        //if(isset($_SESSION["exists_$hsh"])) return $_SESSION["exists_$hsh"];
        $exists = false; 
        //$auth = false;  
        if(strpos($file,DOM)===0) {
            $np = ROOT."/".substr($v,strlen(DOM.VDIR));
            $exists = is_file($np);
        } else {            
            $info = parse_url($file);
            
            if($auth) $file = ($bunt = self::bunnyToken(@$info['path'], @$info['scheme']."://".@$info['host']))?$bunt:$file;                    
            //$opts['http']['timeout'] = 2;
            //stream_context_set_default( $opts );
            //return @get_headers( $url );
            //$file_headers = get_headers($file,$false);
            //$exists = $file_headers && strpos($file_headers[0],'40')===false && strpos($file_headers[0],'50')===false;            
            //$exists = false;
            //var_dump($file);
            //$fp = fopen($file, "r");
            //$exists = true;
            $ch = curl_init($file);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $exists = $retcode < 400;// -> not found, $retcode = 200, found.
            curl_close($ch);
            //var_dump($retcode,$file);
            //$exists = true;
        }

        //if($exists) $_SESSION["exists_$hsh"] = $file;
        return $exists?$file:false;
    }
    
    static function check() {
        if(!defined("ROOT")) die("");
    }
    
    static function slug($s,$d="_") {
        $s = strtolower($s);
        $s = str_replace(["\n","\r","\t"],"",$s); 
        $ret = "";
        $allowed = ["_","a-z",".","0-9",$d];
        for($idx=0;$idx<strlen($s);$idx++) {
            $c = $s[$idx];
            $pass = false;
            foreach ($allowed as $v) {
                if(strlen($v)===1) {
                    if($v==$c) {
                        $pass=true;
                        break;
                    }
                } else {
                    list($st,$en) = explode("-",$v);
                    if($c>=$st && $c<=$en) {
                        $pass = true;
                        break;
                    }
                }
            }
            $ret .= $pass?$c:(strlen($ret)==0 || $ret[strlen($ret)-1]!=$d?$d:"");
        }
                
        return $ret;
    }

    public static function getWebPushPublicKey(): string
    {
        $keysFileName = ROOT . '/content/system/web-push.json';

        $keys = json_decode(file_get_contents($keysFileName), true);

        return $keys['publicKey'];
    }
    
    static function asset($path,$abs = false) {
        $dom = $abs?"//".$_SERVER['HTTP_HOST']:"";
        if($path[0]=="/") $path = substr($path,1);
        $pa = explode(".",$path);                
        if(sizeof($pa)==1) {            
            return $dom.VDIR.str_replace(" ", "-", $path);
        }
        $path=DEV?$path."?_rnd=".mt_rand():$path;
        switch($pa[sizeof($pa)-1]) {
            case 'css':
                return "<link href='".$dom.VDIR."$path' rel='stylesheet'>";
                break;
            case 'js':
                return "<script src='".$dom.VDIR."$path'></script>";
                break;            
        }
    }
     static function imageProcess($fp,$src) {             
        // Begin
        $img = new img;
        $img->set_img($fp . "/" . $src);
        $img->set_quality(80);

        $src = str_replace("working_", "", $src);
        $src = str_replace("orig_", "", $src);
        $src = str_replace("__.mp4", "", $src);
        
        // Small thumbnail
        $img->set_size(400);
        $img->save_img($fp . "/small_" . $src);
    
        // Med thumbnail
        $img->set_size(800);
        $img->save_img($fp . "/med_" . $src);

        // large thumbnail
        $img->set_size(1600);
        $img->save_img($fp . "/large_" . $src);

        // Finalize
        $img->clear_cache();    
    }
    
    
    static function memberLogin($id,$role) {
        $_SESSION['memLogin'] = $id;
        $_SESSION['memRole'] = $role;
        $home = hash('sha256',"1973265t32$id");            
        $_SESSION['homeDir'] = $home;
        if(!is_dir(MEM_CONTENT_DIR."/$home")) @mkdir(MEM_CONTENT_DIR."/$home");
    }
    
    static function homeDir() {
        return @$_SESSION['homeDir'];
    }
    
    static function memberUser() {
        return @$_SESSION['memLogin'];
    }
    
    static function memberRole() {
        $ment = new member;
        if($a = $ment->fetch("id",@$_SESSION['memLogin'])) {
            $_SESSION['memRole'] = $a['urole'];
        }
        return @$_SESSION['memRole'];
    }
    
    static function adminLogin($id,$role="admin") {
        $_SESSION['adminLogin'] = $id;
        $_SESSION['adminRole'] = $role;
        $home = hash('sha256',"19sgh635t32$id");            
        $_SESSION['homeDir'] = $home;
        if(!is_dir(MEM_CONTENT_DIR."/$home")) @mkdir(MEM_CONTENT_DIR."/$home");
    }
    
    static function adminUser() {
        return @$_SESSION['adminLogin'];
    }
    
    static function adminRole() {
        return @$_SESSION['adminRole'];
    }
    
    static function currentUrl($rurl=null) {
        $url = substr($rurl??$_SERVER['REQUEST_URI'],strlen(VDIR)-1);         
        return ($idx=strpos($url,'?'))?substr($url,0,$idx):$url;
    }
    
    static function urlTail($rurl = null) {
        $url = substr($rurl??$_SERVER['REQUEST_URI'],strlen(VDIR)-1);         
        $url = ($idx=strpos($url,'?'))?substr($url,0,$idx):$url;
        $ua = explode("/",$url);
        return $ua[sizeof($ua)-1];
    }
    
    static function redirect($loc,$abs=false) {
        if($abs) {
            header("Location: ".$loc);        
        } else {
            header("Location: ".VDIR.substr($loc,1));        
        }
        exit();
    }
    
     static function post($sel = null) {
        if(sizeof($_POST)==0) return null;        
        if(is_array($sel)) {
            $ret = [];
            foreach($sel as $s) {
                $ret[$s] = $_POST[$s];
            }
            return $ret;
        } elseif($sel == "?") {
            $ret = [];
            foreach ($_POST as $k=>$v) {
                if($k[0]=="_" || strpos($k,"uploader")!==false) continue;
                
                $ret[$k]=$v;
            }
            return $ret;
        } else {
            return $sel?@$_POST[$sel]:$_POST;
        }
    }
    
    static function request($sel = null,$toslug = true) {
        if(sizeof($_REQUEST)==0) return null;        
        $ret = $sel?@$_REQUEST[$sel]:$_REQUEST;        
        return ($ret && $sel && $toslug)?app::slug($ret,"-"):$ret;
    }
    
    static function newTkn() {
        $len = 15;        
        $chars = "0123456789ABDEFGHIJKMLNOPQRSTUVWXYZ";
        $ret = "";
        $max = strlen($chars)-1;
        while(strlen($ret)<$len) {
            $ridx = random_int(0, $max);
            $ret .= $chars[$ridx];
        }        
                
        return $ret;
    }
    
    static function cQt() {
        return "cacheTkn=".self::$ctkn;
    }
}


if(!app::$ctkn=@file_get_contents(SYS_CONTENT_DIR.'/asset-cache-tag.txt')){
    app::$ctkn=app::newTkn();
    file_put_contents(SYS_CONTENT_DIR.'/asset-cache-tag.txt', app::$ctkn);
}
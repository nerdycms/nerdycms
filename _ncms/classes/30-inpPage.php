<?php
app::check();

require_once ROOT."/vendor/chunku/autoload.php";

class inpPage extends page {
    var $group;
    var $def;
    var $ent;

    function __construct($name,$group,$def,$ent = null,$pfunc=null) {
        parent::__construct($name,$pfunc);
        $this->group = $group;
        $this->def = $def;
        $this->ent = $ent;
    }

    function group() {
        return $this->label($this->group);
    }

    function inpID($key) {
        return str_replace(["-"," "],"_",$key);
    }

    function inpW($grp,$key) {
        if($grp->style=="header") {
            return isset($grp->layouts->$key)?$grp->layouts->$key:$grp->layouts->_default;
        } else {
            return isset($grp->layouts->$key)?"col-md-".$grp->layouts->$key:"col-md-".$grp->layouts->_default;
        }
    }

    function inpType($frm,$key) {
        $ret = isset($frm->types->$key)?$frm->types->$key:$frm->types->_default;
        return explode('|',$ret)[0];
    }

    function inpContent($frm,$values,$key) {
        $ret = isset($frm->types->$key)?$frm->types->$key:$frm->types->_default;
        $arr = explode('|',$ret);
        array_shift($arr);
        $isKeyed = false;
        if($arr[0]=="\$nav") {
            $arr = [];
            foreach (app::$adminNav as $value) {
                $ia = explode('|',$value);
                foreach($ia as $aa) $arr []= sizeof($ia)>1 && $ia[0]!=$aa?$ia[0]."->".$aa:$aa;
            }
        } else if($arr[0][0]=="$") {
            $en = substr($arr[0], 1);
            $ent = new $en;
            $opt = $ent->fetch("options");
            $arr = [];
            if(is_array(@$opt[0])) {
                $isKeyed = true;
//                foreach($opt as $p) {
                //                  $arr []= $p;
                //            }
                $arr = $opt;
            } else foreach($opt as $p) {
                $arr []= $p;
            }
        }
        $val = $this->inpValue($frm, $values, $key);
        if(!$isKeyed) {
            foreach(explode(",",$val) as $p) {
                if(!in_array($p,$arr)&&$p!="") $arr []= $p;
            }
            $ret = "<option>".implode("</option><option>", $arr)."</option>";
        } else {
            $ret = "";
            foreach($arr as $a) { //SN_OMG!!
                if($val && $val==$a[0]) {
                    $ret .= "<option selected value='$a[0]'>$a[1]</option>";
                } else {
                    $ret .= "<option value='$a[0]'>$a[1]</option>";
                }
            }
        }                                        ;

        if(!$isKeyed && $val!="") {
            if(!is_numeric($val) && $json = @json_decode($val)) {
                foreach ($json as $je) {
                    $ret = str_replace("<option>$je->value","<option selected>$je->value",$ret);
                }
            } else {
                foreach(explode(",",$val) as $p) {                    
                    $ret = str_replace("<option>$p<","<option selected>$p<",$ret);
                }
            }
        }
        return $ret;
    }

    function label($key) {
        switch($key) {
            case "cancel":
                $frm = $this->form();
                if(@$frm->cancelLabel) return _l($frm->cancelLabel);
                else return null;
            case "submit":                
                if(@$frm->submitLabel && $key=="submit") return _l($frm->submitLabel);                
                break;
            case "aquete_code":
                return "Price point";
        }
        return _l(str_replace(["-","_"]," ",$key));
    }

    function form($key=null) {
        return json_decode(file_get_contents(RESOURCE_DIR."/$this->def.json"));
    }

    function inpValue($frm,$values,$key) {
        $def = app::request("_default$$key",false)??"";
        if(!$values) return $def;

        switch($this->inpType($frm, $key)) {
            case "edit":
            case "tags":
                return @$values[$key]??$def;
            case "check":
                return @$values[$key]=="Yes"||@$values[$key]=="on"?"checked":"";
            case "date":
                if(empty($values[$key])) return $def;
                $va = explode("/",$values[$key]);
                $va[0] = strlen($va[0])==1?"0".$va[0]:$va[0];
                $va[1] = strlen($va[1])==1?"0".$va[1]:$va[1];
                return $va[2]."-".$va[0]."-".$va[1];
            default:
                return @$values[$key]?htmlentities($values[$key]):htmlentities($def);
        }
    }

    function handle() {
        $enablePush = false;
        $siteName  = $_SERVER['HTTP_HOST'];
        $seo = (new option("optSEO","seo-group"))->fetch("vals");
        $notifications = (new option("optMess","messaging"))->fetch("vals");
        if (!empty($notifications['enable_push'])) {
            $enablePush = $notifications['enable_push'] === 'Yes';
        }
        if (!empty($seo['site_name'])) {
            $siteName = $seo['site_name'];
        }

        if(app::request("remove")) {
            $this->ent->delete(app::request("_id"));
            app::redirect(app::currentUrl());
            exit();
        }
        $this->pdata['upl_pre'] = app::homeDir()."/";
        if(app::post("chunk")!==null) {

            //$_POST['name'] = app::random().".mp4";
            $path = MEM_CONTENT_DIR."/".app::homeDir()."/".app::post("name");
            if(is_file($path) && app::post('chunk')==0) unlink($path);
            try {
                $uploadManager=new \UploadManager\Upload("media_".app::request("_key"));

                //add validations
                $uploadManager->addValidations([
                    new \UploadManager\Validations\Size('50000M'), //maximum file size must be 2M
                    //new \UploadManager\Validations\Extension(['jpg','jpeg','png','gif']),
                ]);

                //add callback : remove uploaded chunks on error
                /*  $uploadManager->afterValidate(function($chunk){
                                      $address=($chunk->getSavePath().$chunk->getNameWithExtension());
                                      if($chunk->hasError() && file_exists($address)){
                                              //remove current chunk on error
                                              @unlink($address);
                                      }
                  });*/


                if(app::post('chunk')==0) {
                    $dir = MEM_CONTENT_DIR.'/'.app::homeDir()."/temp";
                    if(!is_dir($dir)) {
                        mkdir($dir);
                        chmod($dir,0777);
                    }
                    if(app::request("_key")=="video_url") $_SESSION['upload'] = $dir."/".app::post("name");
                    else $_SESSION['trail'] = $dir."/".app::post("name");
                }

                $chunks=$uploadManager->upload(MEM_CONTENT_DIR.'/'.app::homeDir()."/temp",app::post("name"));

                /*if(app::post('chunk')==app::post("chunks")-1) {
                    $dir = CONTENT_DIR.'/uploads/'.app::homeDir();
                    rename($_SESSION['upload'],$dir."/".app::post("name"));
                    $_SESSION['upload'] = $dir."/".app::post("name");
                }*/

                // Return Success JSON-RPC response
                echo ('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

            } catch (\UploadManager\Exceptions\Upload $exception){
                //send bad request error
                header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request',true,'400');
                echo ('{"jsonrpc" : "2.0", "error" : {"code": 400, "message": "'.$exception->getMessage().'"}, "id" : "id"}');
            }
            usleep(100000);
            exit();
        }

        if($act = app::post("_action")) {
            switch($act) {
                case "gen-slides":
                    $ua = explode(".",$file = app::post("file"));
                    $ext = $ua[sizeof($ua)-1];
                    if(sizeof($ua)>1) {
                        $file = app::post("file");
                        $dir = MEM_CONTENT_DIR."/".app::homeDir();
                        $fa = explode("/",$file);
                        $nm = $fa[sizeof($fa)-1];
                        $home = $fa[sizeof($fa)-2];
                        /*if(strpos($file,".h-s-h.")!==false) {
                            $nm = $file;
                            $np = $dir."/".$nm;
                            $np = MEM_CONTENT_DIR."/$home/$nm.__.mp4";
                        } else {
                            $nm = hash('sha256',"hdtheuh".$file).".h-s-h.$ext";
                            $np = MEM_CONTENT_DIR."/$home/temp/$nm";
                        }

                        if(!is_file($np)) {
                            $np = $dir."/".$file;
                        }*/

                        $np = MEM_CONTENT_DIR."/$home/temp/$nm"; 

                        $t = new task("slides","/usr/bin/php ".ROOT."/index.php slides $np");
                        $t->run();

                        echo "OK";
                    }
                    exit();
                    break;
                case "upd-slides":                    
                    $path = VDIR."content/usr/";
                    $match = [];
                    $file = app::post("file");
                    $fa = explode("/",$file);
                    if(sizeof($fa)<2) exit();

                    $name = $fa[sizeof($fa)-1];
                    $home = $fa[sizeof($fa)-2];



                    /*if(strpos($name,".h-s-h.")===false) {
                        $ext = pathinfo($name,PATHINFO_EXTENSION);
                        $name = hash('sha256',"hdtheuh".$name).".h-s-h.$ext";
                    }*/

                    /*if($slides = @scandir(MEM_CONTENT_DIR."/$home/temp/")) {
                        foreach($slides as $s) {
                            if($s[0]=="." || strpos($s,".mp4")===(strlen($s)-4)) continue;
                            //var_dump($s,$name);
                            if(strpos($s, $name)===0) {
                                $match []= $s;
                                //  echo $s;
                            }
                        }
                    }*/
                    
                    if($slides = @scandir(MEM_CONTENT_DIR."/$home/slides/")) {
                        foreach($slides as $s) {
                            if($s[0]=="." || strpos($s,".mp4")===(strlen($s)-4)) continue;
                            //var_dump($s,$name);
                            if(strpos($s, $name)===0 && !in_array($s,$match)) {
                                $match []= $s;
                                //  echo $s;
                            }
                        }
                    }
                    
                    //var_dump($match);
                    $bun = false;
                    if(sizeof($match)==0) {
                        $sett = (new option("optBunny", "storage"))->fetch("vals");
                        $hru = @$sett['http_url'];
                        $nma = explode("/",$file);
                        $nm =  $nma[1];//explode(".",$nma[1])[0];

                        /*   if(strpos($nm,".h-s-h.")===false) {
                               $ext = pathinfo($nm,PATHINFO_EXTENSION);
                               $nm = hash('sha256',"hdtheuh".$nm).".h-s-h.$ext";
                           }*/
                        //var_dump($sett);exit();
                        
                        for($idx=1;$idx<60;$idx++) {
                            if(!empty($hru) && ($burl = app::http_file_exists($hru."/slide_med_".$nm."__".sprintf("%03d",$idx).".jpg"))) {
                                //$match []= app::homeDir()."/".$nm."__".sprintf("%03d",$idx).".jpg";
                                //$iv = VDIR."serve?url=".urlencode(app::homeDir()."/".$nm."__".sprintf("%03d",$idx).".jpg");
				$iv = "$home/slides/med_".$nm."__".sprintf("%03d",$idx).".jpg";
                                $match []= [$iv,$burl];
                                //echo "<img data-value='$iv' src='$burl'>";
                            } else if(file_exists($pq = MEM_CONTENT_DIR."/$nma[0]/slides/med_".$nm."__".sprintf("%03d",$idx).".jpg")) {
                                $iv = "$home/slides/med_".$nm."__".sprintf("%03d",$idx).".jpg";
                                $match []= [$iv,"{$path}/$iv"];
                                //echo "<img data-value='$iv' src=''>";
                            } else {
                                //echo "<span>$pq</span>";
                                break;
                            }
                        }
                    }

                    foreach($match as $m) {
                        if(is_array($m)) {
                            echo "<img data-value='$m[0]' src='$m[1]'>";
                        } else {                        
                            echo "<img data-value='$home/slides/$m' src='{$path}$home/slides/$m'>";
                        }
                    }
                    if($match && ($sz = sizeof($match))>1) {                        
                        $m = $match[1];
                        if(is_array($m)) {
                            echo ":::if($('#poster_url').val()=='') { $('#poster_url').val('$m[0]');$('#preview').attr('src','$m[1]'); }";
                        } else echo ":::if($('#poster_url').val()=='') { $('#poster_url').val('$home/slides/$m');$('#preview').attr('src','{$path}$home/slides/$m'); }";
                    }
                    exit();
                    break;
            }
        } else if($this->ent && (app::post('?')||sizeof($_FILES)>0)) {
            //var_dump(app::post("?"));exit();

            $form = $this->form(app::adminRole());
            foreach($form->types as $k=>$v) {
                if($v=="check") {
                    $_POST[$k] = @$_POST[$k]=="on"?"Yes":"No";
                } else if($v=="edit") {
                    if(!empty(@$_POST['_raw_'.$k])) $_POST[$k] = $_POST['_raw_'.$k];
                }
            }
            switch(get_class($this->ent)) {                
                case "option":
                    switch($this->ent->key) {
                        /*case "optSYS":
                            var_dump($_POST);
                            //$_POST['maintenance_mode'] = $_POST['maintenance_mode']?"Yes":"No";
                            break;*/
                        case "optcns":
                        case "optgap":
                            foreach($_FILES as $k=>$v) {
                                $ext = pathinfo($_FILES[$k]['name'],PATHINFO_EXTENSION);
                                if(!in_array($ext, ["jpg","png","ico"])) continue;
                                $src = $_FILES[$k]['tmp_name'];
                                $k = app::slug($k,"_");
                                $dst = COM_CONTENT_DIR."/$k.$ext";
                                rename($src, $dst);
                                chmod($dst,0777);
                            }
                            break;
                    }
                    break;
                case "pricePoint":
                    if(empty($_POST['code'])) $_POST['code'] = hash("sha1","jihosdhohodf".random_int(0,PHP_INT_MAX-1));
                    break;
                case "blog":
                    $_POST['updated'] = date('Y-m-d H:i:s');

                    if(isset($_FILES['featured_image']['tmp_name']) && $_FILES['featured_image']['tmp_name']!="") {
                        $src = $_FILES['featured_image']['tmp_name'];
                        $dst = MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$_FILES['featured_image']['name'];
                        rename($src, $dst);
                        chmod($dst, 0777);
                        app::imageProcess(MEM_CONTENT_DIR."/".app::homeDir(), "orig_".$_FILES['featured_image']['name']);

                        $_POST['featured_image'] = app::homeDir()."/".$_FILES['featured_image']['name'];
                    }

                    if (!empty($_POST['title']) && $enablePush) {
                        $pushNotificationText = "Hi, {$siteName} has added new post, {$_POST['title']}. Watch now!";
                        WebPushService::sendAll('New post added', $pushNotificationText);
                    }

                    break;
                case "model":
                    if(isset($_FILES['biopic_url']['tmp_name']) && $_FILES['biopic_url']['tmp_name']!="") {
                        $src = $_FILES['biopic_url']['tmp_name'];
                        $dst = MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$_FILES['biopic_url']['name'];
                        rename($src, $dst);
                        chmod($dst, 0777);
                        app::imageProcess(MEM_CONTENT_DIR."/".app::homeDir(), "orig_".$_FILES['biopic_url']['name']);
                        unlink(MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$_FILES['biopic_url']['name']);
                        $_POST['biopic_url'] = app::homeDir()."/".$_FILES['biopic_url']['name'];
                    }
                    if(isset($_FILES['banner_url']['tmp_name']) && $_FILES['banner_url']['tmp_name']!="") {
                        $src = $_FILES['banner_url']['tmp_name'];
                        $dst = MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$_FILES['banner_url']['name'];
                        rename($src, $dst);
                        chmod($dst, 0777);
                        app::imageProcess(MEM_CONTENT_DIR."/".app::homeDir(), "orig_".$_FILES['banner_url']['name']);
                        unlink(MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$_FILES['banner_url']['name']);
                        $_POST['banner_url'] = app::homeDir()."/".$_FILES['banner_url']['name'];
                    }

                    if (!empty($_POST['model_name']) && $enablePush) {
                        $pushNotificationText = "Hi, {$siteName} has added a new model, {$_POST['model_name']} View Now!";
                        WebPushService::sendAll('New model added', $pushNotificationText);
                    }

                    break;
                case "trailer":
                case "video":
                    if(isset($_FILES['gal'])) {
                        $ga = @json_decode(@$this->ent->fetch("id",app::request("_id"))['image_gallery'],true);
                        if(!$ga) $ga = [];
                        $f = $_FILES['gal'];
                        
                        for($fi=0;$fi<8;$fi++) {
                            if(empty(@$f['tmp_name'][$fi]))                                continue;
                            $src = $f['tmp_name'][$fi];
                            $f['name'][$fi] = md5(rand().$f['name'][$fi]).".".pathinfo($f['name'][$fi],PATHINFO_EXTENSION);
                            $dst = MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$f['name'][$fi];
                            rename($src, $dst);
                            chmod($dst, 0777);
                            app::imageProcess(MEM_CONTENT_DIR."/".app::homeDir(), "orig_".$f['name'][$fi]);
                            unlink(MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$f['name'][$fi]);
                            $ga[$fi] = app::homeDir()."/med_".$f['name'][$fi];
                        }
                       // var_dump(
                        $_POST['image_gallery'] = json_encode($ga);
                     //   );
                    }

                    if(isset($_POST['seo_url']) && empty($_POST['seo_url'])) $_POST['seo_url'] = app::slug($_POST['title'], "-");
                    else if(isset($_POST['seo_url'])) $_POST['seo_url'] = app::slug($_POST['seo_url'], "-");

                    if (!empty($_POST['title']) && !empty($_POST['models']) && $enablePush) {
                        $pushNotificationText = "Hi, {$siteName} has uploaded a new video, {$_POST['title']} staring {$_POST['models']}. Watch now!";
                        WebPushService::sendAll('New video added', $pushNotificationText);
                    }

                    if(isset($_POST['seo_url'])) $_POST['seo_url'] = app::slug($_POST['seo_url'], "-");
                    $vid = MEM_CONTENT_DIR.@$_POST['video_url'];

                    /*if (file_exists($vid) && $this->ent->key == "video") {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime_type = finfo_file($finfo, $vid);
                        finfo_close($finfo);*/
                        //if (preg_match('/video\/*/', $mime_type)) {
                            /*$_POST['attributes'] = app::get_video_attributes($vid);
                        }
                    }*/

                    if(isset($_FILES['poster_url']['tmp_name']) && $_FILES['poster_url']['tmp_name']!="") {
                        $src = $_FILES['poster_url']['tmp_name'];
                        $newname = md5(rand().$_FILES['poster_url']['name']).".".pathinfo($_FILES['poster_url']['name'],PATHINFO_EXTENSION);
                        $dst = MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$newname;
                        rename($src, $dst);
                        chmod($dst, 0777);
                        app::imageProcess(MEM_CONTENT_DIR."/".app::homeDir(), "orig_".$newname);
                        unlink(MEM_CONTENT_DIR."/".app::homeDir()."/orig_".$newname);
                        $_POST['poster_url'] = app::homeDir()."/".$newname;
                    }

                    if(($uf=@$_SESSION['upload']) && is_file($uf)) {
                        //$ua = explode(".",$_SESSION['upload']);
                        //$ext = $ua[sizeof($ua)-1];
                        //if(sizeof($ua)>1) {
                        //  $dir = MEM_CONTENT_DIR.'/'.app::homeDir();
                        //$nm = hash('sha256',"hdtheuh".$_SESSION['upload']).".h-s-h.$ext";
                        $nm = basename($_SESSION['upload']);                        
                        //$hm = $_SESSION['upload'];
                        //$np = $dir."/".$nm;
                        $np = str_replace("/temp/", "/", $_SESSION['upload']);
                        rename($_SESSION['upload'],$np);
                        unset($_SESSION['upload']);
                        $_POST['video_url'] = app::homeDir()."/".$nm;
                        if(empty($_POST['poster_url'])) $_POST['poster_url'] = app::homeDir()."/slides/med_".$nm."__002.jpg";
                        unset($_SESSION['upload']);
                        //  }
                    }
                    if(@$_SESSION['trail'] && is_file(@$_SESSION['trail'])) {
                        //$ua = explode(".",$_SESSION['upload']);
                        //$ext = $ua[sizeof($ua)-1];
                        //if(sizeof($ua)>1) {
                        //  $dir = MEM_CONTENT_DIR.'/'.app::homeDir();
                        //$nm = hash('sha256',"hdtheuh".$_SESSION['upload']).".h-s-h.$ext";
                        $nm = basename($_SESSION['trail']);
                        //$newname = md5(rand().$_SESSION['trail']).".".pathinfo($_SESSION['trail'],PATHINFO_EXTENSION);
                        //$hm = $_SESSION['upload'];
                        //$np = $dir."/".$nm;
                        $np = str_replace("/temp/", "/trailer_", $_SESSION['trail']);
                        rename($_SESSION['trail'],$np);
                        unset($_SESSION['trail']);
                        $_POST['trailer_url'] = app::homeDir()."/".$nm;
                        unset($_SESSION['trail']);
                        //  }
                    }
                    foreach ($_POST as $k=>$v) {
                        if(strpos($k,"o_")===0 || strpos($k,"_o_")!==false) unset($_POST[$k]);
                    }
                    
                    if($id = app::request("_id")) $oldv = $this->ent->fetch("id",$id);                                                                
                    break;
            }
            
            $this->ent->action("assert");
            if(isset($oldv)) {
                $newv = $this->ent->fetch("id",$id);
                $tsett = (new option("optLTWIT", "social-login"))->fetch("vals");                
                if($tsett['auto_post_enabled']=='Yes' && $oldv['publish_status']!="Published" && $newv['publish_status']=="Published") {                                        
                    $url = DOM.$this->ent->meta($newv,'player_url');
                    $tags = explode(',',str_replace(" ","_",$newv['tags']));
                    $tags = implode(' #',$tags);
                    if(!empty($tags)) $tags="#$tags";
                    $text = "from ".DOM." $newv[title] [$url] $tags";
                    app::redirect("/admin/post-to-twitter?_video=$id&_default\$post_body=". urlencode($text));                    
                }
            }
        }

        parent::handle();
    }
}

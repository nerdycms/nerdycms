<?php

// Author: Simon Newton

require_once ROOT."/vendor/chunku/autoload.php";

class bulk extends handler {
    static $hooks = [ "admin/bulk-upload" ];
    
    function try($hook) {
        $page = new page("bulk-imp",function () {
        
        if(app::request("_action")=="refresh") {
            $html = "";
            $files = scandir(BULK_UPLOAD_DIR);
            foreach($files as $f) {
                if($f[0]==".") continue;
                $html .= "<div class='ftp-item'>$f</div>";
            }
            echo $html;
            exit();
        }
        if(app::request("_action")=="go") {
            $files = scandir(BULK_UPLOAD_DIR);
            foreach($files as $f) {
                if($f[0]==".") continue;         
                if(in_array(strtolower(pathinfo($f,PATHINFO_EXTENSION)),["png","jpeg","jpg","gif","bmp","webp"])) continue;                
                $mime = mime_content_type(BULK_UPLOAD_DIR."/$f");
                if(strpos($mime,"video/")!==0 && $mime!="application/octet-stream") continue;

                $nn = md5($f.time()).".".pathinfo($f,PATHINFO_EXTENSION);                        
                //$np = MEM_CONTENT_DIR.'/'.app::homeDir()."/temp/".$nn;      
                $path = app::homeDir()."/".$nn;      
                rename(BULK_UPLOAD_DIR."/$f",MEM_CONTENT_DIR.'/'.$path);

//                $attr = app::get_video_attributes(MEM_CONTENT_DIR.'/'.$path);
  //              $t = new task("slides","/usr/bin/php ".ROOT."/index.php slidemov $np");
    //            $t->run();

                $vent = new video();
                $title = ucwords(app::slug(str_replace("_","!",pathinfo($f,PATHINFO_FILENAME))," "));
                $seo_url = app::slug(str_replace("_","!",pathinfo($f,PATHINFO_FILENAME)),"-");
                $arr = ["seo_url"=>$seo_url,"title"=>$title,"publish_status"=>"Draft","video_url"=>$path,"poster_url"=>app::homeDir()."/slides/med_".$nn."__002.jpg" ];
                
          //      if(@$attr['width']>0) $arr['attributes'] = json_encode($attr);
                
                app::log(json_encode($arr),"debug","bulk");
                $res = $vent->action("assert",$arr);
                app::log("result:".json_encode($res),"debug","bulk");                        
            }
        }
        if(app::post("chunk")!==null) {              
            //$_POST['name'] = app::random().".mp4";                    
            $path = MEM_CONTENT_DIR."/".app::homeDir()."/".app::post("name");
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
                }                

                $chunks=$uploadManager->upload(MEM_CONTENT_DIR.'/'.app::homeDir()."/temp",app::post("name"));

                /*if(app::post('chunk')==app::post("chunks")-1) {
                    $dir = CONTENT_DIR.'/uploads/'.app::homeDir();
                    rename($_SESSION['upload'],$dir."/".app::post("name"));
                    $_SESSION['upload'] = $dir."/".app::post("name");
                }*/


              //  app::log(json_encode(app::post()),"debug","bulk");

                            // Return Success JSON-RPC response
                echo ('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

            } catch (\UploadManager\Exceptions\Upload $exception){
                //send bad request error
                header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request',true,'400');
                        echo ('{"jsonrpc" : "2.0", "error" : {"code": 400, "message": "'.$exception->getMessage().'"}, "id" : "id"}');
            }
            usleep(100000);
            if(app::post('chunk')==app::post("chunks")-1) {
                $np = MEM_CONTENT_DIR.'/'.app::homeDir()."/temp/".app::post("name");
//                $attr = json_encode(app::get_video_attributes($np));
                $t = new task("slides","/usr/bin/php ".ROOT."/index.php slidemov $np");
                $t->run();

                $vent = new video();
                $title = ucwords(app::slug(pathinfo(app::post("oname"),PATHINFO_FILENAME)," "));
                $arr = ["title"=>$title,"publish_status"=>"Draft","video_url"=>$path,"poster_url"=>app::homeDir()."/slides/med_".app::post("name")."__002.jpg" ];

                app::log(json_encode($arr),"debug","bulk");
                $res = $vent->action("assert",$arr);
                app::log(json_encode($res),"debug","bulk");                        
            }
            exit();
        }                
    });
    $page->handle();
    return "complete";
    }
}
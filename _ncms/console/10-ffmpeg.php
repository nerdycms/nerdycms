<?php

// Author: Simon Newton

define('LOG_FILE', '/root/error.log');

class ffmpeg  {        
    function schedule() {
        $smd = explode(".",explode("//",DOM)[1])[0];
        
        $cntset = (new option("optcns","appearance"))->fetch("vals");        
        if(@$cntset['enable_video_overlay']=="on" && is_file(COM_CONTENT_DIR."/video_overlay_file.png")) $hasovf = true;
        else $hasovf = false;
        
        $homes = scandir(MEM_CONTENT_DIR);
        foreach($homes as $h) {                                
            if($h[0]==".") continue; 

            if(is_dir(MEM_CONTENT_DIR."/$h")) {                
                $files = scandir(MEM_CONTENT_DIR."/$h");
                foreach ($files as $f) {
                    if($f[0]=="." || strpos($f,"working_")===0 || strpos($f,"orig_")===0 || strpos($f,"small_")===0|| strpos($f,"med_")===0|| strpos($f,"large_")===0|| strpos($f,"standard_")===0 || strpos($f,"temp_")===0 || $f=="temp" || $f=="slides") continue;
                    if(in_array(strtolower(pathinfo($f,PATHINFO_EXTENSION)),["png","jpeg","jpg","gif","bmp","webp"])) continue;
                    $video = MEM_CONTENT_DIR."/$h/$f";
                    $mime = mime_content_type($video);
                    if(strpos($mime,"video/")===0 || $mime=="application/octet-stream") {                        
                        if($mkey = runner::tailjob(get_class(),[$video,$h,$f])) {                            
                            $ent = new video;        
                            $a = $ent->fetch("inprocess",$h,$f,true);
                            $ty = strpos($f,"trailer_")===0?"trailer":"video";             
                            
                            $pkey = $a?$ent->meta($a,"process-key"):$f;
                            
                            $tags = [];
                            $titles = [];
                            if($hasovf) {
                                $titles []= "Initial standardise $ty [$pkey]";        
                                $tags []= "orig-ovf-$ty";
                                $titles []= "Apply logo to $ty [$pkey]";        
                                $tags []= "orig-$ty";
                            } else {
                                $titles []= "Initial standardise $ty [$pkey]";        
                                $tags []= "orig-$ty";                             
                            }
                            $titles []= "Generate HD $ty [$pkey]";        
                            $tags []= "hd-$ty";
                            if($ty!="trailer") {
                                $titles []= "Generate preview slice 1 $ty [$pkey]";        
                                $tags []= "preview-slice-1";
                                $titles []= "Generate preview slice 2 $ty [$pkey]";        
                                $tags []= "preview-slice-2";
                                $titles []= "Generate preview slice 3 $ty [$pkey]";        
                                $tags []= "preview-slice-3";
                                $titles []= "Generate preview slice 4 $ty [$pkey]";        
                                $tags []= "preview-slice-4";                                
                                $titles []= "Join slices $ty [$pkey]";        
                                $tags []= "preview-join";
                                $titles []= "Generate slides $ty [$pkey]";        
                                $tags []= "slides";
                            }
                            $pmkey = "$smd-$mkey";
                            self::ffmpeg_progress($pmkey, "master", "__rtoClass=ffmpeg");
                            self::ffmpeg_progress($pmkey, "master", "__rtoType=$ty");
                            self::ffmpeg_progress($pmkey, "master", "__rtoTitle=$pkey");
                            
                            for($qi=0;$qi<sizeof($tags);$qi++) {
                                $key = $tags[$qi];
                                                                
                                self::ffmpeg_progress($pmkey, $key, "__rtoClass=ffmpeg");
                                self::ffmpeg_progress($pmkey, $key, "__rtoStatus=queued");
                                self::ffmpeg_progress($pmkey, $key, "__rtoScheduled=".time());
                                self::ffmpeg_progress($pmkey, $key, "__rtoTitle=$titles[$qi]");
                            }
                        }                        
                    }
                }
            }
        }        
    }
    
    static function ffmpeg_progress($mkey,$key,$out) {
        if(empty($out)) return;
        file_put_contents("/tmp/out.txt",$out,FILE_APPEND);
        
        $procd = @json_decode(file_get_contents($pfn = SYS_CONTENT_DIR."/rt-process.json"),true);
        if(!$procd) $procd = [];
        if(!isset($procd[$mkey])) $procd[$mkey] = [$key=>[]];        
        else if(!isset($procd[$mkey][$key])) $procd[$mkey][$key] = [];        
        @list($var,$val) = @explode("=",$out,2);
        if($val) {
            if(strpos($var," ")===false) {
                $procd[$mkey][$key][$var] = $val;
                $procd[$mkey]["master"]["__expires"] = time()+600;
                file_put_contents($pfn, json_encode($procd));        
            }
        }                
    }
    
    function run($rkey,$arg) {
        $ovideo = $video = $arg[0];
        if(!is_file($video)) return "BAIL: FILE NOT FOUND [$video]\n";        
        
        $ent = new video;
        
        $smd = explode(".",explode("//",DOM)[1])[0];
        $ffmpeg = app::$ffcmd_common;
        $cntset = (new option("optcns","appearance"))->fetch("vals");
        $ovf = null;
        $ops = "";
        $hasovf = false;
        if(@$cntset['enable_video_overlay']=="on") {                        
            if(!is_file($ovf = COM_CONTENT_DIR."/video_overlay_file.png")) $ovf = null;
            else $hasovf = true;
            switch(@$cntset['video_overlay_position']) {
                case "Top center":
                    $ops = "(W-w)/2:0";
                    break;
                case "Top left":
                    $ops = "0:0";
                    break;
                case "Top right":
                    $ops = "(W-w):0";
                    break;
                case "Bottom left":
                    $ops = "0:H-h";
                    break;
                case "Bottom right":
                    $ops = "(W-w):H-h";
                    break;
                default:
                    $ops = "(W-w)/2:H-h";
                    break;
            }
        }
        
        
        $h = $arg[1];
        $f = $arg[2];
        $ty = strpos($f,"trailer_")===0?"trailer":"video";        
                
        $final = MEM_CONTENT_DIR."/$h/standard_orig_".$f."__.mp4";
        $standard = MEM_CONTENT_DIR."/$h/working_orig_".$f."__.mp4";
        $standardt = MEM_CONTENT_DIR."/$h/temp_orig_".$f."__.mp4";
        if(!is_file($standard)) {            
            $command = $ffmpeg . ' -i ' . $video . ' -threads '.VID_THREADS.' -preset '.VID_PRESET.' -vcodec libx264 -pix_fmt yuv420p '.$standardt;            
            while($command) {                
                $output = runner::rt_exec("$smd-$rkey",$ovf?"orig-ovf-$ty":"orig-$ty",$command,"ffmpeg","ffmpeg_progress");
                echo $output;                            
                if(is_file($standardt)) {                
                    if($video!=$standard) @unlink($video);
                    rename($standardt,$standard);    
                    $video = $standard;                    
                } else {
                    @rename($video,"/tmp/fail_{$smd}_$f");
                    self::ffmpeg_progress("$smd-$rkey",$ovf?"orig-ovf-$ty":"orig-$ty","__rtoStatus=failed");
                    return "BAIL: ORIG[$command]\n";                    
                }
                $command = null;
                if(is_file($video) && $ovf) {
                    $info = app::media_info($video);

                    $image = imagecreatefrompng($ovf);
                    $sx = imagesx($image);
                    $sy = imagesy($image);
                    $width = $info['width'] * 0.1;
                    $height = ceil($width*($sy/$sx));
                    $new_image = imagecreatetruecolor($width, $height); 
                    imagealphablending($new_image , false);
                    imagesavealpha($new_image , true);
                    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $sx, $sy);
                    $image = $new_image;

                    // saving
                    imagealphablending($image , false);
                    imagesavealpha($image , true);                    
                    $ovfr = "/tmp/ovf_{$smd}_resized.png";
                    @unlink($ovfr);
                    imagepng($image, $ovfr);                            
                    $command = $ffmpeg . ' -i ' . $video . ' -i ' . $ovfr . ' -filter_complex \'[0:v][1:v] overlay='.$ops.'\' -threads '.VID_THREADS.' -preset '.VID_PRESET.' -vcodec libx264 -pix_fmt yuv420p '.$standardt;
                    $ovf = null;                    
                }
            }        
        } else $video = $standard;
        $hd = MEM_CONTENT_DIR."/$h/standard_hd_".$f."__.mp4";
        $hdt = MEM_CONTENT_DIR."/$h/temp_hd_".$f."__.mp4";
        if(!is_file($hd) && is_file($video)) {
            $command = $ffmpeg . ' -i ' . $video . ' -threads '.VID_THREADS.' -vf scale=-2:720 -preset '.VID_PRESET.' -vcodec libx264 -pix_fmt yuv420p '.$hdt;                       
            $output = runner::rt_exec("$smd-$rkey","hd-$ty",$command,"ffmpeg","ffmpeg_progress");            
            echo $output;
            if(is_file($hdt)) {
                rename($hdt,$hd);
            } else {
                rename($video,"/tmp/fail_{$smd}_$f");
                self::ffmpeg_progress("$smd-$rkey","hd-$ty","__rtoStatus=failed");
                return "BAIL: HD [$command]\n";                
            }
        }      
  
        if($ty!="trailer") {                        
            $pre = MEM_CONTENT_DIR."/$h/standard_preview_".$f."__.mp4";
            $pret = MEM_CONTENT_DIR."/$h/temp_preview_".$f."__.mp4";
            if(!is_file($pre) && is_file($video)) {
                $time = 5;                            
                $video_attributes = app::get_video_attributes($video);
                $du = $video_attributes['hours'] * 3600 +  $video_attributes['mins'] * 60 + $video_attributes['secs'];
                $t1 = $du * 0.25;
                $t2 = $du * 0.5;
                $t3 = $du * 0.75;
                $t4 = $du - 180;
                $sa = [$t1,$t2,$t3,$t4];
                $idx = 1;
                foreach($sa as $start) {
                    $command = $ffmpeg . ' -i ' . $video . " -threads ".VID_THREADS." -ss $start -t $time -filter:v scale=\"trunc(oh*a/2)*2:720\" -an -progress - /tmp/slice-$smd-$idx.mp4";
                    $st = "$idx of 4";
                    $output = runner::rt_exec("$smd-$rkey","preview-slice-$idx",$command,"ffmpeg","ffmpeg_progress");                    ;
                    echo $output;$idx++;
                }
                $cnt = "";
                for($i=1;$i<=4;$i++) {
                    $cnt .= "file '/tmp/slice-$smd-$i.mp4'\n";
                }
                file_put_contents("/tmp/preview-$smd.txt", $cnt);
                $command = $ffmpeg . " -threads ".VID_THREADS." -f concat -safe 0 -i /tmp/preview-$smd.txt -c copy ".$pret;                
                $output = runner::rt_exec("$smd-$rkey","preview-join",$command,"ffmpeg","ffmpeg_progress");                
                echo $output;

                rename($pret,$pre);    
            }
        }
        
        if($ty!="trailer") app::slides([0,0,$video],"$smd-$rkey");

        if(is_file($video)) {                          
            if($ty!="trailer") {
               $res = var_export($ent->action("set-working-attrs",$h,$f),true);
               echo "PROCESSED [attrs=$res]\n";                          
            } else echo "PROCESSED\n";                          
            rename($video,$final);
            @unlink($ovideo);
        }
    }
           
}

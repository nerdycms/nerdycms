<?php

// Author: Simon Newton

class storage {
    function schedule() {
            $sett = (new option("optBunny", "storage"))->fetch("vals");
            $bon = @$sett['enabled']=="Yes";
            if(!$bon) return;                      
            //ffmpeg -an -i input.mov -vcodec libx264 -pix_fmt yuv420p -profile:v baseline -level 3 output.mp4
            $homes = scandir(MEM_CONTENT_DIR);
            foreach($homes as $h) {                                
                if($h[0]==".") continue;
                
                if(is_dir(MEM_CONTENT_DIR."/$h")) {
                    $files = scandir(MEM_CONTENT_DIR."/$h");
                    foreach ($files as $f) {
                        if($f[0]=="." || $f=="slides") continue;
                                                
                        $bunny = $sett["http_url"]."/$f";
                        if((strpos($f,"small_")===0 || strpos($f,"med_")===0 || strpos($f,"large_")===0 || strpos($f,"standard_")===0))  {
                            if(app::http_file_exists($bunny)) {
                                $bf = MEM_CONTENT_DIR."/$h/$f";
                                echo "$bf already exists!\n";
                                unlink($bf);
                            } else {
                                runner::tailJob(get_class(),["$f", MEM_CONTENT_DIR."/$h/$f"]);
                            }
                        }                            
                    }
                    if(!is_dir(MEM_CONTENT_DIR."/$h/slides")) {
                        //echo "Skipping ".MEM_CONTENT_DIR."/$h/slides";
                        continue;
                    }
                    
                    $slides = scandir(MEM_CONTENT_DIR."/$h/slides");
                    foreach($slides as $s) {                                
                        if($s[0]==".") continue;                  
                        $nodel = strpos($s,"med_")===0;
                        $bunny = $sett["http_url"]."/slide_$s";
                        if(!app::http_file_exists($bunny))  {
                            //runner::tailJob(get_class(),["slide_$s", MEM_CONTENT_DIR."/$h/slides/$s"]);
                            $this->bunUp(get_class(),"slide_$s", MEM_CONTENT_DIR."/$h/slides/$s",$nodel);
                        } else {
                            if(!$nodel) unlink(MEM_CONTENT_DIR."/$h/slides/$s");
                        }
                    }            
                }                 
            }
    }
    
    function bunUp($key,$dn,$src,$nodel=false) {
        $sett = (new option("optBunny", "storage"))->fetch("vals");

        $ftp_server = $sett["server"];  
        $ftp_username = $sett["username"];
        $ftp_userpass = $sett["password"];
        $ftp_dir = $sett["ftp_dir"];

      /*  if(strpos($dn,".h-s-h.")===false) {
            $ext = pathinfo($dn,PATHINFO_EXTENSION);
            if(strpos($dn,"slide_")===0) {
               $dn = "slide_".hash('sha256',"hdtheuh".substr($dn,6)).".h-s-h.$ext";
            } else {
                $dn = hash('sha256',"hdtheuh".$dn).".h-s-h.$ext";
            }
        }*/

        $dst = "ftp://$ftp_username:$ftp_userpass@$ftp_server/$ftp_dir/$dn";

        $fsize = filesize($src);
        if(!$fsize) return false;

        app::log($key,"$src > $dst [$fsize]\n");

        $handle = fopen($src, "r");

        // open handle for saving the file
        $options = array('ftp' => array('overwrite' => true));
        $context = stream_context_create($options);
        $local_file = fopen($dst, "w", false, $context);
        if(!$local_file) return false;        
        
        // create a variable to store the chunks
        $chunk = '';
        $written = 0;
        $delta = -1;
        // loop until the end of the file
        while (!feof($handle)) {                
          // get a chunk
          $chunk = fread($handle, 4096*1024);

          // here you do whatever you want with $chunk
          // (i.e. save it appending to some file)
          $delta = fwrite($local_file, $chunk);                  
          //fwrite(STDERR, $delta>0?".":"?");
          if($delta==0) {
                sleep(1);
                $handle = fopen($src,'r');
                $local_file = fopen($dst,'a');
                fseek($handle, $written);
          } else {
              if($delta>0) $written += $delta;
          }
        }

        $delta = -1;
        while ($written < $fsize) {
            if(feof($handle)||$delta==0) {
                sleep(1);
                $handle = fopen($src,'r');
                $local_file = fopen($dst,'a');
                fseek($handle, $written);
            }                    
            // get a chunk
            $chunk = fread($handle, 4096*1024);

            // here you do whatever you want with $chunk
            // (i.e. save it appending to some file)
            $delta = fwrite($local_file, $chunk);                                      
            if($delta>0) $written += $delta;

            //fwrite(STDERR, $delta>0?".":"?");
        }
        app::log($key,"\n$written byes written\n");

        // close handles
        fclose($handle);
        fclose($local_file);
        if(!$nodel) unlink($src);
        return true;
    }
    
    function run($rkey,$arg) {
        return !$this->bunUp($rkey,$arg[0],$arg[1]);                            
    }
}
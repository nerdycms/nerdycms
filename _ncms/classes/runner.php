<?php

//Author: Simon Newton

class runner {
    public function __construct($force = null,$fa = null) {
        $sett = (new option("optBunny", "storage"))->fetch("vals");
        $bon = @$sett['enabled']=="Yes";
        if($bon) {
            app::$storage = "bunny";
            app::$assetPath = @$sett["http_url"];   
            if(app::$assetPath[strlen(app::$assetPath)-1]!="/") app::$assetPath .= "/";
        }
        
        if($force) {
            $this->check($force);
            $job = ['cn'=>$force,'arg'=>$fa ];            
            $this->doit("force-run",$job);
        } else {
            $this->check();
            if(!self::isRunning()) $this->go();
        }
    }
    
    static function log($key,$msg) {
        file_put_contents(SYS_CONTENT_DIR."/runner.log", date('Y-m-d H:i:s')."|$key ### $msg\n",FILE_APPEND);        
    }
    
    static function rt_exec($mkey,$key,$cmd,$callcls,$callfn) {                      
        if(strpos($cmd,app::$ffcmd_common)===0) {
            $video = explode(" ",substr($cmd, strlen(app::$ffcmd_common)+4))[0];
            file_put_contents("/tmp/frvid.txt", $video,FILE_APPEND);
            if($frames=app::video_frame_count($video)) call_user_func([$callcls,$callfn],$mkey,$key,"__totFrames=$frames");                                
        }
                
        $out = $line = "";
        $filp = "/tmp/rt-$mkey-$key";
        file_put_contents(SYS_CONTENT_DIR."/runner.log", date('Y-m-d H:i:s')."|$mkey ### $cmd\nLogging to $filp-rto.txt\n",FILE_APPEND);        
        
        $descriptorspect = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
         );
        
        file_put_contents("$filp-rto.txt","__cmd=$cmd\n");
        $ff = proc_open("$cmd >> $filp-rto.txt 2>&1", $descriptorspect, $fpipes);        
        $mpid = proc_get_status($ff)['pid'];
        call_user_func([$callcls,$callfn],$mkey,$key,"__rtoStatus=".($mpid?"running":"failed"));
        $lines = "";
        $gs = "\n";    
        $buffer = "";                    
        $file = fopen("$filp-rto.txt",'r');
        stream_set_blocking($file,0);        
        while (@self::isRunning($mpid))
        {                            
            $out = fread($file, 1024);    
            if($out && strlen($out)>0) {
                $buffer .= $out;
                while (strstr($buffer,$gs))
                {
                    $ex=explode($gs,$buffer,2);
                    $buffer=@$ex[1]; $line=@$ex[0];                        
                    call_user_func([$callcls,$callfn],$mkey,$key,$line);                    
                }                    
            }            
            usleep(100000);
        }
        if(!empty($line)) call_user_func([$callcls,$callfn],$mkey,$key,$line);                    
        fclose($file);        
        
        if(!empty($lines)) file_put_contents(SYS_CONTENT_DIR."/runner.log", $lines, FILE_APPEND);
        
        call_user_func([$callcls,$callfn],$mkey,$key,"__rtoStatus=finished");
        return $out;
    }
    
    static function log_exec($key,$cmd) {
        file_put_contents(SYS_CONTENT_DIR."/runner.log", date('Y-m-d H:i:s')."|$key ### $cmd\n",FILE_APPEND);
        return shell_exec($cmd);
    }
    
    static function tailJob($cn,$arg) {     
        if(!($curjobs = @json_decode(@file_get_contents($rfn = SYS_CONTENT_DIR."/runner.json"),true))) $curjobs = [];
        $json = json_encode([$cn,$arg]);
        $hash = md5($json);
        if(!isset($curjobs[$hash])) {
            $curjobs[$hash] = ["cn"=>$cn,"arg"=>$arg,"tries"=>3];
            file_put_contents($rfn, json_encode($curjobs));
            return $hash;
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
    
    function check($only=null) {               
        $set = self::loadables(NROOT."console");
        foreach($set as $l) {
            $cls = $this->inst($l);
            if($only && $only!=$cls) continue;
            
            include $l;                        
            $in = new $cls;
            if(!$only) $resp = $in->schedule();                                    
        }
    }

   static function isRunning($pid = null)
    {
        try {
             
            try {
                //$l = shell_exec("ps -ef | grep defunct");
    
                if(!$pid) $pid = trim(@file_get_contents(SYS_CONTENT_DIR."/runner.pid"));
                
                if (empty($pid)) {
                    //file_put_contents("/tmp/dout.txt", "pid is empty\n",FILE_APPEND);
                    return false;
                }

                $executed = filter_var(trim(shell_exec("ps -p $pid -o etime")), FILTER_SANITIZE_NUMBER_INT);
                
                //if ((int)$executed > 1500 || empty($executed)) {
                if (empty($executed)) {
                    //shell_exec("kill -9 $pid");
                  //  file_put_contents("/tmp/dout.txt", "$pid is not running\n",FILE_APPEND);
                    return false;
                }
                $d = shell_exec("ps -p $pid");
                if(strpos($d,"<defunct>")!==false) return false;
                //file_put_contents("/tmp/dout.txt", "$pid is nunning $executed\n",FILE_APPEND);
                return true;
            } catch(Exception $e) {
            }
        } 
            catch (Throwable $exception) {
        }

        return true;
    }
    
    function doit($key,&$job) {
        $inst = new $job['cn'];            
        self::log($key, "GO $job[cn]\n". json_encode($job['arg'])."\n-----------------------------------------------------------------------------------");        
        if($msg = $inst->run($key,$job['arg'])) {
            if(--$job['tries']>0) {
                self::log($key,"\n######### ERROR - $msg ### RETRY $job[tries] ###\n\n");                    
                return true;
            } self::log($key,"\n######### ABANDON - $msg ###\n\n");
        } else self::log($key,"\n################################################# COMPLETE #########################################################\n\n");           
    }
    
    function go() {     
        //echo "going";
        if(!($curjobs = @json_decode(@file_get_contents($rfn = SYS_CONTENT_DIR."/runner.json"),true))) $curjobs = [];
        if(sizeof($curjobs)>0) {
            file_put_contents(SYS_CONTENT_DIR."/runner.pid", getmypid());
            $key = array_key_first($curjobs);
            $job = $curjobs[$key];
            unset($curjobs[$key]);
            file_put_contents(SYS_CONTENT_DIR."/runner.json", json_encode($curjobs));                                    
            ob_start();            
            if($this->doit($key,$job)) {
                if(!($curjobs = @json_decode(@file_get_contents($rfn),true))) $curjobs = [];
                $curjobs[$key] = $job;
                file_put_contents(SYS_CONTENT_DIR."/runner.json", json_encode($curjobs));                                    
            }
            $out = ob_get_contents();
            ob_end_clean();            
            file_put_contents("/tmp/".BRAND_NAME."_".date("Y-m-d_H-i-s")."_$key.out",$out);                        
        }
    }
}

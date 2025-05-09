<?php
app::check();

class queuePage extends page {    
    var $file,$filter;
    
    function __construct($name,$file,$filter) {
        parent::__construct($name);
        $this->file = $file;
        $this->filter = $filter;
    }
    
    function handle() {
        switch(@app::request("_action")) {
            case 'vqueue':
                $raw = @file_get_contents(SYS_CONTENT_DIR."/$this->file");
                $queue = @json_decode($raw,true);
                $qresp = $dresp = $rresp = $resp = "";                
                $icos = ["queued"=>"clock","running"=>"history","finished"=>"check","failed"=>"warning"];
                if($queue) foreach($queue as $k=>$v) {
                    $resp = "<div class='q-group'>";
                    $vm = @$v['master'];
                    if($vm) {
                        $et = @$vm['__expires'];                        
                        if($et>0 && $et<time())                            continue;
                        
                        $resp .= "<h3>$vm[__rtoType] $vm[__rtoTitle]</h3>";
                    }
                    $allQ = true;
                    $canDismiss = true;
                    foreach($v as $vk=>$vv) {
                        if($vk=="master") continue;
                        
                        $stat = $vv['__rtoStatus'];                        
                        $resp .= "<div class='q-right'>";
                        if($stat!="queued") $allQ = false;
                        if($stat!="finished") {
                            $canDismiss = false;
                            $cf = (int)@$vv['frame'];
                            $tf = (int)@$vv['__totFrames'];

                            if(strpos($vk,"slice")!==false) $tf/=4;
                            
                            if($tf>0) {
                                $w = (100*$cf/$tf)."%";
                                $resp .= "<span class='q-prog'><span style='width:$w' class='q-progi qpr-$stat'>&nbsp;</span></span>";
                            } else $resp .= "<span class='q-prog-myst'></span>";
                        } else $resp .= "<span class='q-prog'><span style='width:100%' class='q-progi qpr-$stat'>&nbsp;</span></span>";
                        $resp .= "<span class='q-status qst-$stat'><i class='fa fa-$icos[$stat]'> </i> $stat</span></div>";
                        $resp .= "<h5>$vv[__rtoTitle]</h5>";
                    }
                    if($canDismiss) {
                        $resp .= "<div class='q-tools'>";
                        if($vm && $vm['__rtoType']=='video') $resp .= '<input name="publish" type="checkbox" class="form-check-input"> Make live now';
                        $resp .= "<button class='btn btn-primary'>Dismiss</button></div>";
                        $resp .= "</div>";
                        $dresp .= $resp;                        
                    } else {
                        if($allQ) $qresp .= $resp."</div>";
                        else $rresp .= $resp."</div>";
                    }           
                    $resp = "";
                }
                if(!empty($rresp)) echo "<h2>Running:</h2>$rresp";
                if(!empty($dresp)) echo "<h2>Completed:</h2>$dresp";
                if(!empty($qresp)) echo "<h2>Queued:</h2>$qresp";
                if(empty($rresp.$dresp.$qresp)) echo "<h2>Nothing to do...</h2>";
                
                exit();
                break;
        }
        return parent::handle();
    }
}
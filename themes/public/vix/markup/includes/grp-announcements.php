<?php 
$mid = app::memberUser();
$ann = new announce(["where"=>"target_id=$mid AND IFNULL(been_read,'')!='Yes'"]);
$list = $ann->fetch("array");        
?>
<div class="profile-info col-md-9">          
<div class="panel">
    <div class="bio-graph-heading">
                Announcements (<?=sizeof($list)?>)
    </div>
    <div class="panel-body wallet-info">
        {{member-ann}}
    </div>
</div>          
</div><br><br>
        
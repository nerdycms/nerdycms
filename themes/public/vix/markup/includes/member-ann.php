<?php
$ann = new announce(["where"=>"target_id=$mid AND IFNULL(been_read,'')!='Yes'"]);
$arr = $ann->fetch("array");        
?>

<table class="member-ann">    
<?php
$limit = 50;
$msg = new smsBody;
foreach($arr as $a) { 
    echo "<tr>";
    $s = $msg->fetch("id",$a['msg_id']);
    echo "<td>$s[body]<br><br><a href='".VDIR."profile?_group=announcements&did=$a[id]' class='ucase float-right'>Dismiss</a></td>";    
    echo "</tr>";
    if(!$limit--) break;
} ?>
</table>
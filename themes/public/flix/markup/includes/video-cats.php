<div>
<?php
$ent = new category(["where"=>"sexuality='Straight' AND publish_status='Published'"]);
$arr = $ent->fetch("array");
foreach($arr as $a) { 
    if(empty($a=trim($a)))        continue;
    
    $sl = app::slug($a,'-');    
    echo "<div class='$data[1]' data-slug='$sl'><input type='checkbox'> $a</div>";
    }?><div class='float-right'><button class="ucase btn-prim cat-reset">x reset</button></div></div>

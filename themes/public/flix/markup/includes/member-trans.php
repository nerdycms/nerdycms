<?php
$ent = new transaction;
$arr = $ent->fetch("array");
?>

<table class="member-trans">    
<?php
$limit = 25;
foreach($arr as $a) { 
    echo "<tr>";
    foreach($ent->cols->items("user-listable") as $c) {
        echo "<td>$a[$c]</td>";
    }
    echo "</tr>";
    if(!$limit--) break;
} ?>
</table>
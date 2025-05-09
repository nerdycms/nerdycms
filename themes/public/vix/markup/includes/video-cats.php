<div class="cat-wrap">
<?php
$ca = explode("|",@$_GET['_search']);
$ent = new category(["where"=>"sexuality='Straight' AND publish_status='Published'"]);
$arr = $ent->fetch("array");
foreach($arr as $a) { 
    if(empty($a=trim($a)))        continue;
    
    $sl = app::slug($a,'-');    
    $cp = in_array($sl, $ca)?" checked":"";
    echo "<div class='$data[1]'><input class='catc' data-slug='$sl' type='checkbox'$cp> $a</div>";
    }?><div class='float-right'><button class="ucase btn-prim cat-reset">x reset</button></div></div>
<script>
$(()=>{
    $('.catc').on('input',(ev)=>{
        
            var ss = "";
            var $all = $(ev.target).parents('.cat-wrap').first().find('.catc');
            $all.each((i,o)=>{
                var $o = $(o);               
                var sl = $o.attr('data-slug');
                if($o.prop('checked') && ss.indexOf(sl)===-1) ss += "|" + sl;

            });
            var sort = '<?=@$_GET['_sort']?>';
            if(ss!='') ss = ss.substr(1);
            window.location.href = "<?=$this->hook?>" + (ss!=''?"?_search=" + ss:"") + (sort!=''?"&_sort=" + sort:"");        
    });
});
</script>

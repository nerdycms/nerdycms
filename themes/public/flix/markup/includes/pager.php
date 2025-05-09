<div class="pagination-wrapper <?=$data[1]?>">
    <?php if($this->hook!="/blog") { ?>
  <div class="pagination no-mobile">
    <a class="prev page-numbers" href="javascript:;">All</a>
    <span aria-current="page" class="page-numbers current">4K</span>
    <a class="page-numbers" href="javascript:;">HD</a>    
    <a class="next page-numbers" href="javascript:;">SD</a>
  </div> 
      <div class='pagination no-desktop filter'>
        <a onclick="$('#mobcats_t').slideToggle()" href="javascript:;"><i class='fa fa-filter'></i></a>
    </div>  
    <?php } ?>
  <div class="pagination">
    <a class="prev page-numbers" href="javascript:;">prev</a>
    <span aria-current="page" class="page-numbers current">1</span>
    <a class="page-numbers" href="javascript:;">2</a>
    <a class="page-numbers no-mobile" href="javascript:;">3</a>
    <a class="page-numbers no-mobile" href="javascript:;">4</a>
    <a class="page-numbers no-mobile" href="javascript:;">5</a>
    <a class="page-numbers" href="javascript:;">...</a>
    <a class="page-numbers no-mobile" href="javascript:;">7</a>
    <a class="page-numbers no-mobile" href="javascript:;">8</a>
    <a class="page-numbers" href="javascript:;">9</a>
    <a class="page-numbers" href="javascript:;">10</a>
    <a class="next page-numbers" href="javascript:;">next</a>
  </div>
  
  
</div>
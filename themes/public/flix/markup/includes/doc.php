<!DOCTYPE html>
<script>
    var mde = window.localStorage['ui-mode'];
    if(!mde) mde = '<?=$this->pdata['theme-class']?>';
    document.write('<html class="' + mde + '">');
</script>

    
var dbg = (m) => {
    console.log("DBG:",m);
};
var reveal = (p,i) => {                        
    var $p=$('#'+p);
    $p.toggleClass("option-active");
    $p.find(".grp-option-ctl").toggleClass("option-active");
};
var tab = (ev,tid) => {
    var $g = $(ev.target);
    if(!$g.hasClass('tab-passive')) return;
    
    var $t = $('#'+tid);
    var $p = $t.parents().first();
    $p.find('.tab-view').hide();
    $t.show();
        
    $p = $g.parents().first();
    $p.find('button').addClass('tab-passive');
    $g.removeClass('tab-passive');    
};


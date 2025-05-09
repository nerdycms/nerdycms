<link rel="icon" type="image/x-icon" href="<?=VDIR?>content/common/favorite_icon.ico">  
<base href="<?=VDIR?>themes/public/vix/" />    
<?php $seo = new option("optSEO","seo-group");
$vl = $seo->fetch("vals");

$can = $this->hook;
$uh = $_SERVER['REQUEST_URI'];
$majorQ = ["p","_video","_model-name"];
$ac="?";
foreach($majorQ as $q) {
    if($v=app::request($q)) {
        if($q=="p" && $v=="1") continue;
        
        $m = "$q=$v";
        $idx = strpos($uh ,$m);
        $uh = substr($uh,0,$idx-1).substr($uh, $idx+2+strlen($m));
        $can .= $ac.$m;
        $ac="&";
    }
}

$fp = DOM.$can;
echo "<link rel='canonical' href='$fp' />\n";        

if(empty($vl['site_title'])) $vl['site_title']=$vl['site_name'];
$this->pdata["site_name"] = @$vl['site_name'];
$this->pdata["site_title"] = @$vl['site_title'];
$this->pdata["site_description"] = @$vl['site_description'];
$this->pdata["site_keywords_meta"] = @$vl['site_keywords_meta'];

$aut = app::human_readable((app::urlTail($this->hook)));
if(empty($this->pdata['page_name'])) $this->pdata['page_name'] = @$vl['site_name'];
if(empty($this->pdata['page_title'])) $this->pdata['page_title'] = empty($aut)?@$vl['site_title']:$aut;
if(empty($this->pdata['page_description'])) $this->pdata['page_description'] = @$vl['site_description'];
if(empty($this->pdata['page_keywords_meta'])) $this->pdata['page_keywords_meta'] = @$vl['site_keywords_meta'];

if(!empty($this->pdata['meta_sub_post'])) {
    $this->pdata['page_title'] .= " ".$this->pdata['meta_sub_post'];
    $this->pdata['page_description'] .= " ".$this->pdata['meta_sub_post'];
}

if(isset($this->pdata['video'])) {
    if(!empty($this->pdata['video']['description'])) $this->pdata['site_description'] = $this->pdata['video']['description'];
    $vid = new video;    
    echo '<meta property="og:image" content="'.$vid->meta($this->pdata['video'],"abs-poster").'">'."\n";
    echo '<meta name="twitter:card" content="summary_large_image">'."\n";    
    echo '<meta name="twitter:image" content="'.$vid->meta($this->pdata['video'],"abs-poster").'">'."\n";    
}

echo '<meta name="twitter:site" content="'.DOM.'">'."\n";
echo '<meta name="og:url" content="'.DOM.$_SERVER['REQUEST_URI'].'">'."\n";    

if($vl) foreach($vl as $fk=>$vr) {    
    $k = str_replace("site_","",$fk);
    $vr = @$this->pdata["page_$k"]??$vr;
    $v = htmlentities($vr);
    if(empty($vr))        continue;    
    switch($k) {
        case 'description':
            echo "<meta name='$k' content='$v'>\n";
            echo "<meta property='og:$k' content='$v'>\n";
            echo "<meta property='twitter:$k' content='$v'>\n";
            break;
        case "name":
            break;
        case "title":
            if(!empty($vl['site_title']) && $vl['site_title']!=$v) $v .= " | $vl[site_title]";
            echo "<$k>$v</$k>\n";  
            echo "<meta property='og:$k' content='$v'>\n";
            echo "<meta name='twitter:$k' content='$v'>\n";
            break;
        case "google_anayltics_code":                    
            echo $vr;
            break;
        case "keywords_meta":   
            echo "<meta name='keywords' content='$v'>\n";
            break;
    }
    echo "\n";
    
} ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swup/2.0.16/swup.min.js" integrity="sha512-fgYcGB+v3caa65yeKMScXZ75+inW2WICnzY7frCIoISBKl6wLMyU9+2V/tqtQsEsy8ldkVw4FcM6tQUaYeIM/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css" integrity="sha512-XWTTruHZEYJsxV3W/lSXG1n3Q39YIWOstqvmFsdNEEQfHoZ6vm6E9GK2OrF6DSJSpIbRbi+Nn0WDPID9O7xB2Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

  <style>
    @media (min-width: 560px) and (max-width: 650px) {
      header .jarallax h5 {
        margin-bottom: 1.5rem !important;
      }
    }

    .top-nav-collapse {
      background: var(--bkg) !important;
    }

    .navbar:not(.top-nav-collapse) {
      background: transparent !important;
    }

    @media (max-width: 768px) {
      .navbar:not(.top-nav-collapse) {
        background: var(--bkg) !important;
      }
      .navbar-brand {
          scale: 0.75;
          margin-right: -25%;
          transform: translateX(-25%);
      }
      .custom-nav {
          scale: 0.75;
          margin-left: -25%;
          transform: translateX(12.5%);
      }
    }

    @media (min-width: 800px) and (max-width: 850px) {
      .navbar:not(.top-nav-collapse) {
        background: var(--bkg) !important;
      }
      .navbar-brand {
          scale: 0.75;
          margin-right: -25%;
          transform: translateX(-25%);
      }
      .custom-nav {
          scale: 0.75;
          margin-left: -25%;
          transform: translateX(12.5%);
      }
    }
    
    .nbt {
        color: var(--text)!important;
    }

    h1 {
      letter-spacing: 8px;
    }

    h5 {
      letter-spacing: 3px;
    }

    .hr-light {
      border-top: 3px solid #fff;
      width: 80px;
    }

    footer.page-footer {
      background-color: #000;
    }

    @media (max-width: 450px) {
      .btn-floating {
        margin-left: 0;
        margin-right: 0;
      }
    }
    
    .required {
        border: solid 7px #f00!important;
    }
    .required::placeholder {
        color: #f00!important;
    }
    .blur *:not(.blocker,.modal,.widget,.modal *) {
        filter: blur(.5rem);
    }
    #agev .close-modal {
        display: none;
    }
    .text-right {
        text-align: right;
    }
    .text-justify {
        text-align: justify-all;
    }
    .btn-prim,.btn-sec {
        padding: 0 .25rem;
    }
    
    .cwrap {
        position: relative;
        padding: 0!important;
    }
    .cwrap video {
        width:100%; 
    }
    .cwrap h1 {
        position: absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        text-align: center;
        align-content: center;
        justify-content: center;    
        display:flex;
    }
    .cwrap span {
        margin: auto;
        display: inline-flex;
    }    
    .live-wrap {
        position: relative;
        height: calc(100vh - 4.5rem);                
        border-radius: 2rem;        
    }
    .live-video {
        position: absolute;
        width: 100%;
        height: 100%;                
    }
    .live-wrap table {
        position: absolute;
        width: 100%;
        height: 100%;                                
    }
    .live-wrap tr {
        vertical-align: bottom;
    }
    .live-wrap td:last-child {        
        background: linear-gradient(0,rgba(255,255,255,.8),transparent,transparent,transparent,rgba(255,255,255,.8));         
        padding: .5rem;        
        padding-bottom: 5rem;
        width: 30%;
    }
    .live-msg {                     
        height: 100%;         
    }    
    .rmsg {
        display: block;
        background: rgba(0,0,0,.3);        
        width: 100%;
        padding: .5rem;
        border: solid 1px rgba(255,255,255,.3);
        border-bottom: none;
        color: #fff;
    }
    .rmsg:nth-child(even) {
        background: rgba(0,0,0,.5);
    }
    .live-wrap #live_send {
        background: rgba(255,255,255,.5);
        border-radius: 0;
        width: 30vw;
        position: fixed;
        bottom:0;
        transform: none!important;
        bottom: 0;        
        right: 0;
    }
    .live-video {
        text-align: left;
    }
    .live-video video {
        height: calc(100vh - 4.5rem);
        margin: auto auto auto 0;
        background: #000;
    }
    .live-wrap h1 {
        position: absolute;
        z-index: 100;
        top: 5rem;
    }    
    .usr,.dte,.msg {
        padding: .125rem;
    }
    .dte {
        opacity: .2;
    }
    .widget {
        margin: 0;
        padding: 0;    
    }
    .pay-meth {
        width:140px;
        height: 70px;
        background-position: center center;
        background-size: cover;
        display: inline-block;
        margin: 1rem;
        font-weight: bold;
        padding: 1rem;
        opacity: .5;  
        transform: scale(.75);      
        cursor: pointer;
    }
    .pay-meth:hover {
        opacity: .75;
        transform: scale(.85);      

    }
    .meth-active {
        opacity: 1;
        transform: scale(1)!important;      
    }
    .live-chat,.chat-msg {
        height: 100%;
    }
    #chat_msg {
        background: green;
        color: red;    
    }
    
    .nd-player-wrap {
        text-align: center;
    }
    
    #report {
        width: 50vw;
        max-width: 1000px;
    }
    
    #report iframe {
        height: 1500px;
        width: 100%;
        overflow: auto;
    }
    
    .galp-img {
        min-height: 90vh;
        width: 100%;
    }
    .blocker {
          background-color: rgba(0,0,0,0.275)!important;
    }
  </style>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<link rel="stylesheet" href="<?=VDIR?>styles?_theme=vix&_ver=10000">
<style>
    {{data|custom_css}}
</style>

<script>
    window.pushServerKey = '<?= app::getWebPushPublicKey() ?>';
</script>

<?= app::asset("themes/public/vix/assets/web-push.js"); ?>
<?= app::asset("themes/public/pushWorker.js"); ?>

<script>
    function fmtDate(dte,p) {           
    var yyyy = dte.getFullYear();
    var mm = dte.getMonth() + 1; // getMonth() is zero-based
    var dd = dte.getDate();
    var ymd = String(10000 * yyyy + 100 * mm + dd); // Leading zeros for mm and dd

    var hh = dte.getHours();
    var ii = dte.getMinutes();
    var ss = dte.getSeconds();
    var his = String(10000 * hh + 100 * ii + ss); // Leading zeros for mm and dd
    his = hh<10?"0" + his:his;

    var ret = '';
    var idx = {};
    for(var i=0;i<p.length;i++) {
        var c = p[i];
        var cl = c.toLowerCase();
        switch(cl) {
            case 'h':             
                idx[cl] = idx[cl]==undefined?0:idx[cl];
                ret += his[idx[cl]];
                idx[cl]+=1;
                break
                case 'h':
            case 'i':
                idx[cl] = idx[cl]==undefined?0:idx[cl];
                ret += his[2+idx[cl]];
                idx[cl]+=1;
                break                        
            case 's':
                idx[cl] = idx[cl]==undefined?0:idx[cl];
                ret += his[4+idx[cl]];
                idx[cl]+=1;
                break
            default:
                ret += c;
                break;
        }
    }

    return ret;
}

function log(a,b) {
//    userPeer.appendMsg(typeof a=="object"?JSON.stringify(a):a,"SYSTEN");
    //  if(b!=undefined) userPeer.appendMsg(typeof b=="object"?JSON.stringify(b):b,"SYSTEM");
    if(b!=undefined) console.log(a,b); else console.log(a);
}
</script>
    
  

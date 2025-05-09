<?php if($name = app::request("_video")) {  
    $ent = new video;
    $a = $ent->fetch("linked",$name);
    $this->pdata["video"] = $a;
} else app::redirect("/"); ?>
{{doc}}
    <head>
        {{head-main}}
    </head>
    <body>       
        {{back-to-top}}
        {{nav}}
        <table class="media-wrap">
            <tr id='nd-main'>
                <td class='nd-player-td text-center'>
                    {{video-player}}
                    <h2 class='ucase'>Related<span class='high-color'> videos</span> </h2>
                </td>
                <td class="nd-player-desktop">
                    <h2 id="desk_title" class='ucase nd-title-center'><span class='high-color'>More</span> videos</h2>
                    {{video-wall|random|v}}
                </td>
            </tr>
            <tr>
                <td colspan="2">                    
                    {{video-wall|related|h}}
                </td>
            </tr>
        </table>
        {{creative|last|400}}
        {{footer}}
        {{util-scripts}}        
    </body>
</html>    
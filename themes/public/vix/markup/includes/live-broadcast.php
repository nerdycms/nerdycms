<?php

/* 
 * Author: Simon Newton
 * ...
 */
$room = "test";
?>
<div class="live-wrap">
    <div class="live-video">
        <button class="cast-btn" onclick="startCast()">Start Casting</button>
        <video id="live_video" autoplay muted></video>                
    </div>
    <table>
        <tr style="vertical-align: bottom">
            <td>
                <h1>CAST</h1>
            </td>
            <td>
                <div id="chat" class="live-chat">        
                    <div id="chat_msg" class="live-msg"></div>
                </div>        
                <textarea id="live_send" style="display: none"></textarea>
            </td>
        </tr>
    </table>        
</div>

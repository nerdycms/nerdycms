<?php
header("Content-Type: text/xml");

// Author: Simon Newton
$video = new video(["where"=>"publish_status='Published'"]);
$videos = $video->fetch("newest");
?>
<rss version="2.0">
    <channel>
        <title>
            <![CDATA[ Newest Videos ]]>
        </title>
        <link><?=DOM.VDIR."videos"?></link>
        <description>
            <![CDATA[ ]]>
        </description>
        <lastBuildDate><?=date("D, d M Y H:i:s O")?></lastBuildDate>
        <?php foreach ($videos as $row) { ?>
        <item>
            <title>
                <![CDATA[ <?=htmlentities($row['title'])?> ]]>
            </title>
            <link><?=DOM.$video->meta($row,"player_url")?></link>
            <description>
                <![CDATA[ 
                    <a href="<?=DOM.$video->meta($row,"player_url")?>">
                    <img src="<?=$video->meta($row,"abs-poster")?>" border="0">
                    <br><?=htmlentities($row['title'])?></a> 
                ]]>
            </description>
            <pubDate><?=@date("D, d M Y H:i:s O",@strtotime($row['release_date']))?></pubDate>
            <guid><?=DOM.$video->meta($row,"player_url")?></guid>
            <!-- Include Twitter Card meta tags -->
            <twitter:card>summary_large_image</twitter:card>
            <twitter:title><?=htmlentities($row['title'])?></twitter:title>
            <twitter:image><?=$video->meta($row,"abs-poster")?></twitter:image>
        </item>
        <?php } ?>
    </channel>
</rss>

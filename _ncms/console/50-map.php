<?php

// Author: Simon Newton
require_once ROOT . '/vendor/map/Extensions/GoogleImageExtension.php';
require_once ROOT . '/vendor/map/Extensions/GoogleVideoExtension.php';
require_once ROOT . '/vendor/map/FileSystem.php';
require_once ROOT . '/vendor/map/Runtime.php';
require_once ROOT . '/vendor/map/SitemapGenerator.php';

define("SITEMAP_INT",24*3600);

class map {
    function schedule() {
        $last = @file_get_contents(SYS_CONTENT_DIR."/lastmap.txt");
        if(!$last || time()-$last >= SITEMAP_INT) {
            runner::tailJob("map", null);
            file_put_contents(SYS_CONTENT_DIR."/lastmap.txt", time());
        }
    }
    
    function run($rkey,$arg) {
        $yourSiteUrl = DOM;

        // Setting the current working directory to be output directory
        // for generated sitemaps (and, if needed, robots.txt)
        // The output directory setting is optional and provided for demonstration purposes.
        // The generator writes output to the current directory by default. 
        $outputDir = ROOT;

        $generator = new \Icamys\SitemapGenerator\SitemapGenerator($yourSiteUrl, $outputDir);

        // Create a compressed sitemap
        $generator->enableCompression();

        // Determine how many urls should be put into one file;
        // this feature is useful in case if you have too large urls
        // and your sitemap is out of allowed size (50Mb)
        // according to the standard protocol 50000 urls per sitemap
        // is the maximum allowed value (see http://www.sitemaps.org/protocol.html)
        $generator->setMaxUrlsPerSitemap(50000);

        // Set the sitemap file name
        $generator->setSitemapFileName("sitemap.xml");

        // Set the sitemap index file name
        $generator->setSitemapIndexFileName("sitemap-index.xml");

        // Add alternate languages if needed
        $alternates = [
            ['hreflang' => 'de', 'href' => "http://www.example.com/de"],
            ['hreflang' => 'fr', 'href' => "http://www.example.com/fr"],
        ];

        $entv = new video;
        $q = $entv->fetch("all");
        $idx = 0;
        while($a = $q->fetch_assoc()) {
            $videoTags = [
                'thumbnail_loc' => $entv->meta($a,"abs-poster"),
                'title' => $entv->meta($a,"title"),
                'description' => $entv->meta($a,"description"),
                'content_loc' => $entv->meta($a,"abs-preview"),
                //'player_loc' => $entv->meta($a,"abs-player_url"),
                'duration' => $entv->meta($a,"duration_secs")??300,
                //'expiration_date' => '2021-11-05T19:20:30+08:00',
                //'rating' => 4.2,
                //'view_count' => 12345,
                'publication_date' => $entv->meta($a,"release_date"),
                'family_friendly' => "no",
                /*'restriction' => [
                    'relationship' => 'allow',
                    'value' => 'IE GB US CA',
                ],
                'platform' => [
                    'relationship' => 'allow',
                    'value' => 'web mobile',
                ],
                'price' => [
                    [
                        'currency' => 'EUR',
                        'value' => 1.99,
                        'type' => 'rent',
                        'resolution' => 'hd',
                    ]
                ],*/
                'requires_subscription' => 'yes',                
                'live' => 'no',
                'tag' => 
                    explode(",",$entv->meta($a,"tags"))
                ,
                'category' => $entv->meta($a,"category"),
            ];


            $extensions = [
                'google_video' => $videoTags
            ];


            // Add url components: `path`, `lastmodified`, `changefreq`, `priority`, `alternates`
            // Instead of storing all urls in the memory, the generator will flush sets of added urls
            // to the temporary files created on your disk.
            // The file format is 'sm-{index}-{timestamp}.xml'
            $generator->addURL($entv->meta($a,"player_url"), new DateTime(), 'always', 0.5, null, $extensions);

            // Flush all stored urls from memory to the disk and close all necessary tags.
            if(++$idx%100==0) $generator->flush();
        }
        $generator->flush();
        
        $q = $entv->fetch("all");
        //$idx = 0;
        while($a = $q->fetch_assoc()) {                        
            $du = $entv->meta($a,"duration_secs")??300;
            $fr = 30;
            if($du<180) $fr = 10;
            if($du>600) $fr = 60;
            $frames = 1+$du/$fr;
            if($frames>31) $frames = 31;
            
            for($i=1;$i<$frames;$i++) {
                $su = $entv->meta($a,"scene_url:$i");
                $iu = $entv->meta($a,"scene:$i");
                if(!$iu || !$su) break;
                //if(!app::http_file_exists($iu)) break;
                                
                $imageTags = [
                    'loc'   => DOM.$su,
                    'image' => DOM.$iu,   
                    'title' => $entv->meta($a,"title"). " - SCENE $i"                    
                ];
                $extensions = [
                    'google_image' => $imageTags
                ];                
                $generator->addURL($su, new DateTime(), 'always', 0.5, null, $extensions);
                if(++$idx%100==0) $generator->flush();
            }
            for($i=1;$i<$frames;$i++) {
                $su = $entv->meta($a,"gvl_url:$i");
                $iu = $entv->meta($a,"gvl:$i");
                if(!$iu || !$su) break;
                                
                $imageTags = [                      
                    'loc'   => DOM.$su,
                    'image' => DOM.$iu,   
                    'title' => $entv->meta($a,"title"). " - SCENE $i"                    
                ];
                $extensions = [
                    'google_image' => $imageTags
                ];
                $generator->addURL($su, new DateTime(), 'always', 0.5, null, $extensions);
                if(++$idx%100==0) $generator->flush();
            }

            // Flush all stored urls from memory to the disk and close all necessary tags.
            
        }
        $generator->flush();

        $entb = new blog;
        $q = $entb->fetch("all");
        while($a = $q->fetch_assoc()) {
            $generator->addURL(VDIR."blog?_id=".$a['id'], new DateTime(), 'always', 0.5, null);
        }
        $generator->flush();
        
        $entb = new customPage;
        $q = $entb->fetch("all");
        while($a = $q->fetch_assoc()) {
            $generator->addURL(VDIR.$a['hook'], new DateTime(), 'always', 0.5, null);
        }
        $generator->flush();
        
        $fixed = ["videos","categories","video-tags","models","customer-service","report"];
        foreach($fixed as $f) {            
            $generator->addURL(VDIR.$f, new DateTime(), 'always', 0.5, null);
        }
        $generator->flush();

        // Move flushed files to their final location. Compress if the option is enabled.
        $generator->finalize();

        // Update robots.txt file in output directory or create a new one
        $generator->updateRobots();

        // Submit your sitemaps to Google, Yahoo, Bing and Ask.com
        var_dump($generator->submitSitemap());
    }
}
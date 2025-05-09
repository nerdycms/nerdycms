<?php

/*
 * Author: Simon Newton
 * ...
 */

 define("VERSION",4);

class update {    
    static function rem($url) {
        return file_get_contents(UPDATE_DOMAIN."/".$url);
    }
    
    static function available() {        
        $version = VERSION;
        $available = self::rem("cms-releases.txt");        
        return (int)$available>$version?$available:false;
    }
        
    static function upgrade() {
        ini_set('memory_limit','1024M');
        $available = (int)self::rem("cms-releases.txt");
        @mkdir(ROOT."/content/migrate");
        @mkdir($dir = ROOT."/content/migrate/$available");
        file_put_contents("$dir/release.zip",self::rem("releases/cms-latest.zip"));
        shell_exec("cd $dir && unzip -q ./release.zip && php ./boot.php");
    }
}
